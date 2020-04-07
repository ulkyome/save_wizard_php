<?php

$pdata = file_get_contents("php://input");

$pdata = json_decode($pdata, true);

switch ($pdata['action']) {
    case 'ACTIVATE_LICENSE':
			header('Content-Type: application/json');
			print_r(ACTIVATE_LICENSE($pdata['license'],$db));
        break;
    case 'START_SESSION':
			header('Content-Type: application/json');
			echo START_SESSION($pdata['userid'], $pdata['uuid'],$db);
        break;
		//SESSION_REFRESH
    case 'PSNID_INFO':
			header('Content-Type: application/json');
			echo PSNID_INFO($pdata['userid'],$db);
        break;
	case 'REGISTER_PSNID':
			header('Content-Type: application/json');
			echo REGISTER_PSNID($pdata['userid'], $pdata['psnid'], $pdata['friendly_name'],$db);
        break;
	case 'RENAME_PSNID':
			header('Content-Type: application/json');
			echo RENAME_PSNID($pdata['userid'],$pdata['psnid'], $pdata['friendly_name'],$db);
        break;
	case 'UNREGISTER_PSNID':
			header('Content-Type: application/json');
			echo UNREGISTER_PSNID($pdata['userid'], $pdata['psnid'],$db);
        break;
	case 'REGISTER_UUID':
			header('Content-Type: application/json');
			//{"action":"REGISTER_UUID","userid":"u_d349784f457771d0757a44f5aca4586e","uuid":"f5fa1597-bddc-46bc-ad4a-63bdb007516d"}
			echo REGISTER_UUID($pdata['userid'], $pdata['uuid'],$db);
		break;
	case 'DESTROY_SESSION':
			header('Content-Type: application/json');
			//{"action":"DESTROY_SESSION","userid":"u_d349784f457771d0757a44f5","uuid":"f5fa1597-bddc-46bc-ad4a-63bdb007516d"}
			echo DESTROY_SESSION($pdata['userid'], $pdata['uuid'],$db);
		break;
    default:
       echo '{"status":"ERROR","code":4050,"id":"d74b-96035277"}';
}


function ACTIVATE_LICENSE($license,$db){
	$id = "2e".rand(10,99)."-".rand(10000000, 99999999);
	
	$data = array(
		'status'=> 'ERROR',
		'code'	=> 4066,
		'msg'	=> null,
		'id'	=> $id
	);
	
	$userid = "u_".md5($license);
	$userid = substr($userid, 0, 26);
	
	//print_r($license);
	$sql = "SELECT * FROM ?n WHERE a_key=?s";
	$uData = $db->getAll($sql,'t_keys',$license);
	
	if($uData){
		if($uData[0]['a_userid'] == 'u_CODE'){
			$sql = "UPDATE ?n SET a_userid=?s WHERE a_key=?s";
			$db->query($sql,'t_keys', $userid,	$license);
		}
		else{
			$sql = "SELECT * FROM ?n WHERE a_key=?s AND a_enable=?i";
			$uData = $db->getAll($sql,'t_keys',$license, 1);
			
			if($uData){
				
				$sql = "SELECT * FROM ?n WHERE a_userid=?s";
				$uData = $db->getAll($sql,'t_user',$uData[0]['a_userid']);
				
				if($uData){
					$data = array(
						'pid' => $uData[0]['a_pid'],
						'cid' => $uData[0]['a_cid'],
						'status' => 'OK',
						'userid' => $uData[0]['a_userid'],
						'code' => 4020,
						'activation_ts' => time(),
						'id' =>  $uData[0]['a_id'],
					);
					
				}
				else
				{
					$sql = "INSERT INTO ?n SET a_userid=?s, a_id=?s";
					$db->query($sql,'t_user',$userid, $id);
					
					$data = array(
						'pid' => 7,
						'cid' => 0,
						'status' => 'OK',
						'userid' => $userid,
						'code' => 4020,
						'activation_ts' => time(),
						'id' =>  $id,
					);
				}
				
				//------------------------------
				$client = new GuzzleHttp\Client();
				$credentials = base64_encode('savewizard_1:Wd2l#@vqjun)3K');
				
				$options = [
				'body' => '{"action":"ACTIVATE_LICENSE","license":"AA32-8CLL-6TPA-A2J2"}',
				'headers' => [
					'Content-Type' => 'application/json',
					'Authorization' => ['Basic '.$credentials],
					'User-Agent' => 'Save Wizard for PS4 Max 1.0.6510.36416',
				]
				];
				
				$request = $client->post('http://ps4ws2.savewizard.net:8082/ps4auth', $options);
	
				$code = $request->getStatusCode();
				//if $code
				$response = json_decode($request->getBody()->read(1024),true);
				//------------------------------
				
				//$data['userid'] = $response['userid']; //$uData
				//$data['activation_ts'] = $response['activation_ts'];
				//$data['id'] = $response['id'];
			}
			else{
				//error
				return json_encode($data);
			}
		}
		
	}else{
		/*$sql = "INSERT INTO ?n SET a_key=?s, a_userid=?s";
		$db->query($sql,'t_keys',$license, $userid);*/
		
		return json_encode($data);
	}

	return json_encode($data);
}

function START_SESSION($userid, $uuid,$db){
	$id = "2e".rand(10,99)."-".rand(10000000, 99999999);
	
	$data = array(
		'status'=> 'ERROR',
		'code'	=> 4066,
		'msg'	=> null,
		'id'	=> $id
	);
	
	$sql = "SELECT * FROM ?n WHERE a_userid=?s AND a_enable=?i";
	$uData = $db->getAll($sql,'t_user',$userid, 1);
	
	if($uData){
		$data = array (
			'pid' => $uData[0]['a_pid'],
			'cid' => $uData[0]['a_cid'],
			'status' => 'OK',
			'minfsize' => 4,
			'maxfsize' => 18667520,
			'token' => 's_TEST',
			'current_ts' => time(),
			'expiry_ts' => time() + 900,
			'id' => $uData[0]['a_id'],
		);
		
		//30068c53-0000-0000-0000-402400000000
		
		//------------------------------
		/*$client = new GuzzleHttp\Client();
		$credentials = base64_encode('savewizard_1:Wd2l#@vqjun)3K');
		
		$options = [
		'body' => '{"action":"START_SESSION","userid":"u_mHxAHEy4ruiI6shfUrIhV4Ue","uuid":"30068c53-0000-0000-0000-402400000000"}',
		'headers' => [
			'Content-Type' => 'application/json',
			'Authorization' => ['Basic '.$credentials],
			'User-Agent' => 'Save Wizard for PS4 Max 1.0.6510.36416',
		]
		];
		
		$request = $client->post('http://ps4ws2.savewizard.net:8082/ps4auth', $options);
	
		$code = $request->getStatusCode();
		//if $code
		$response = json_decode($request->getBody()->read(1024),true);*/
		//------------------------------
		$sql = "SELECT * FROM ?n";
		$session = $db->getAll($sql,'t_session_sw');
		$data['token'] = $session[0]['a_token'];
		//$data['token'] = $response['token'];
		//$data['id'] = $response['id'];
		
	}
	else{
		
	}

	return json_encode($data);
}

function PSNID_INFO($userid,$db){
	$psnC = 0;
	$id = "2e".rand(10,99)."-".rand(10000000, 99999999);
	$data = array(
		'status'=> 'ERROR',
		'code'	=> 4050,
		'msg'	=> null,
		'id'	=> $id
	);
	
	$sql = "SELECT * FROM ?n WHERE a_userid=?s AND a_enable=?i";
	$uData = $db->getAll($sql,'t_user',$userid, 1);
	
	if($uData){
		$sql = "SELECT *, IF(a_replaceable, 'true', 'false') a_replaceable FROM ?n WHERE a_userid=?s AND a_enable=?i";
		$uPSNData = $db->getAll($sql,'t_psndata',$uData[0]['a_userid'], 1);
		$dataPSN = array();
		
		
		if($uPSNData){
				$psnC = count($uPSNData);
				for($i=0;$i<$psnC;$i++){
						
						$dataPSN[$uPSNData[$i]['a_id_user']] = array(
							'friendly_name' => $uPSNData[$i]['a_friendly_name'],
							'registration_ts' => time(),
							'replaceable' => (Boolean)$uPSNData[$i]['a_replaceable'],
							'replaceable_ts' => time() + 1000,
						);
				}
		}
		else{
			$dataPSN = array(
				'0000000000000001' => array (
					'friendly_name' => 'Ulkyome_Devufol',
					'registration_ts' => time(),
					'replaceable' => false,
					'replaceable_ts' => time() + 1000,
				)
			);
		}
		
		$data = array (
			'pid' => $uData[0]['a_pid'],
			'cid' => $uData[0]['a_cid'],
			'status' => 'OK',
			'psnid_remaining' => $uData[0]['a_psnid_quota'] - $psnC,
			'psnid_quota' => $uData[0]['a_psnid_quota'],
			'psnid' => $dataPSN,
			'id' => null,
		);
	}
	else{
		return json_encode($data);
	}
	
	return json_encode($data);
}

function REGISTER_PSNID($userid, $psnid, $friendly_name,$db){
	$id = "2e".rand(10,99)."-".rand(10000000, 99999999);
	$data = array(
		'status'=> 'ERROR',
		'code'	=> 4050,
		'msg'	=> null,
		'id'	=> $id
	);
	
	$sql = "SELECT * FROM ?n WHERE a_userid=?s AND a_enable=?i";
	$uData = $db->getAll($sql,'t_user',$userid, 1);
	
	if($uData){
		$sql = "SELECT * FROM ?n WHERE a_id_user=?s AND a_enable=?i AND a_userid=?s";
		$uDataPSN = $db->getAll($sql,'t_psndata',$psnid, 1,$userid);
		
		if($uDataPSN){
			//
		}
		else
		{
			$sql = "INSERT INTO ?n SET a_userid=?s, a_id_user=?s, a_friendly_name=?s";
			$db->query($sql,'t_psndata',$userid, $psnid, $friendly_name);
			
			$sql = "SELECT *, IF(a_replaceable, 'true', 'false') a_replaceable FROM ?n WHERE a_userid=?s AND a_enable=?i";
			$uPSNData = $db->getAll($sql,'t_psndata',$uData[0]['a_userid'], 1);
			
			$dataPSN = array();
			$psnC = count($uPSNData);
			
			for($i=0;$i<$psnC;$i++){
						
						$dataPSN[$uPSNData[$i]['a_id_user']] = array(
							'friendly_name' => $uPSNData[$i]['a_friendly_name'],
							'registration_ts' => time(),
							'replaceable' => (Boolean)$uPSNData[$i]['a_replaceable'],
							'replaceable_ts' => time() + 1000,
						);
			}
			
			$data = array (
				'status' => 'OK',
				'psnid_quota' => $uData[0]['a_psnid_quota'],
				'psnid' => $dataPSN,
				'psnid_remaining' => $uData[0]['a_psnid_quota'] - $psnC,
				'id' => null,
			);
		}
	}
	
	return json_encode($data);
}

function RENAME_PSNID($userid, $psnid, $friendly_name,$db){
	$id = "2e".rand(10,99)."-".rand(10000000, 99999999);
	$data = array(
		'status'=> 'ERROR',
		'code'	=> 4050,
		'msg'	=> null,
		'id'	=> $id
	);
	
	$sql = "SELECT * FROM ?n WHERE a_userid=?s AND a_enable=?i";
	$uData = $db->getAll($sql,'t_user',$userid, 1);
	
	if($uData){
		$sql = "UPDATE ?n SET a_friendly_name=?s WHERE a_id_user=?s";
		$db->query($sql,'t_psndata', $friendly_name, $psnid);
		
		
		$sql = "SELECT *, IF(a_replaceable, 'true', 'false') a_replaceable FROM ?n WHERE a_userid=?s AND a_enable=?i";
		$uPSNData = $db->getAll($sql,'t_psndata',$uData[0]['a_userid'], 1);
		
		$dataPSN = array();
		$psnC = count($uPSNData);
		
		for($i=0;$i<$psnC;$i++){
					
					$dataPSN[$uPSNData[$i]['a_id_user']] = array(
						'friendly_name' => $uPSNData[$i]['a_friendly_name'],
						'registration_ts' => time(),
						'replaceable' => (Boolean)$uPSNData[$i]['a_replaceable'],
						'replaceable_ts' => time() + 1000,
					);
		}

		$data = array (
			'pid' => $uData[0]['a_pid'],
			'cid' => $uData[0]['a_cid'],
			'status' => 'OK',
			'psnid_quota' => $uData[0]['a_psnid_quota'],
			'psnid' => $dataPSN,
			'psnid_remaining' => $uData[0]['a_psnid_quota'] - $psnC,
			'id' => null,
		);
	}
	
	
	
	return json_encode($data);
}

function UNREGISTER_PSNID($userid, $psnid,$db){
	//DELETE FROM tovars WHERE id = '$id'
	$id = "2e".rand(10,99)."-".rand(10000000, 99999999);
	$data = array(
		'status'=> 'ERROR',
		'code'	=> 4050,
		'msg'	=> null,
		'id'	=> $id
	);
	
	$sql = "SELECT * FROM ?n WHERE a_userid=?s AND a_enable=?i";
	$uData = $db->getAll($sql,'t_user',$userid, 1);
	
	if($uData){
		$sql = "DELETE FROM ?n WHERE a_id_user=?s";
		$db->query($sql,'t_psndata', $psnid);

		$sql = "SELECT *, IF(a_replaceable, 'true', 'false') a_replaceable FROM ?n WHERE a_userid=?s AND a_enable=?i";
		$uPSNData = $db->getAll($sql,'t_psndata',$uData[0]['a_userid'], 1);
		
		if($uPSNData){
		$dataPSN = array();
		$psnC = count($uPSNData);
		
		for($i=0;$i<$psnC;$i++){
					
					$dataPSN[$uPSNData[$i]['a_id_user']] = array(
						'friendly_name' => $uPSNData[$i]['a_friendly_name'],
						'registration_ts' => time(),
						'replaceable' => (Boolean)$uPSNData[$i]['a_replaceable'],
						'replaceable_ts' => time() + 1000,
					);
		}
		}
		else{
			$dataPSN = array(
				'0000000000000001' => array (
					'friendly_name' => 'Ulkyome_Devufol',
					'registration_ts' => time(),
					'replaceable' => false,
					'replaceable_ts' => time() + 1000,
				)
			);
		}

		$data = array (
			'pid' => $uData[0]['a_pid'],
			'cid' => $uData[0]['a_cid'],
			'status' => 'OK',
			'psnid_quota' => $uData[0]['a_psnid_quota'],
			'psnid' => $dataPSN,
			'psnid_remaining' => $uData[0]['a_psnid_quota'] - $psnC,
			'id' => null,
		);
	}
	
	return json_encode($data);
}

function REGISTER_UUID($userid, $uuid,$db){
	$id = "2e".rand(10,99)."-".rand(10000000, 99999999);
	//{"status":"ERROR","code":4050,"id":"d74b-96035277"}
	$data = array(
		'status'=> 'ERROR',
		'code'	=> 4050,
		'msg'	=> null,
		'id'	=> $id
	);
	
	$sql = "SELECT * FROM ?n WHERE a_userid=?s AND a_enable=?i";
	$uData = $db->getAll($sql,'t_user',$userid, 1);
		
	if($uData){
		if($uData[0]['a_uuid'] == '0'){
			
			$sql = "UPDATE ?n SET a_uuid=?s WHERE a_userid=?s";
			$db->query($sql,'t_user',$uuid, $userid);
	
		}
		else{
			if($uData[0]['a_uuid'] == $uuid){
				//
			}
			else{
				return json_encode($data);
			}
		}
			
		$data = array(
			'pid' => $uData[0]['a_pid'],
			'cid' => $uData[0]['a_cid'],
			'status' => 'OK',
			'userid' => $uData[0]['a_userid'],
			'code' => 4020,
			'id' =>  $uData[0]['a_id'],
		);
		
	}
	
	return json_encode($data);
}

function DESTROY_SESSION($userid, $uuid,$db){
	$id = "2e".rand(10,99)."-".rand(10000000, 99999999);
	$data = array(
		'pid'=> '7',
		'cid'=> '0',
		'status'=> 'OK',
		'id'	=> null
	);	
	return json_encode($data);
}