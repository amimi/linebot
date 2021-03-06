<?php
// 設定ファイルの読み込み
require_once(dirname(__FILE__) . '/config.php');

class Linebot {
	
	const CONTENT_TYPE_TEXT = 1;
	const CONTENT_TYPE_IMAGE = 2;
	const CONTENT_TYPE_VIDEO = 3;
	const CONTENT_TYPE_AUDIO = 4;
	const CONTENT_TYPE_LOCATION = 7;
	const CONTENT_TYPE_STICKER = 8;
	const CONTENT_TYPE_CONTACT = 10;

	public $bot_icon = 'http://dl.profile.line-cdn.net/0m011df07972515fbed3c72fcffcc2ff99ae1c6d445cae';
	public $bot_prev = 'http://linebot.amilktea.com/img/ami_bot_prev.jpg';

	/**
	 * ユーザー情報取得
	 */
	public function api_get_user_profile_request($mid)
	{
		$url = "https://trialbot-api.line.me/v1/profiles?mids={$mid}";
		$headers = [
			'X-Line-ChannelID: ' . CHANNEL_ID,
			'X-Line-ChannelSecret: ' . CHANNEL_SECRET,
			'X-Line-Trusted-User-With-ACL: ' . MID
		]; 

	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $output = curl_exec($curl);
	    curl_close($curl);
	    
	    error_log('get user info.');
	    error_log($output);
	}
	/**
	 * メッセージ送信
	 * @param $to array
	 * @param $content array
	 */
	public function send_message($to = [], $content)
	{
		if(!is_array($to))
		{
			$to = (array)$to;
		}
		$url = 'https://trialbot-api.line.me/v1/events';
		// toChannelとeventTypeは固定値なので、変更不要。
		$post_data = [
			'to' => $to,
			'toChannel' => '1383378250',
			'eventType' => '138311608800106203',
			'content' => $content
		];

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		    'Content-Type: application/json; charser=UTF-8',
		    'X-Line-ChannelID: ' . CHANNEL_ID,
		    'X-Line-ChannelSecret: ' . CHANNEL_SECRET,
		    'X-Line-Trusted-User-With-ACL: ' . MID
		]);
		$result = curl_exec($ch);
		curl_close($ch);
		
		error_log('send message');
		error_log($result);
	}
	
	/**
	 * メッセージ情報取得
	 */
	public function api_get_message_content_request($message_id)
	{
	    $url = "https://trialbot-api.line.me/v1/bot/message/{$message_id}/content";
	    $headers = [
	        'X-Line-ChannelID: ' . CHANNEL_ID,
	        'X-Line-ChannelSecret: ' . CHANNEL_SECRET,
	        'X-Line-Trusted-User-With-ACL: ' . MID
	    ]; 

	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $output = curl_exec($curl);
	    curl_close($curl);
	    
	    error_log('get message info.');
	    error_log($output);
	}
}

