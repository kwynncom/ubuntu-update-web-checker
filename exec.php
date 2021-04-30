<?php

require_once('/opt/kwynn/kwutils.php');

function kwynn_ubuup_exec() {
    
    $base = '';
    
    if (isAWS() && iscli()) $base .= 'sudo ';
    
    if (isAWS()) $base .= '/usr/bin/';
    else         $base .= '';
     
    $base .= 'ubuup';
    if (!isAWS()) $cmd  = $base . (PHP_SAPI === 'cli' ? 'cli' : '');
    else          $cmd  = $base;
    
    $res = shell_exec($cmd);

    return $res;
}

if (iscli() && 0) {
    $res = kwynn_ubuup_exec();
    echo $res . "\n";
    unset($res);
}
