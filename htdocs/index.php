<?php
require_once(dirname(__FILE__) . '/../Linebot.php');

class Receive extends Linebot
{
	public function __construct()
	{
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($mysqli->connect_error)
		{
			error_log($mysqli->connect_error);
			exit();
		}
		
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

		
		$res_content = [];
		switch($content_type)
		{
			// テキスト
			case parent::CONTENT_TYPE_TEXT:
				// テキストを送ってきた場合
				if($text == 'はっしー')
				{
					// 画像で返事をする場合
					$res_content = [
						'contentType'=> parent::CONTENT_TYPE_IMAGE,
						'toType'=> 1,
						'originalContentUrl'=>$this->hashi_icon,
						'previewImageUrl'=> $this->hashi_icon
					];	
				}
				else if($text == 'あみーご')
				{
					// 画像で返事をする場合
					$res_content = [
						'contentType'=> parent::CONTENT_TYPE_IMAGE,
						'toType'=> 1,
						'originalContentUrl'=>$this->bot_icon,
						'previewImageUrl'=> $this->bot_prev
					];		
				}
				else if($text == 'rec')
				{
					$res_content = [
						'contentType'=> parent::CONTENT_TYPE_TEXT,
						'toType'=> 1,
						'text'=> 'http://rec.amilktea.com'
					];
				}
				else
				{
					// テキストでオウム返し
					$res_content = [
						'contentType'=> parent::CONTENT_TYPE_TEXT,
						'toType'=> 1,
						'text'=> $text
					];
				}
				break;
			
			case parent::CONTENT_TYPE_IMAGE:
			case parent::CONTENT_TYPE_VIDEO:
				// 画像
				// ビデオ
				// 内容取得
				$this->api_get_message_content_request($message_id);

				$res_content = [
					'contentType'=> parent::CONTENT_TYPE_TEXT,
					"toType"=> 1,
					"text"=> 'なんなんだよ'
				];
				break;
				
			default:
				$res_content = [
					'contentType'=> parent::CONTENT_TYPE_TEXT,
					"toType"=> 1,
					"text"=> 'なんなんだよ'
				];
				break;
		}
		
		$this->send_message($from, $res_content);
		
		$mysqli->close();
	}
}
new Receive;
