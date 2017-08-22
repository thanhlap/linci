<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller {
	
	public function index()
	{
		$accessToken = 'CCTtRhug6RnXVdzkA88/gSRGGs28FtVCLrU1J0kEHB9pbzTgjM+j4S33vpj0uG1yHpTP67spi9zuY3WZVuSQueHXmJztPhyziWO13It8T3N+lvO4XEamCez7HhW1VvLjdXkVLCFEcy9XetSieJ2+IQdB04t89/1O/w1cDnyilFU=';
		
		$jsonString = file_get_contents('php://input');

		//save table log
		error_log($jsonString);
		$jsonObj = json_decode($jsonString);
		$this->load->model('Log_model');
		$this->saveLog('jsonString', $jsonString);

		$source = $jsonObj->{"events"}[0]->{"source"}; //vao mang source trong table log
		$source_user_id = $source->{"userId"};   //lay id suorce cua bang table log
		$message = $jsonObj->{"events"}[0]->{"message"}; //vao mang message
		$message_text = $message->{"text"};
		$message_type = $jsonObj->{"events"}[0]->{"type"};
		$replyToken = $jsonObj->{"events"}[0]->{"replyToken"}; //lay replyToken


		//Chat_log
		$this->load->model('Chat_log');
		$lastMsg = $this->Chat_log->getLastMsgByUserID($source_user_id);
		//$step = $lastMsg['step'];
		$replyMsg = "";

		$data_chat = array(
				'type' => $jsonObj->{"events"}[0]->{"type"},
				'reply_token' => $replyToken,
				'source_type' => $source->{"type"},
				'source_user_id' => $source_user_id,
				'message_time' => $jsonObj->{"events"}[0]->{"timestamp"},
				'message_type' => $message->{"type"},
				'message_id' => $message->{"id"},
				'message_text' => $message->{"text"},
				'message_ref' => '',
				'step' => 1
		);
		
		$this->load->model('Order_info');
		$orderUpdate = true;
		$is_child = '';

		// 送られてきたメッセージの中身からレスポンスのタイプを選択
		if (($message->{"text"} == '予約') || ($message->{"text"} == '予約する')) {
			
			// save table chat_log
			$data_chat['step'] = 1;
			$this->Chat_log->insert($data_chat);
			
			//save Order Info
			$dataOrder['source_user_id'] = $source_user_id;
			$dataOrder['step'] = 1;
			$dataOrder['created'] = Date('Y-m-d H:i:s');
			$this->Order_info->insert($dataOrder);
			
			// それ以外は送られてきたテキストをオウム返し
			$messageData = array(
				array('type' => 'text', 'text' => "携帯番号を入力してください。?"),
				array('type' => 'text', 'text' => 'start'));

		} else{

			$lastOrder = $this->Order_info->getLastOrderInfoByUserID($source_user_id);
			if ($lastOrder == null){
				//k/co order báo msg
				$messageData = array(
					array('type' => 'text', 'text' => "「予約」または「予約する」を入力してください。"), 
					array('type' => 'text', 'text' => $message_text));
			}else{

				$this->load->library('eyelash_api');
				$step = $lastOrder['step'];
				//$step = 4;
				switch ($step){
					case 1: // pass
						$data_chat['step'] = 2;
						$data_chat['message_ref'] = $message->{"text"};
						$lastOrder['step'] = 2;
						$lastOrder['username'] = $message_text; //gán username vào order
						$replyMsg = 'パスワードを入力してください。?';
						$messageData = array(
							array('type' => 'text', 'text' => $replyMsg), 
							array('type' => 'text', 'text' => 'step ' . $step));
					break;
					case 2://kt phone&&pass
						$result = $this->eyelash_api->login($lastMsg['message_ref'], $message->{"text"});

						$lastOrder['password'] = $message_text;//gán pass vào order
						$data_chat['message_ref'] = 'mobile: ' . $lastMsg['message_ref'] . ', password: ' . $message->{"text"}; //save phone&&pass chat_log
						
						if ($result['result'] == "true"){
							$data_chat['step'] = 3;
							$lastOrder['step'] = 3;
							
							$replyMsg = '店舗を入力してください。';
							$listStores = 'Have not any store.';

							//lấy ds cữa hàng
							$list = $this->eyelash_api->listStore($lastOrder['username'],$lastOrder['password']);
							if ($list != null){
								$stores = $list["response"]["Items"]["Item"];//lấy mảng item
								if(($stores != NULL) && (count($stores) > 0)){
									$listStores = '';
									foreach ($stores as $store){
										if ($listStores != '')
											$listStores .= $store['store_name'];
											$listStores .= "\n\n";
									}
								}
							}
							$messageData = array(
								array('type' => 'text', 'text' => $replyMsg),
								array('type' => 'text', 'text' => $listStores));
						
						}else{
							$data_chat['step'] = 1;
							$lastOrder['step'] = 1;
							$replyMsg = 'Mobile number and password are not valid.';
							//nhập phone
							$messageData = array(
								array('type' => 'text', 'text' => $replyMsg),
								array('type' => 'text', 'text' => '携帯番号を入力してください。'));

						}
					break;

					case 3:
						$replyMsg = '店舗を入力してください。';
						$listStores = 'Have not any store.';
						$results = $this->eyelash_api->listStore();
						if ($results != null){
							$stores = $results["response"]["Items"]["Item"];
							if(($stores != NULL) && (count($stores) > 0)){
								$arrStores = array();
								$listStores = '';
								foreach ($stores as $store){
									if (strpos($store['store_name'], $message_text) !== false) {
										$arrStores[] = $store;
										if ($listStores != '')
											$listStores .= $store['store_name'];
											$listStores .= "\n\n";
									}
								}
								//$messageData = array(array('type' => 'text', 'text' => $replyMsg), array('type' => 'text', 'text' => $listStores));
								if (count($arrStores) > 4){
									$data_chat['step'] = 3;
									$lastOrder['step'] = 3;
									$messageData = array(
										array('type' => 'text', 'text' => $replyMsg), 
										array('type' => 'text', 'text' => $listStores));
								}else{

									//search hiện button
									$data_chat['step'] = 4;
									$lastOrder['step'] = 4;
									$arrActions = array();
									for ($i = 0; $i < count($arrStores); $i++){
										$action = array();
										$action['type'] = 'postback';
										$action['label'] = $arrStores[$i]['store_name'];
										$action['data'] = 'key=store&value=' . $arrStores[$i]['store_id'];
										//$action['data'] = $arrStores[$i]['store_id'];
										$action['text'] = $arrStores[$i]['store_name'];
										$arrActions[] = $action;
									}
									//ボタンタイプ
									$messageData = [array(
											'type' => 'template',
											'altText' => $replyMsg,
											'template' => array(
													'type' => 'buttons',
													'title' => '店舗',
													'text' => '選択してね',
													'actions' => $arrActions
											)
									)];
								}
							}
						}else{
							$messageData = array(
								array('type' => 'text', 'text' => $replyMsg),
								array('type' => 'text', 'text' => $listStores));
						}
					
					break;

					case 4:
					//lấy $store_id cửa hàng đó luu vào order_info
						if ($message_type == 'postback'){
							$data_chat['step'] = 5;
							$data_chat['message_ref'] = $store_id;
	// 						$store_id = $jsonObj->{"events"}[0]->{"postback"};
	// 						$store_id = $store_id->{"data"};
							$dataPB = $jsonObj->{"events"}[0]->{"postback"};
							$dataPB = $dataPB->{"data"};
							//$this->saveLog("dataPB", $dataPB);
							parse_str($dataPB, $postbackData);
							//$this->saveLog("store_id", $postbackData['value']);
							$lastOrder['step'] = 5;
							$lastOrder['store_id'] = $postbackData['value'];
						}
					break;

					case 5:
						//search store_id để lấy ds người phụ trách
						if ($message_type == 'message'){
							$listStaffs = 'Have not any staff.';
							if($lastOrder['store_id'] && $lastOrder['store_id'] != ''){
								$data_chat['step'] = 6;
								$lastOrder['step'] = 6;
								$replyMsg = '担当者を入力してください。';
								$results = $this->eyelash_api->listStaff($lastOrder['username'], $lastOrder['password'], $lastOrder['store_id']);
								if ($results != null){
									$staffs = $results["response"]["Items"]["Item"];
									$arrStaffs = $this->filterStaffs($staffs);
									if (count($arrStaffs) > 0)
										$listStaffs = implode("\n", $arrStaffs);
								}
							}
							$messageData = array(
								array('type' => 'text', 'text' => $replyMsg), 
								array('type' => 'text', 'text' => $listStaffs));
						}
						
					break;

					case 6://chon nguoi phu trach
						$replyMsg = '担当者を入力してください。';
						$listStaffs = 'Have not any staffs.';
						$results = $this->eyelash_api->listStaff($lastOrder['username'], $lastOrder['password'], $lastOrder['store_id']);
						if ($results != null){
							$staffs = $results["response"]["Items"]["Item"];
							$arrStaffs = $this->filterStaffs($staffs, $message_text);
							//show list staff
							if (count($arrStaffs) > 4){
								$listStaffs = implode("\n", $arrStaffs);
								$messageData = array(
									array('type' => 'text', 'text' => $replyMsg),
									array('type' => 'text', 'text' => $listStaffs));
							}elseif (count($arrStaffs) > 0){//Show button staffs

								$data_chat['step'] = 7;
								$lastOrder['step'] = 7;

								$arrActions = array();
								foreach ($arrStaffs as $staff_id => $staff_name){
									$action = array();
									$action['type'] = 'postback';
									$action['label'] = $staff_name;
									$action['data'] = 'key=staff&value=' . $staff_id;
									$action['text'] = $staff_name;
									$arrActions[] = $action;
								}
								//ボタンタイプ
								$messageData = [array(
										'type' => 'template',
										'altText' => $replyMsg,
										'template' => array(
												'type' => 'buttons',
												'title' => '担当者',
												'text' => '選択してね',
												'actions' => $arrActions
										)
								)];
								
							}else{
								$arrStaffs = $this->filterStaffs($staffs);
								$listStaffs = implode("\n", $arrStaffs);
								$messageData = array(
									array('type' => 'text', 'text' => $replyMsg),
									array('type' => 'text', 'text' => $listStaffs));
							}
						}			
					break;

					case 7:
						//lấy $treatment_id cửa hàng đó luu vào order_info
						if ($message_type == 'postback'){
							$data_chat['step'] = 8;
							// $data_chat['message_ref'] = $treatment_id;

							$dataPB = $jsonObj->{"events"}[0]->{"postback"};
							$dataPB = $dataPB->{"data"};
							//$this->saveLog("dataPB", $dataPB);
							parse_str($dataPB, $postbackData);
							//$this->saveLog("store_id", $postbackData['value']);
							$lastOrder['step'] = 8;
							$lastOrder['treatment_id'] = $lastOrder['store_id'];
							// $lastOrder['treatment_id'] = $postbackData['value'];
						}
					break;

					case 8: 
						//search treatment_id để lấy tât cả dịch vụ
						if ($message_type == 'message'){
							$listtreatment = 'Have not any staff.';
							if($lastOrder['treatment_id'] && $lastOrder['treatment_id'] != ''){
								$data_chat['step'] = 9;
								$lastOrder['step'] = 9;
								$replyMsg = '施術一覧からタップ';
								// $results = $this->eyelash_api->listtreatment($lastOrder['username'], $lastOrder['password'], $lastOrder['treatment_id']);
						
								$results = $this->eyelash_api->listtreatment($lastOrder['username'], $lastOrder['password'], $lastOrder['treatment_id']);
				
								if ($results != null){
									$treatment = $results["response"]["Items"]["Item"];
									$arrtreatment = $this->filtertreatment($treatment);
									if (count($arrtreatment) > 0)
										$listtreatment = implode("\n", $arrtreatment);
								}
							}
							$messageData = array(
								array('type' => 'text', 'text' => $replyMsg), 
								array('type' => 'text', 'text' => $listtreatment));
						}
						
					break;

					case 9://DS DỊCH VỤ
						$replyMsg = '施術一覧からタップ';
						$listtreatment = 'Have not any staffs.';
		
						$results = $this->eyelash_api->listtreatment($lastOrder['username'], $lastOrder['password'], $lastOrder['treatment_id']);
						
						if ($results != null){
							$treatment = $results["response"]["Items"]["Item"];
							
							$arrtreatment = $this->filtertreatment($treatment, $message_text);
							//show list staff
							if (count($arrtreatment) > 4){
								// $listtreatment = implode("\n", $arrtreatment);
								$listtreatment .= $treatment['name'];
								$listtreatment .= "\n\n";

								$messageData = array(
									array('type' => 'text', 'text' => $replyMsg),
									array('type' => 'text', 'text' => $listtreatment));

							}elseif (count($arrtreatment) > 0){//Show button treatment

								$data_chat['step'] = 10;
								$lastOrder['step'] = 10;

								$arrActions = array();
								foreach ($arrtreatment as $treatment_id => $treatment_name){
									$action = array();
									$action['type'] = 'postback';
									$action['label'] = $treatment_name;
									$action['data'] = 'key=treatment&value=' . $treatment_id;
									$action['text'] = $treatment_name;
									$arrActions[] = $action;
								}
								//ボタンタイプ
								$messageData = [array(
										'type' => 'template',
										'altText' => $replyMsg,
										'template' => array(
												'type' => 'buttons',
												'title' => '担当者',
												'text' => '選択してね',
												'actions' => $arrActions
										)
								)];
								
							}else{
								$arrtreatment = $this->filtertreatment($treatment);
								$listtreatment = implode("\n", $arrtreatment);
								$messageData = array(
									array('type' => 'text', 'text' => $replyMsg),
									array('type' => 'text', 'text' => $listtreatment));
							}


						}	

					break;

					case 10:
						//lấy $treatment_id cửa hàng đó luu vào order_info
						if ($message_type == 'postback'){
							$data_chat['step'] = 11;
							// $data_chat['message_ref'] = $treatment_id;

							$dataPB = $jsonObj->{"events"}[0]->{"postback"};
							$dataPB = $dataPB->{"data"};
							//$this->saveLog("dataPB", $dataPB);
							parse_str($dataPB, $postbackData);
							//$this->saveLog("store_id", $postbackData['value']);
							$lastOrder['step'] = 11;
							$lastOrder['menu_id'] = $lastOrder['store_id'];
							// $lastOrder['treatment_id'] = $postbackData['value'];
						}
					break;

					case 11: 
						//search menu_id để lấy tât cả dịch vụ
						if ($message_type == 'message'){
							$listmenu = 'Have not any staff.';
							if($lastOrder['menu_id'] && $lastOrder['menu_id'] != ''){
								$data_chat['step'] = 12;
								$lastOrder['step'] = 12;
								$replyMsg = 'セットメニュー一覧からタップ';
						
								$results = $this->eyelash_api->listsetmenu($lastOrder['username'], $lastOrder['password'], $lastOrder['menu_id']);
				
								if ($results != null){
									$menu = $results["response"]["Items"]["Item"];
									$arrmenu = $this->filtertreatment($menu);
									if (count($arrmenu) > 0)
										$listmenu = implode("\n", $arrmenu);
								}
							}
							$messageData = array(
								array('type' => 'text', 'text' => $replyMsg), 
								array('type' => 'text', 'text' => $listmenu));
						}
						
					break;

					case 12://DS DỊCH VỤ
						$replyMsg = 'セットメニュー一覧からタップ';
						$listmenu = 'Have not any staffs.';
		
						$results = $this->eyelash_api->listsetmenu($lastOrder['username'], $lastOrder['password'], $lastOrder['menu_id']);
						
						if ($results != null){
							$menu = $results["response"]["Items"]["Item"];
							
							$arrmenu = $this->filtertreatment($menu, $message_text);
							//show list staff
							if (count($arrmenu) > 4){
								// $listmenu = implode("\n", $arrmenu);
								$listmenu .= $menu['name'];
								$listmenu .= "\n\n";

								$messageData = array(
									array('type' => 'text', 'text' => $replyMsg),
									array('type' => 'text', 'text' => $listmenu));

							}elseif (count($arrmenu) > 0){//Show button menu

								$data_chat['step'] = 13;
								$lastOrder['step'] = 13;

								$arrActions = array();
								foreach ($arrmenu as $menu_id => $menu_name){
									$action = array();
									$action['type'] = 'postback';
									$action['label'] = $menu_name;
									$action['data'] = 'key=menu&value=' . $menu_id;
									$action['text'] = $menu_name;
									$arrActions[] = $action;
								}
								//ボタンタイプ
								$messageData = [array(
										'type' => 'template',
										'altText' => $replyMsg,
										'template' => array(
												'type' => 'buttons',
												'title' => '担当者',
												'text' => '選択してね',
												'actions' => $arrActions
										)
								)];
								
							}else{
								$arrmenu = $this->filtertreatment($menu);
								$listmenu = implode("\n", $arrmenu);
								$messageData = array(
									array('type' => 'text', 'text' => $replyMsg),
									array('type' => 'text', 'text' => $listmenu));
							}


						}	

					break;


					case 13:
						//lấy $practitioner_id date đó luu vào order_info
						if ($message_type == 'postback'){
							$data_chat['step'] = 14;
							// $data_chat['message_ref'] = $practitioner_id;

							$dataPB = $jsonObj->{"events"}[0]->{"postback"};
							$dataPB = $dataPB->{"data"};
							//$this->saveLog("dataPB", $dataPB);
							parse_str($dataPB, $postbackData);
							//$this->saveLog("store_id", $postbackData['value']);
							$lastOrder['step'] = 14;
							// $lastOrder['practitioner_id'] = $lastOrder['store_id'];
							$lastOrder['practitioner_id'] = $postbackData['value'];
						}
					break;

					case 14: 
						//search practitioner_id để lấy tât cả date
						if ($message_type == 'message'){
							$listdate = 'Have not any staff.';
							if($lastOrder['practitioner_id'] && $lastOrder['practitioner_id'] != ''){
								$data_chat['step'] = 15;
								$lastOrder['step'] = 15;
								$replyMsg = '予約日を入力してください。(例) 20180731';
								// $results = $this->eyelash_api->listdate($lastOrder['username'], $lastOrder['password'], $lastOrder['practitioner_id']);
						
								$results = $this->eyelash_api->listdate($lastOrder['username'], $lastOrder['password'], $lastOrder['practitioner_id']);
				
								if ($results != null){
									$date = $results["search"]["date"];
									
									$arrdate = $this->filterdate($date);
									if (count($arrdate) > 0)
										$listdate = implode("\n", $arrdate);
								}
							}
							$messageData = array(
								array('type' => 'text', 'text' => $replyMsg), 
								array('type' => 'text', 'text' => $listdate));
						}
						
					break;

					case 15://DS time
						$replyMsg = '予約日を入力してください。(例) 20180731';
						$listdate = 'Have not any staffs.';
		
						$results = $this->eyelash_api->listdate($lastOrder['username'], $lastOrder['password'], $lastOrder['practitioner_id']);
						
						if ($results != null){
							$date = $results["search"]["date"];
							
							$arrdate = $this->filterdate($date, $message_text);
							//show list staff
							if (count($arrdate) > 4){
								// $listdate = implode("\n", $arrdate);
								$listdate .= $date;
								$listdate .= "\n\n";

								$messageData = array(
									array('type' => 'text', 'text' => $replyMsg),
									array('type' => 'text', 'text' => $listdate));

							}elseif (count($arrdate) > 0){//Show button date

								$data_chat['step'] = 16;
								$lastOrder['step'] = 16;

								$arrActions = array();
								foreach ($arrdate as $date_id => $date_name){
									$action = array();
									$action['type'] = 'postback';
									$action['label'] = $date_name;
									$action['data'] = 'key=date&value=' . $date_id;
									$action['text'] = $date_name;
									$arrActions[] = $action;
								}
								//ボタンタイプ
								$messageData = [array(
										'type' => 'template',
										'altText' => $replyMsg,
										'template' => array(
												'type' => 'buttons',
												'title' => '担当者',
												'text' => '選択してね',
												'actions' => $arrActions
										)
								)];
								
							}else{
								$arrdate = $this->filterdate($date);
								$listdate = implode("\n", $arrdate);
								$messageData = array(
									array('type' => 'text', 'text' => $replyMsg),
									array('type' => 'text', 'text' => $listdate));
							}


						}	

					break;


					default:
						$orderUpdate = false;
						$replyMsg = $message->{"text"};
						$messageData = array(
							array('type' => 'text', 'text' => $replyMsg),
							array('type' => 'text', 'text' => 'step ' . $step),
							array('type' => 'text', 'text' => $lastOrder['practitioner_id'])
						);
						
				}// switch ($step){ END
				if($orderUpdate)
					$this->Order_info->update($lastOrder);
				
			} //if ($lastOrder == null){ END
		}// 送られてきたメッセージの中身からレスポンスのタイプを選択 END
		//save chat log debug
		$this->Chat_log->insert($data_chat);
		
		//test
		//$messageData = $this->testChat($message);
		
		if ($message_type == 'message'){
			$response = [
					'replyToken' => $replyToken,
					'messages' => $messageData
					//'messages' => [$messageData, array('type' => 'step', 'text' => $step)]
					//'messages' => array(array('type' => 'text', 'text' => "qw"), array('type' => 'text', 'text' => '1234'))
			];
			error_log(json_encode($response));
			
			$ch = curl_init('https://api.line.me/v2/bot/message/reply');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json; charser=UTF-8',
					'Authorization: Bearer ' . $accessToken
			));
			$result = curl_exec($ch);
			
			$this->saveLog($result, json_encode($response));
			
			error_log($result);
			curl_close($ch);
		}
	}
	


	function saveLog($key, $value){
		$errorLog = array(
				'key_name' => $key,
				'key_value' => $value
		);
		$this->Log_model->insert($errorLog);
	}
	
	function filterItems($items, $keyword = ''){
		$arrItems = array();
		if(($items != NULL) && (count($items) > 0)){
			foreach ($items as $item){
				$obj['id'] = $item['store_id'];
				$obj['name'] = $item['store_name'];
				if ($keyword != ''){
					if (strpos($item['store_name'], $keyword) !== false) {
						$arrItems[] = $obj;
					}
				}
				else
					$arrItems[] = $obj;
			}
		}
		return $arrItems;
	}
	
	//search người phụ trách
	function filterStaffs($items, $keyword = ''){
		$arrItems = array();
		if(($items != NULL) && (count($items) > 0)){
			foreach ($items as $item){
				if ($keyword != ''){
					if (strpos($item['lastname'], $keyword) !== false) {
						$arrItems[$item['staff_id']] = $item['lastname'];
					}
				}
				else
					$arrItems[$item['staff_id']] = $item['lastname'];
			}
		}
		return $arrItems;
	}


	//search dịch vụ
	function filtertreatment($items, $keyword = ''){
		$arrItems = array();
		if(($items != NULL) && (count($items) > 0)){
			foreach ($items as $item){
				if ($keyword != ''){
					if (strpos($item['name'], $keyword) !== false) {
						$arrItems[$item['practitioner_id']] = $item['name'];
					}
				}
				else
					$arrItems[$item['practitioner_id']] = $item['name'];
			}
		}
		return $arrItems;
	}
	
	//search date
	function filterdate($items, $keyword = ''){
		$arrItems = array();
		if(($items != NULL) && (count($items) > 0)){
			foreach ($items as $item){
				if ($keyword != ''){
					if (strpos($item['date'], $keyword) !== false) {
						$arrItems[$item['practitioner_id']] = $item['date'];
					}
				}
				else
					$arrItems[$item['practitioner_id']] = $item['date'];
			}
		}
		return $arrItems;
	}



	// function testChat($message){
	// 	if ($message->{"text"} == '確認') {
	// 		// 確認ダイアログタイプ
	// 		$messageData = [
	// 				'type' => 'template',
	// 				'altText' => '確認ダイアログ',
	// 				'template' => [
	// 						'type' => 'confirm',
	// 						'text' => '元気ですかー？',
	// 						'actions' => [
	// 								[
	// 										'type' => 'message',
	// 										'label' => '元気です',
	// 										'text' => '元気です'
	// 								],
	// 								[
	// 										'type' => 'message',
	// 										'label' => 'まあまあです',
	// 										'text' => 'まあまあです'
	// 								],
	// 						]
	// 				]
	// 		];
	// 	} elseif ($message->{"text"} == 'ボタン') {
	// 		// ボタンタイプ
	// 		$messageData = [
	// 				'type' => 'template',
	// 				'altText' => 'ボタン',
	// 				'template' => [
	// 						'type' => 'buttons',
	// 						'title' => 'タイトルです',
	// 						'text' => '選択してね',
	// 						'actions' => [
	// 								[
	// 										'type' => 'postback',
	// 										'label' => 'webhookにpost送信',
	// 										'data' => 'value'
	// 								],
	// 								[
	// 										'type' => 'uri',
	// 										'label' => 'googleへ移動',
	// 										'uri' => 'https://google.com'
	// 								]
	// 						]
	// 				]
	// 		];
	// 		// 								$messageData = array(array(
	// 		// 										'type' => 'template',
	// 		// 										'altText' => 'ボタン',
	// 		// 										'template' => array(
	// 				// 												'type' => 'buttons',
	// 		// 												'title' => 'タイトルです',
	// 		// 												'text' => '選択してね',
	// 		// 												'actions' => array(
	// 				// 														array(
	// 						// 																'type' => 'postback',
	// 						// 																'label' => 'webhookにpost送信',
	// 						// 																'data' => 'value'
	// 						// 														),
	// 		// 														array(
	// 				// 																'type' => 'uri',
	// 		// 																'label' => 'googleへ移動',
	// 		// 																'uri' => 'https://google.com'
	// 		// 														)
	// 		// 												)
	// 		// 										)
	// 		// 								));
					
	// 	} elseif ($message->{"text"} == 'カルーセル') {
	// 		// カルーセルタイプ
	// 		$messageData = [
	// 				'type' => 'template',
	// 				'altText' => 'カルーセル',
	// 				'template' => [
	// 						'type' => 'carousel',
	// 						'columns' => [
	// 								[
	// 										'title' => 'カルーセル1',
	// 										'text' => 'カルーセル1です',
	// 										'actions' => [
	// 												[
	// 														'type' => 'postback',
	// 														'label' => 'webhookにpost送信',
	// 														'data' => 'value'
	// 												],
	// 												[
	// 														'type' => 'uri',
	// 														'label' => '美容の口コミ広場を見る',
	// 														'uri' => 'http://clinic.e-kuchikomi.info/'
	// 												]
	// 										]
	// 								],
	// 								[
	// 										'title' => 'カルーセル2',
	// 										'text' => 'カルーセル2です',
	// 										'actions' => [
	// 												[
	// 														'type' => 'postback',
	// 														'label' => 'webhookにpost送信',
	// 														'data' => 'value'
	// 												],
	// 												[
	// 														'type' => 'uri',
	// 														'label' => '女美会を見る',
	// 														'uri' => 'https://jobikai.com/'
	// 												]
	// 										]
	// 								],
	// 						]
	// 				]
	// 		];
	// 	} else {
	// 					// それ以外は送られてきたテキストをオウム返し
	// 					$messageData = [
	// 							'type' => 'text',
	// 							'text' => $message->{"text"}
	// 					];
	// 	}
	// 	return [$messageData];
	// }
	
}
