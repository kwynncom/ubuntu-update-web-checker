<?php 

require_once('/opt/kwynn/kwutils.php');
require_once('exec.php');

class runUpdateBin {
   
    public $status;
    public $err;
    public $reboot;
    public readonly bool $security;
    public readonly bool $std;
    public $vital;
    public $kernv;
    public $kernr;
    public $kernts;
    public $kerndtraw;
    
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
	
	if ($cout && is_string($cout) && trim($cout) === '*** System restart required ***') {
	    $this->std = false;
	    $this->security = true;
	    return;
	}

	kwas($cout && is_string($cout), 'cout falsey or not string');

	$cout = trim($cout);
	kwas($cout, 'cout false'); 

	$arr = explode("\n", $cout);
	kwas($arr && count($arr) >= 1, 'arr is false or < 1');
	$this->setUpdateMOTD2404($arr);

    }

    private function setUpdateMOTD2404(array $arr) {

	$res = [];
	

	foreach($arr as $r) {
    
	    if (!isset($res['std'])) {
		preg_match('/(\d+) update/', $r, $msstd);	
		$res['std'] = $this->getTF($msstd);
	    }
	    if (!isset($res['security'])) {
		preg_match('/(\d+) of these/', $r, $mssec);
		$res['security'] = $this->getTF($mssec);
	    }
	}


	foreach(['std', 'security'] as $f) {
	    $t = kwifs($res, $f, ['kwiff' => null]);
	    if (!isset($t)) {
		if ($f === 'security') $this->security = false;
		else if ($f === 'std') kwas(false, 'no value found for standard updates');
	    } else $this->$f = $t;
	}
    }

    private function getTF($ms) : bool | null {
	if (!$ms || !isset($ms[1])) return null;
	if (!is_numeric	  ($ms[1])) return null;
	$n =	    intval($ms[1]);
	if (!is_integer	  ($n)) return null;
	return $n > 0;
    }

}
