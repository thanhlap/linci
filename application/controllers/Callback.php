<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller {
	
	public function index()
	{
		$accessToken = 'fc0oTVl6156HKVz3FUz8t1nlvC1OpZMYy9IWmSblG1HKEy5bKUI28YqIz70Gbcr0fEYusYUoOAqneRqIPpe4q1ARZ36TwLj+XBQhqXfimafkhHdsW4bXmmTjen9Dpt110AbUy3aEeFJ0PJp9RncxMAdB04t89/1O/w1cDnyilFU=';
		
		$jsonString = file_get_contents('php://input');
		//$jsonString = '{"events":[{"type":"message","replyToken":"a0bd76fe7d50445cafa76229aeaeaec8","source":{"userId":"U2c424933e5678e93fc68a2f631bc2818","type":"user"},"timestamp":1502685265679,"message":{"type":"text","id":"6540861500362","text":"予約"}}]}';
		error_log($jsonString);
		$jsonObj = json_decode($jsonString);

		$source = $jsonObj->{"events"}[0]->{"source"};
		$source_user_id = $source->{"userId"};
		$message = $jsonObj->{"events"}[0]->{"message"};
		$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
		
		$dataLog = array(
				'key_name' => 'jsonString',
				'key_value' => $jsonString
		);
		$this->load->model('Log_model');
		$this->Log_model->insert($dataLog);
		$this->load->model('Chat_log');
		$lastMsg = $this->Chat_log->getLastMsgByUserID($source_user_id);
		$step = $lastMsg['step'];
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
		
		// 送られてきたメッセージの中身からレスポンスのタイプを選択
		if (($message->{"text"} == '予約') || ($message->{"text"} == '予約する')) {
			$data_chat['step'] = 1;
			$this->Chat_log->insert($data_chat);
			// それ以外は送られてきたテキストをオウム返し
// 			$messageData = [
// 					'type' => 'text', 'text' => '携帯番号を入力してください。'
// 			];
			$messageData = array(array('type' => 'text', 'text' => "携帯番号を入力してください。"), array('type' => 'text', 'text' => 'start'));
			
// 			$messageData = array(
// 				array('type' => 'text', 'text' => '携帯番号を入力してください。'),
// 				array('type' => 'text', 'text' => '1')
// 			);
		} else{
			switch ($step){
				case 1:
					$data_chat['step'] = 2;
					$data_chat['message_ref'] = $message->{"text"};
					$replyMsg = 'パスワードを入力してください。';

					$messageData = array(array('type' => 'text', 'text' => $replyMsg), array('type' => 'text', 'text' => 'step ' . $step));
					
					break;
				case 2:
					$this->load->library('eyelash_api');
					$result = $this->eyelash_api->login($lastMsg['message_ref'], $message->{"text"});
					$data_chat['message_ref'] = 'mobile: ' . $lastMsg['message_ref'] . ', password: ' . $message->{"text"};
					if ($result['result'] == "true"){
						$data_chat['step'] = 3;
						$replyMsg = '店舗を入力してください。';
						$messageData = array(array('type' => 'text', 'text' => $replyMsg), array('type' => 'text', 'text' => 'step ' . $step));
						
					}else{
						$data_chat['step'] = 1;
						$replyMsg = 'Mobile number and password is not valid.';
						//$messageData = array(array('type' => 'text', 'text' => $replyMsg), array('type' => 'text', 'text' => '携帯番号を入力してください。'));
						$messageData = array(array('type' => 'text', 'text' => $replyMsg), array('type' => 'text', 'text' => '携帯番号を入力してください。'));
						
					}
					
					break;
				default:
					$replyMsg = $message->{"text"};
					$messageData = array(array('type' => 'text', 'text' => $replyMsg), array('type' => 'text', 'text' => 'step ' . $step));
			}
			
// 			$messageData = [
// 					'type' => 'text',
// 					'text' => $replyMsg
// 			];
			$this->Chat_log->insert($data_chat);
		}
		
		if ($message->{"text"} == '確認') {
			// 確認ダイアログタイプ
			$messageData = [
					'type' => 'template',
					'altText' => '確認ダイアログ',
					'template' => [
							'type' => 'confirm',
							'text' => '元気ですかー？',
							'actions' => [
									[
											'type' => 'message',
											'label' => '元気です',
											'text' => '元気です'
									],
									[
											'type' => 'message',
											'label' => 'まあまあです',
											'text' => 'まあまあです'
									],
							]
					]
			];
		} elseif ($message->{"text"} == 'ボタン') {
			// ボタンタイプ
			$messageData = [
					'type' => 'template',
					'altText' => 'ボタン',
					'template' => [
							'type' => 'buttons',
							'title' => 'タイトルです',
							'text' => '選択してね',
							'actions' => [
									[
											'type' => 'postback',
											'label' => 'webhookにpost送信',
											'data' => 'value'
									],
									[
											'type' => 'uri',
											'label' => 'googleへ移動',
											'uri' => 'https://google.com'
									]
							]
					]
			];
		} elseif ($message->{"text"} == 'カルーセル') {
			// カルーセルタイプ
			$messageData = [
					'type' => 'template',
					'altText' => 'カルーセル',
					'template' => [
							'type' => 'carousel',
							'columns' => [
									[
											'title' => 'カルーセル1',
											'text' => 'カルーセル1です',
											'actions' => [
													[
															'type' => 'postback',
															'label' => 'webhookにpost送信',
															'data' => 'value'
													],
													[
															'type' => 'uri',
															'label' => '美容の口コミ広場を見る',
															'uri' => 'http://clinic.e-kuchikomi.info/'
													]
											]
									],
									[
											'title' => 'カルーセル2',
											'text' => 'カルーセル2です',
											'actions' => [
													[
															'type' => 'postback',
															'label' => 'webhookにpost送信',
															'data' => 'value'
													],
													[
															'type' => 'uri',
															'label' => '女美会を見る',
															'uri' => 'https://jobikai.com/'
													]
											]
									],
							]
					]
			];
		} else {
// 			// それ以外は送られてきたテキストをオウム返し
// 			$messageData = [
// 					'type' => 'text',
// 					'text' => $message->{"text"}
// 			];
		}
		
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
		error_log($result);
		curl_close($ch);
	}
}
