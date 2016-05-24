<?php
require_once(dirname(__FILE__) . '/Linebot.php');

class Bot extends Linebot
{
	public function __construct()
	{
		// メッセージ受信
		$json_string = file_get_contents('php://input');
		$jsonObj = json_decode($json_string);
		$content = $jsonObj->result{0}->content;
		$text = $content->text;
		$to = $content->to;
		$from = $content->from;
		$fromChannel = $content->fromChannel;
		$message_id = $content->id;
		$content_type = $content->contentType;

		error_log(print_r($content, TRUE));

		// ユーザ情報取得
		$this->api_get_user_profile_request($from);

		// メッセージ情報取得
		$this->api_get_message_content_request($message_id);
		
		$res_content = [];
		if($content_type == self::CONTENT_TYPE_TEXT)
		{
			// テキストを送ってきた場合

			if($text == 'はっしー')
			{
				// 画像で返事をする場合
				$res_content = [
					'contentType'=> self::CONTENT_TYPE_IMAGE,
					"toType"=> 1,
					'originalContentUrl'=>$hashi_icon,
					"previewImageUrl"=> $hashi_icon
				];	
			}
			else if($text == 'あみーご')
			{
				// 画像で返事をする場合
				$res_content = [
					'contentType'=> self::CONTENT_TYPE_IMAGE,
					"toType"=> 1,
					'originalContentUrl'=>$bot_icon,
					"previewImageUrl"=> $bot_prev
				];		
			}
			else
			{
				// テキストでオウム返し
				$res_content = [
					'contentType'=> self::CONTENT_TYPE_TEXT,
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
				'contentType'=> self::CONTENT_TYPE_TEXT,
				"toType"=> 1,
				"text"=> 'なんなんだよ'
			];
		}
		
		$this->send_message($from, $res_content);
		
	}
}
new Bot;
