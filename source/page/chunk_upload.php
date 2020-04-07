<?php
//?token=s_6DhRmNHGeC1YiXp2uq12w3Op
/*
$_POST
Array
(
    [op] => Submit
    [form_id] => chunk_upload_form
    [pfs_md5] => 04cefe8b2d616aa63342015b3b317c24
    [total_chunks] => 2
    [gamecode] => CUSA00242
    [pfs] => autosave
    [pfs_size] => 1684363
)

*/
//{"618cb8b4df2ef776fa37aee4791ef111":true}
/*$client = new GuzzleHttp\Client();
$credentials = base64_encode('savewizard_1:Wd2l#@vqjun)3K');

$options = [
'multipart' => [
        [
            'name'     => 'avatarka.jpg',
            'contents' => fopen('/path/to/file', 'r'),
            'filename' => 'custom_filename.jpg'
        ]
    ],
'headers' => [
	'Content-Type' => 'application/json',
	'Authorization' => ['Basic '.$credentials],
	'User-Agent' => 'Save Wizard for PS4 Max 1.0.6510.36416',
]
];

$request = $client->get("http://ps4ws2.savewizard.net:8082/chunk_upload??token=".$_GET['token'], $options);

$code = $request->getStatusCode();
//if $code
$response = $request->getBody()->read(912582912);


//http://ps4ws2.savewizard.net:8082/games?token=s_z3wmJRzZgJgnIUI6VMhht5mR

//$file = file_get_contents('./games.xml', true);

//header('Content-Type: text/xml');
print($response);*/
/*header("Location: http://savewizard_1:Wd2l#@vqjun)3K@ps4ws2.savewizard.net:8082/chunk_upload??token=".$_GET['token']);
exit;*/
/*

chunk1_md5
chunk1id
files[chunk1]
filename="chunk1"
Content-Type: application/octet-stream

*/
$result = array(
  $_POST['pfs_md5'] => false,
  'remaining_chunks' => array (
    '0001' => false,
    '0002' => false,
    '0003' => false,
    '0004' => false,
    '0005' => false,
    '0006' => false,
    '0007' => false,
    '0008' => false,
    '0009' => false,
    '0010' => false,
  ),
)

for($i=1;$i<$_POST['total_chunks'];$i++)
{
	move_uploaded_file($_FILES['files']['tmp_name']["chunk".$i],"./test".$i.".zip");
	if($i == $result['remaining_chunks']["000".$i]){
		$result['remaining_chunks']["000".$i] = true;
	}
}
echo(json_encode($result));
//move_uploaded_file($_FILES['files']['chunk1'], "./test.zip");
