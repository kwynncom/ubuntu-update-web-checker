<?php

require_once('/opt/kwynn/kwutils.php');
require_once('get.php');

if (!getUbuup::isAuth()) 
{ 
    exitNotAuth();
}
else {
    $KWUPV = getUbuup::get();
    if (PHP_SAPI !== 'cli') require_once('template.php');
    else var_dump($KWUPV);
    exit(0);
}

function exitNotAuth() {
    http_response_code(401); 
    die('not auth');
}
