<?php


require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();


session_start();	

//CHECK YOUR PHP SESSION FUNTIONCS

/*
switch (session_status()) {
    case PHP_SESSION_DISABLED:
        echo 'session disabled';
        break;
    
    case PHP_SESSION_NONE:
        echo 'session None';
        break;

    case PHP_SESSION_ACTIVE:
        echo 'session Active';
        break;
}
*/

require __DIR__ . '/../resources/config/dev.php';

require __DIR__ . '/../src/app.php';



$app->run();