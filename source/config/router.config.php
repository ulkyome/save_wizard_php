<?php

$router = new AltoRouter();

$routes = [
	['GET','/', 'home', 'home3'],
	['GET','/keys', 'keygen', 'keys_GET'],
	['POST', '/ps4auth', 'api_ps4auth', 'api_ps4auth_POST'],
	['POST', '/chunk_upload', 'chunk_upload', 'chunk_upload_POST'],
	['POST', '/request', 'request', 'request_POST'],
	['GET','/ps4/rss', 'rss', 'rss_GET'],
	['GET','/games', 'games', 'games_GET'],
	['GET','/output/output_[a:name].[a:id].zip', 'output', 'output_GET'],
	['GET','/server_[*:server]', 'server', 'server_GET'],
	//['GET', '/ps4auth', 'api_ps4auth', 'api_ps4auth_GET']
	/*['POST', '/1/classes/[a:className]'],
	['PUT', '/1/classes/[a:className]/[i:objectId]'],
	['GET', '/1/classes/[a:className]'],
	['DELETE', '/1/classes/[a:className]/[i:objectId]'],*/
];
/*
*                    // Match all request URIs
[i]                  // Match an integer
[i:id]               // Match an integer as 'id'
[a:action]           // Match alphanumeric characters as 'action'
[h:key]              // Match hexadecimal characters as 'key'
[:action]            // Match anything up to the next / or end of the URI as 'action'
[create|edit:action] // Match either 'create' or 'edit' as 'action'
[*]                  // Catch all (lazy, stops at the next trailing slash)
[*:trailing]         // Catch all as 'trailing' (lazy)
[**:trailing]        // Catch all (possessive - will match the rest of the URI)
.[:format]?          // Match an optional parameter 'format' - a / or . before the block is also optional


'i'  => '[0-9]++'
'a'  => '[0-9A-Za-z]++'
'h'  => '[0-9A-Fa-f]++'
'*'  => '.+?'
'**' => '.++'
''   => '[^/\.]++'

*/


foreach ($routes as $r) {
    $router->map($r[0], $r[1], $r[2], $r[3], "test");
}

$routerMatch = $router->match();

if($routerMatch) {
  $router_C = 200;
} else {

 $router_C = 404;
}

define('rTarget', $routerMatch['target']);
define('rParams', $routerMatch['params']);
define('rName', $routerMatch['name']);