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
	
	if ($cout === "\n\n\n") {
	    $this->std = $this->security = false;
	    return;
	}
	
	if (trim($cout) === '*** System restart required ***') {
	    $this->std = false;
	    $this->security = true;
	    return;
	}

	$cout = trim($cout);
	kwas($cout, 'cout false'); 

	$arr = explode("\n", $cout);
	kwas($arr && count($arr) >= 1, 'arr is false or < 1');
	preg_match('/(\d+) update/', $arr[0], $ms);
	kwas(isset($ms[0]), 'row 0 failed');
		
	$this->std =  $ms[0] > 0;
	
	if (!isset($arr[1])) { $this->security = false; return; }
	
	preg_match('/(\d+) of these/', $arr[1], $ms);
	kwas(isset($ms[1]), 'second / security line fail');
	$this->security =  $ms[1] > 0;
    }
}
