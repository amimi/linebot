<?php
require_once(dirname(__FILE__) . '/../config.php');

$hashi_mid = 'u7bf1339fb3b42acb906e5260b38cf53c';
$hashi_icon = 'http://dl.profile.line-cdn.net/0m0350b94372513e9e62c4fe9366de947d0e36e0d4e24e';

$ami_mid = 'uba9d6e04158507756b57b4c3b952709e';

$res_content = [
	'contentType'=> CONTENT_TYPE_TEXT,
	"toType"=> 1,
	"text"=> 'aa',
	'mid' => $ami_mid
	,'contentMetadata' => [
		'AT_RECV_MODE' => 2,
		'STKVER' => 100,
		'STKID' => 108,
		'STKPKGID' => 1,
		'SKIP_BADGE_COUNT' => true
	]
];

// toChannelとeventTypeは固定値なので、変更不要。
$post_data = [
	"to"=>[$ami_mid],
	"toChannel"=>"1383378250",
	"eventType"=>"138311608800106203",
	"content"=>$res_content
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


