<?php


class Eyelash_api{
	
	
	// M / 08041320468
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
}