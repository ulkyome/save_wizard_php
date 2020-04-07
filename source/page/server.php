<?php

//rParams['server']

switch (rParams['server']) {
    case 'upload':
			echo("http://ps4ws2.savewizard.net:8082");
        break;
    case 'WEB':
			echo("http://178.205.143.7:8082");
        break;
	case 'SERVERS':
			echo("178.205.143.7:8082");
        break;
	case 'AUTH_SERVERS':
			echo("178.205.143.7:8082");
        break;
	case 'GAME_LIST':
			echo("http://ps4ws2.savewizard.net:8082");
		break;
    default:
       echo "ERR";
}