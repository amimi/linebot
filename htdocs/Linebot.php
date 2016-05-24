// 設定ファイルの読み込み
require_once(dirname(__FILE__) . '/../config.php');

class Linebot {
	
	const CONTENT_TYPE_TEXT = 1;
	const CONTENT_TYPE_IMAGE = 2;
	const CONTENT_TYPE_VIDEO = 3;
	const CONTENT_TYPE_AUDIO = 4;
	const CONTENT_TYPE_LOCATION = 7;
	const CONTENT_TYPE_STICKER = 8;
	const CONTENT_TYPE_CONTACT = 10;

	public $hashi_mid = 'u7bf1339fb3b42acb906e5260b38cf53c';
	public $hashi_icon = 'http://dl.profile.line-cdn.net/0m0350b94372513e9e62c4fe9366de947d0e36e0d4e24e';

	public $ami_mid = 'uba9d6e04158507756b57b4c3b952709e';

	/**
	 * ユーザー情報取得
	 */
	public function api_get_user_profile_request($mid) {
	    $url = "https://trialbot-api.line.me/v1/profiles?mids={$mid}";
	    $headers = [
	        'X-Line-ChannelID: ' . CHANNEL_ID,
	        'X-Line-ChannelSecret: ' . CHANNEL_SECRET,
	        'X-Line-Trusted-User-With-ACL: ' . MID
	    ]; 

	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $output = curl_exec($curl);
	    curl_close($curl);
	    error_log('get user info.');
	    error_log($output);
	}
	
	public function send_message($to = [], $content)
	{
		// toChannelとeventTypeは固定値なので、変更不要。
		$post_data = [
			'to' => $to,
			'toChannel' => '1383378250',
			'eventType' => '138311608800106203',
			'content' => $content
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
		
		error_log('send message');
		error_log($result);
	}
}

