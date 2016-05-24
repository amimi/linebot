<?php
require_once(dirname(__FILE__) . '/Linebot.php');

class Cron extends Linebot
{
	public function __construct($argv)
	{
		echo print_r($argv, true);
		$func = '$this->' . $argv[1];
		echo $func;
		if(function_exists($func))
		{
			$func();
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
		$this->send_message($this->ami_mid, $res_content);
	}
}
//echo print_r($argv, true);
new Cron($argv);
