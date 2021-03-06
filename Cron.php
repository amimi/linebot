<?php
require_once(dirname(__FILE__) . '/Linebot.php');

class Cron extends Linebot
{
	public function __construct($argv)
	{
		$func = $argv[1];
		if(method_exists($this, $func))
		{
			$this->$func();
			error_log('実行しますよ：' + $func);
		}
		else
		{
			error_log('そんな関数ありませんよ' + $func);
		}
	}
	
	public function goodmorning()
	{
		$res_content = [
			'contentType'=> parent::CONTENT_TYPE_TEXT,
			"toType"=> 1,
			"text"=> 'おっはよーーー'
		];
		$this->send_message([$GLOBALS['ami_mid']], $res_content);
	}

	public function otsukare()
	{
		$res_content = [
			'contentType'=> parent::CONTENT_TYPE_TEXT,
			"toType"=> 1,
			"text"=> '今日もおつかれさまでした。'
		];
		$this->send_message([$GLOBALS['ami_mid']], $res_content);
	}
}

new Cron($argv);
