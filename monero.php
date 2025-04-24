<?php
$rpc_url = 'http://127.0.0.1:18083/json_rpc';
$usrn = 'myuser';
$pass = 'mypass';

function monero_rpc($method, $params = [])
{
	global $rpc_url, $usrn, $pass;
	$data = [
		'jsonrpc' => '2.0',
		'id' => '0',
		'method' => $method,
		'params' => $params
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
	} 
	curl_close($ch);
	return json_decode($response, true);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Monero Wallet RPC</title>
</head>
<body>
<h2>Monero Wallet Balance</h2>
<?php
$response = monero_rpc('get_balance');
echo '<pre>' . htmlspecialchars(json_encode($response, JSON_PRETTY_PRINT)) . '</pre>';
?>

<form method="POST">
	<input type="submit" name="create_address" value="Create New Recipient Address">
</form>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_address']))
{
	$addressResponse = monero_rpc('create_address', ['account_index' => 0]);
	if(isset($addressResponse['result']))
	{
		echo "<h3>New Address Created:</h3><pre>" . htmlspecialchars(json_encode($addressResponse['result'], JSON_PRETTY_PRINT)) . "</pre>";
	} else {
		echo "<h3>Error:</h3><pre>" . htmlspecialchars(json_encode($addressResponse, JSON_PRETTY_PRINT)) . "</pre>";
	}

}
?>
</body>
</html>
