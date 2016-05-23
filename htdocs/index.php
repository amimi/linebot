<?php

const CHANNEL_ID = '1462645442';
const CHANNEL_SECRET = '1c8ed524537384435c2f3e9e93a872ab';
const MID = 'u1ad1829c62e8b0d7fb8af24a3e1c4bdc';

const CONTENT_TYPE_TEXT = 1;
const CONTENT_TYPE_IMAGE = 2;
const CONTENT_TYPE_STAMP = 8;

$hashi_mid = 'u7bf1339fb3b42acb906e5260b38cf53c';
$hashi_icon = "http://dl.profile.line-cdn.net/0m0350b94372513e9e62c4fe9366de947d0e36e0d4e24e";

$ami_mid = 'uba9d6e04158507756b57b4c3b952709e';

// メッセージ受信
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$content = $jsonObj->result{0}->content;
$text = $content->text;
$from = $content->from;
$fromChannel = $content->fromChannel;
$message_id = $content->id;
$content_type = $content->contentType;

error_log(print_r($content, TRUE));

// ユーザ情報取得
api_get_user_profile_request($from);

// メッセージ情報取得
api_get_message_content_request($message_id);

$res_content = [];
if($content_type == CONTENT_TYPE_TEXT)
{
	// テキストを送ってきた場合

	if($text == 'はっしー')
	{
		// 画像で返事をする場合
		$res_content = [
			'contentType'=> CONTENT_TYPE_IMAGE,
			"toType"=> 1,
			'originalContentUrl'=>$hashi_icon,
			"previewImageUrl"=> $hashi_icon
		];	
	}
	else
	{
		// テキストでオウム返し
		$res_content = [
			'contentType'=> CONTENT_TYPE_TEXT,
			"toType"=> 1,
			"text"=> $text
		];
	}
}
else
{
	// テキスト以外を送ってきた場合
	// テキストで返事をする場合
	$res_content = [
		'contentType'=> CONTENT_TYPE_TEXT,
		"toType"=> 1,
		"text"=> 'なんなんだよ'
	];
}

// メッセージ送信
api_post_content();




function api_post_content()
{
	// toChannelとeventTypeは固定値なので、変更不要。
	$post_data = [
		"to"=>[$GLOBALS['fromChannel']],
		"toChannel"=>"1383378250",
		"eventType"=>"138311608800106203",
		"content"=>$GLOBALS['res_content']
	];
	
	$ch = curl_init("https://trialbot-api.line.me/v1/events");
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
	error_log($result);
}

/**
 * ユーザー情報取得
 */
function api_get_user_profile_request($mid) {
    $url = "https://trialbot-api.line.me/v1/profiles?mids={$mid}";
    $headers = [
        "X-Line-ChannelID: " . CHANNEL_ID,
        "X-Line-ChannelSecret: " . CHANNEL_SECRET,
        "X-Line-Trusted-User-With-ACL: " . MID
    ]; 

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_close($curl);
    $output = curl_exec($curl);
    error_log($output);
}

/**
 * メッセージ情報取得
 */
function api_get_message_content_request($message_id) {
    $url = "https://trialbot-api.line.me/v1/bot/message/{$message_id}/content";
    $headers = [
        "X-Line-ChannelID: " . CHANNEL_ID,
        "X-Line-ChannelSecret: " . CHANNEL_SECRET,
        "X-Line-Trusted-User-With-ACL: " . MID
    ; 

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curl);
    curl_close($curl);
    file_put_contents("/tmp/{$message_id}", $output);
    error_log($output);
}

