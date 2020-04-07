<?php
function key_gen(){
		$key = md5(time().rand());
		$key = strtoupper($key);
		$key = substr($key, 0, 16);
		$key = substr_replace($key, "-", 4, 0);
		$key = substr_replace($key, "-", 9, 0);
		$key = substr_replace($key, "-", 14, 0);
		
		return $key;
	}

for($i=0;$i<30;$i++){
	
	
	$sql = "INSERT INTO ?n SET a_key=?s, a_userid=?s, a_enable=?i";
	$db->query($sql,'t_keys',key_gen(), 'u_CODE', 1);
}

$sql = "SELECT * FROM ?n WHERE a_userid=?s";
$uData = $db->getAll($sql,'t_keys','u_CODE');

foreach ($uData as $key){
	print_r('<pre>');
	print_r($key['a_key']);
	print_r('</pre>');
}