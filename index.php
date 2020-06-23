<?php

require_once('/opt/kwynn/isKwGoo.php');
require_once('runBin.php');
require_once('kernel.php');

if (	!
	    (isKwGoo() || isKwDev())
    ) 
{ 
    exitNotAuth();
}
else {
    $KWUPV = new runUpdateBin(1);
    
    kwPopKernelInfo($KWUPV);
    
    if (PHP_SAPI !== 'cli') require_once('template.php');
    else var_dump($KWUPV);
    exit(0);
}

function exitNotAuth() {
    http_response_code(401); 
    die('not auth');
}
