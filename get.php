<?php

require_once('/opt/kwynn/kwutils.php');
require_once('/opt/kwynn/isKwGoo.php');
require_once('runBin.php');
require_once('kernel.php');

class getUbuup {
    
    public static function isAuth() {
	return isKwGoo() || isKwDev() || iscli();
    }

    public static function get() {
	if (!self::isAuth()) return false;
	$v = new runUpdateBin(1);
	kwPopKernelInfo($v);
	return $v;
    }

}