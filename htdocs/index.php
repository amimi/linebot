<?php

const CHANNEL_ID = '1462645442';
const CHANNEL_SECRET = '1c8ed524537384435c2f3e9e93a872ab';
const MID = 'u1ad1829c62e8b0d7fb8af24a3e1c4bdc';

// メッセージ受信
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$content = $jsonObj->result{0}->content;
$text = $content->text;
$from = $content->from;
$message_id = $content->id;
$content_type = $content->contentType;

error_log(print_r($from, TRUE));

// テキストで返事をする場合
$response_format_text = array('contentType'=>1,"toType"=>1,"text"=>"hello");
// 画像で返事をする場合
$response_format_image = array('contentType'=>2,"toType"=>1,'originalContentUrl'=>"画像URL","previewImageUrl"=>"サムネイル画像URL");
// 他にも色々ある
// ....

// toChannelとeventTypeは固定値なので、変更不要。
$post_data = [
	"to"=>[$to],
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
