<?php 

require_once('/opt/kwynn/kwutils.php');
require_once('exec.php');

class runUpdateBin {
   
    public $status;
    public $err;
    public $reboot;
    public $security;
    public $std;
    public $vital;
    
    function __construct($throw = false) {
	try {
	    $this->status = 'attempting...';
	    $txt = kwynn_ubuup_exec();
	    self::popCOutput($txt);
	    $this->status = 'OK';
	} catch(Exception $e) {
	    $this->status = 'error';
	    $this->err = $e->getMessage();
	    if ($throw) throw $e;
	}
   } 
   
   private function popCOutput($cout) {
       
      $this->get2Lines($cout);
      if (strpos($cout, '*** System restart required ***') !== false) $this->reboot = true;
      else $this->reboot = false;
      
      $this->vital = $this->reboot || $this->security;
    }
    
    private function get2Lines($cout) {
	$cout = trim($cout);
	kwas($cout, 'cout false'); 
        kwas(strpos($cout, 'security update'), 'lang 1 bad');

	$arr = explode("\n", $cout);
	kwas($arr && count($arr) >= 2, 'arr is false or < 2');
	preg_match('/(\d+) update/', $arr[0], $matches);
	kwas(isset($matches[1]), 'row 1 failed');
	$this->std =  $matches[1] > 0;
	preg_match('/(\d+) of these/', $arr[1], $matches);
	kwas(isset($matches[1]), 'row 2 failed');
	$this->security =  $matches[1] > 0;
    }
}
