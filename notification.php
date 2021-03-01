
<?php
         /*send push notification in android*/
public function AndroidNotify($device_token,$title, $message,$image=null) {
			$key	=	FCM_KEY;
			$msg=	array(
				'body'			=>	trim(strip_tags($message)),
				'title'			=>	$title,
				'type'			=>	2,
				'sound'			=>	'mySound',
				'badge_count'	=>	1
			);
			$fields	=	array(
				'to'	=>	$device_token,
				'data'	=>	$msg
			);
			
			$headers=	array(
				'Authorization: key=' . $key,
				'Content-Type: application/json'
			);
			
			$ch	=	curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ));
			$result	=	curl_exec($ch );
			// print_r($result);die();
			curl_close( $ch );

			return true;
			
	}

	public function iosNotify($device_token,$title=null, $message=null,$image=null) { 
		$url = "https://fcm.googleapis.com/fcm/send";
		$serverKey = FCM_KEY;
		$message = str_replace('<p>', '', $message);
		$body = str_replace('</p>', '', $message);
		$notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');
		$arrayToSend = array('to' => $device_token, 'notification' => $notification,'priority'=>'high');
		$json = json_encode($arrayToSend);
		//pr($json);die;
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,

		"POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		//Send the request
		$response = curl_exec($ch);
		//pr($response);die;
		//Close request
		if ($response === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
	}