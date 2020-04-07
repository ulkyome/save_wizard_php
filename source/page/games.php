<?php
	/*$client = new GuzzleHttp\Client();
	$credentials = base64_encode('savewizard_1:Wd2l#@vqjun)3K');
	
	$options = [
	'headers' => [
		'Content-Type' => 'application/json',
		'Authorization' => ['Basic '.$credentials],
		'User-Agent' => 'Save Wizard for PS4 Max 1.0.6510.36416',
	]
	];
	
	$request = $client->get("http://ps4ws2.savewizard.net:8082/games?token=".$_GET['token'], $options);
	
	$code = $request->getStatusCode();
	
	if($code == 200){
		$response = $request->getBody()->read(12582912);
		header('Content-Type: text/xml');
		print($response);
	}
	else{
		header('Content-Type: text/xml');
		$file = file_get_contents('./games.xml', true);	
		print($file);
	}*/
	
	header('Content-Type: text/xml');
		$file = file_get_contents('./games.xml', true);	
		print($file);
	//http://ps4ws2.savewizard.net:8082/games?token=s_z3wmJRzZgJgnIUI6VMhht5mR
	


