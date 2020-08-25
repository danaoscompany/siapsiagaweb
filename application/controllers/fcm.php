<?php

class FCM extends CI_Controller {

	static public function sendPushNotification($title, $body, $data, $token) {
	    $url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = 'AAAANAqFItM:APA91bHewHKRDRZpIeHnpAKMsoltCSxRuTftYweqzkKyIBkl-XVXHX6DRCSC5ju93JASPLhBHokxONsxTiwTTEM1hTbyCfcXCnhvqtSRET4xJugKvjXcXFphlKEHsUcXX3OkveVu3d9m';
	    $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
	    $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority'=>'high', 'data' => $data);
	    $json = json_encode($arrayToSend);
	    $headers = array();
	    $headers[] = 'Content-Type: application/json';
	    $headers[] = 'Authorization: key='. $serverKey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	    //Send the request
	    $response = curl_exec($ch);
	    //Close request
	    if ($response === FALSE) {
	    	die('FCM Send Error: ' . curl_error($ch));
	    }
	    curl_close($ch);
	}
	
	static public function send_message($token, $notificationType, $showNotification, $title, $body, $data) {
	  $data['show_notification'] = $showNotification;
	  $data['notification_type'] = $notificationType;
      FCM::sendPushNotification($title, $body, $data, $token);
    }
}
