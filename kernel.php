<?php

require_once('/opt/kwynn/kwutils.php');

class kwubuupInfo { // only on test, and incomplete
    public $kernr;
    public $kernts;
    public $kernv;
}

if (kwKernelAmITest()) {
    $o = new kwubuupInfo();
    kwPopKernelInfo($o);
}

function kwPopKernelDateInfo(&$vpio) {
    
    $vpio->kernr  = '';
    $vpio->kernts = '';
    
    try {
    $v = php_uname('v');
    $vpio->kerndtraw = $v;
    
    $i = 0;
    do {
	try {
	    $ts = strtotimeRecent($v);
	    $vpio->kernr = $v;
	    $vpio->kernts = $ts;
	    return;
	} catch(Exception $ex) { }
	$v = preg_replace('/\s*[^\s]+\s+/', '', $v, 1);
    } while($i++ < 20);
    } catch (Exception $ex2) {}
}

function kwPopKernelInfo(&$vpio) {
    $vpio->kernv  = php_uname('r');
    kwPopKernelDateInfo($vpio);
}


function kwKernelAmITest() {
    if (PHP_SAPI !== 'cli') return false;
    $now = time();
    $cmp = strtotime('2020-05-28 03:00');
    $d = $cmp - $now;
    
    if ($d > 0) return true;
    
    return false;
}
