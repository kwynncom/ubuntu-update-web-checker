<?php

require_once('/opt/kwynn/kwutils.php');

function kwynn_ubuup_exec() {
    
    $base = '';
	$base .= '/usr/bin/';
     
    $base .= 'ubuup';
    $cmd  = $base;
	if (iscli()) $cmd .= 'cli';
    
    $res = shell_exec($cmd);

    return $res;
}

if (iscli() && 0) {
    $res = kwynn_ubuup_exec();
    echo $res . "\n";
    unset($res);
}
