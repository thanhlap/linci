<?php
class Eyelash_api{
	
	
	// M / 08041320468
	// API Login
	function login($mobile, $password)
	{
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
				CURLOPT_URL => "https://web.eyelashs.jp/Procare1/api/login/customers.xml",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n
										<xml>\n    
											<auth>\n        
												<username>$mobile</username>\n        
												<password>$password</password>\n    
											</auth>\n    
											<lang>en</lang><!--ja:日本語 zh_CN:中国語(簡体字) zh_TW:中国語(繁体字) en:英語-->\n    
											<datetime>2017-08-02 16:18:27</datetime>\n    
											<action>login_customers</action>\n    
											<device_type>0</device_type>\n    
											<device_token></device_token>\n
										</xml>",
				CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: application/xml",
						"postman-token: 1f92d12d-8c6d-e5c0-d2c9-9ed54dd5d952"
				),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			//echo "cURL Error #:" . $err;
			return null;
		} else {
			$result = json_decode(json_encode(simplexml_load_string($response)), true);
			return $result;
		}
	}
	
	// API get list store
	function listStore($mobile, $password )
	{
		$api_time = Date('Y-m-d H:i:s');
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_URL => "https://web.eyelashs.jp/Procare1/api/stores/list.xml",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r
										<xml>\r    
											<auth>\r        
												<username>$mobile</username>\r        
												<password>$password</password>\r   
											</auth>\r    
												<lang>en</lang>\r    
												<datetime>$api_time</datetime>\r    
												<action>stores</action>\r  
											<search>\r     
												<store_id>$store_id</store_id>\r     
												<honbuflg>0</honbuflg>\r        
												<sort><sort>ASC</sort></sort>\r   
											</search>\r
										</xml>\r",
					CURLOPT_HTTPHEADER => array(
							"cache-control: no-cache",
							"content-type: application/xml",
							"postman-token: c8f630f3-32bb-2cdd-8612-77be24c9b717"
					),
			));
	
		$response = curl_exec($curl);
		$err = curl_error($curl);
	
		curl_close($curl);
	
		if ($err) {
// 			echo "cURL Error #:" . $err;
			return  null;
		} else {
			$list = json_decode(json_encode(simplexml_load_string($response)), true);
			return $list;
		}
	}
	
	// API get list staff
	function listStaff($mobile, $password, $store_id)
	{
		$api_time = Date('Y-m-d H:i:s');
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
				CURLOPT_URL => "https://web.eyelashs.jp/Procare1/api/staffs/list.xml",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n
										<xml>\n    
											<auth>\n        
												<username>$mobile</username>\n        
												<password>$password</password>\n    
											</auth>\n    
											<lang>en</lang>\n    
											<datetime>$api_time</datetime>\n    
											<action>staffs</action>\n    
											<search>\n        
												<store_id>$store_id</store_id>\n    
											</search>\n
										</xml>",
				CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: application/xml",
						"postman-token: efbc8610-f4ad-fb05-eef0-3e7c1eb8a227"
				),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
			// 			echo "cURL Error #:" . $err;
			return  null;
		} else {
			$result = json_decode(json_encode(simplexml_load_string($response)), true);
			return $result;
		}
	}
	

	public function listtreatment($mobile, $password, $store_id){

			$api_time = Date('Y-m-d H:i:s');
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://web.eyelashs.jp/Procare1/api/practitioners/list.xml",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
			  	<xml>\r\n    
			  	<auth>\r\n       
			  		<username>$mobile</username>\r\n  
			       	<password>$password</password>\r\n   
			        </auth>\r\n   
			         	<lang>%en%</lang>\r\n  
			           	<datetime>$api_time</datetime>\r\n   
			            <action>practitioners</action>\r\n  
			            <search>\r\n   
			                <store_id>$store_id</store_id>\r\n 
			                <is_child>false</is_child>\r\n 
			            </search>\r\n
			    </xml>\r\n",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/xml",
			    "postman-token: 3744ff49-86c5-0285-0700-a95620a47180"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			if ($err) {
			// 			echo "cURL Error #:" . $err;
				return  null;
			} else {
				$result = json_decode(json_encode(simplexml_load_string($response)), true);
				return $result;
			}
	}

	public function listsetmenu($mobile, $password, $store_id){
			$api_time = Date('Y-m-d H:i:s');
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://web.eyelashs.jp/Procare1/api/practitioners/list.xml",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
			  	<xml>\r\n    
			  	<auth>\r\n       
			  		<username>$mobile</username>\r\n  
			       	<password>$password</password>\r\n   
			        </auth>\r\n   
			         	<lang>%en%</lang>\r\n  
			           	<datetime>$api_time</datetime>\r\n   
			            <action>practitioners</action>\r\n  
			            <search>\r\n   
			                <store_id>$store_id</store_id>\r\n 
			                <is_child>true</is_child>\r\n 
			            </search>\r\n
			    </xml>\r\n",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/xml",
			    "postman-token: 3744ff49-86c5-0285-0700-a95620a47180"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			if ($err) {
			// 			echo "cURL Error #:" . $err;
				return  null;
			} else {
				$result = json_decode(json_encode(simplexml_load_string($response)), true);
				return $result;
			}
	}


	function listdate($mobile, $password, $practitioner_id){
			$api_time = Date('Y-m-d H:i:s');

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://web.eyelashs.jp/Procare1/api/reserves/nonreserve.xml",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n
			  	<xml>\n   
			   		<auth>\n   
			        		<username>$mobile</username>\n  
			             	<password>$password</password>\n
			              	</auth>\n 
			                 	<action>nonreserve</action>\n
			                 	<lang>ja</lang>\n 
			                    <datetime>$api_time</datetime>
			                    <search>\n      
			                        <store_id>10</store_id>\n   
			                        <staff_id></staff_id>\n  
			                        <date>2018-01-02</date>\n  
			                        <practitioner_id>$practitioner_id</practitioner_id>\n    
			                        <setmenu_id>29</setmenu_id>\n  
			                        </search>\n
			    </xml>",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/xml",
			    "postman-token: d740413a-a1e7-4ecd-24b5-cc065180c862"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			}


	}

}