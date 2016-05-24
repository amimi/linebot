<?php
require_once(dirname(__FILE__) . '/Linebot.php');

class Cron extends Linebot
{
	public function __construct($argv)
	{
		echo print_r($argv, true);
		$func = $argv[1];
		if(function_exists("{$this->$func}"))
		{
			$this->$func();
			error_log('実行しますよ：' + "{$this->$func}");
		}
		else
		{
			error_log('そんな関数ありませんよ' + "{$this->$func}");
		}
	}
	
	public function goodmorning()
	{
		$res_content = [
			'contentType'=> CONTENT_TYPE_TEXT,
			"toType"=> 1,
			"text"=> 'おっはよーーー'
		];
		$this->send_message($this->ami_mid, $res_content);
	}
}
//echo print_r($argv, true);
new Cron($argv);
