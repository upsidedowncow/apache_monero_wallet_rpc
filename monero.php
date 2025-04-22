<?php
$rpc_url = 'http://127.0.0.1:18083/json_rpc';
$usrn = 'myuser';
$pass = 'mypass';

$data = [
	'jsonrpc' => '2.0',
	'id' => '0',
	'method' => 'get_balance'
];

$options = [
	CURLOPT_URL => $rpc_url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST => true,
	CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
	CURLOPT_USERPWD => "$usrn:$pass",
	CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
	CURLOPT_POSTFIELDS => json_encode($data)
];

$ch = curl_init();
curl_setopt_array($ch, $options);
$response = curl_exec($ch);
if(curl_errno($ch))
{
	echo 'Curl Error: ' . curl_error($ch);
} else {
	echo '<pre>' . htmlspecialchars($response) . '</pre>';
}
curl_close($ch);
?>
