<?php

const CHANNEL_ID = '1462645442';
const CHANNEL_SECRET = '1c8ed524537384435c2f3e9e93a872ab';
const MID = 'u1ad1829c62e8b0d7fb8af24a3e1c4bdc';

const CONTENT_TYPE_TEXT = 1;
const CONTENT_TYPE_IMAGE = 2;
const CONTENT_TYPE_STAMP = 8;

// メッセージ受信
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$content = $jsonObj->result{0}->content;
$text = $content->text;
$from = $content->from;
$message_id = $content->id;
$content_type = $content->contentType;

error_log(print_r($content, TRUE));

// ユーザ情報取得
api_get_user_profile_request($from);

if($content_type == CONTENT_TYPE_TEXT)
{
	// テキストを送ってきた場合
	// テキストで返事をする場合
	$response_format_text = [
		'contentType'=> CONTENT_TYPE_TEXT,
		"toType"=> 1,
		"text"=> $text
	];
}
else
{
	// テキスト以外を送ってきた場合
	// テキストで返事をする場合
	$response_format_text = [
		'contentType'=> CONTENT_TYPE_TEXT,
		"toType"=> 1,
		"text"=> 'なんなんだよ'
	];
}

// 画像で返事をする場合
$response_format_image = [
	'contentType'=>2,
	"toType"=>1,
	'originalContentUrl'=>"画像URL",
	"previewImageUrl"=>"サムネイル画像URL"
];

// 他にも色々ある
// ....

// toChannelとeventTypeは固定値なので、変更不要。
$post_data = [
	"to"=>[$from],
	"toChannel"=>"1383378250",
	"eventType"=>"138311608800106203",
	"content"=>$response_format_text
];

$ch = curl_init("https://trialbot-api.line.me/v1/events");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'X-Line-ChannelID: ' . CHANNEL_ID,
    'X-Line-ChannelSecret: ' . CHANNEL_SECRET,
    'X-Line-Trusted-User-With-ACL: ' . MID
    ));
$result = curl_exec($ch);
curl_close($ch);

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
    $output = curl_exec($curl);
    error_log($output);
}

