<?php
require_once(dirname(__FILE__) . '/Linebot.php');

class Bot extends Linebot {
	
	public function __construct()
	{
		$res_content = [
			'contentType'=> CONTENT_TYPE_STICKER,
			"toType"=> 1,
			"text"=> 'aa',
			'mid' => $ami_mid
			,'contentMetadata' => [
				'AT_RECV_MODE' => 2,
				'STKVER' => 2,
				'STKID' => 108,
				'STKPKGID' => 1,
				'SKIP_BADGE_COUNT' => true
			]
		];

		// メッセージ送信
		$this->send_message($this->ami_mid, $res_content);
	}
	
}



