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
	if (isAWS()) $this->get2LinesNew($cout);
	else         $this->get2LinesOld($cout);
    }
    
    private function get2LinesNew($cout) {
	$cout = trim($cout);
	kwas($cout, 'cout false'); 
	

// new
/*  0 updates can be installed immediately.
    0 of these updates are security updates.
 * 
 */
	if (!isAWS()) kwas(strpos($cout, 'update'), 'lang 1 bad');
	else          kwas(strpos($cout, 'security update'), 'lang 1 bad');
	kwas(strpos($cout, 'security update'), 'lang 2 bad');	
	
	$arr = explode("\n", $cout);
	kwas($arr && count($arr) >= 2, 'arr is false or < 2');
	preg_match('/(\d+) update/', $arr[0], $matches);
	kwas(isset($matches[1]), 'row 1 failed');
	$this->std =  $matches[1] > 0;
	preg_match('/(\d+) of these/', $arr[1], $matches);
	kwas(isset($matches[1]), 'row 2 failed');
	$this->security =  $matches[1] > 0;
    }
    
    private function get2LinesOld($cout) {
	$cout = trim($cout);
	kwas($cout, 'cout false'); 
	
	// old
// 0 packages can be updated.
// 0 updates are security updates.

// new
/*  0 updates can be installed immediately.
    0 of these updates are security updates.
 * 
 */
	if (!isAWS()) kwas(strpos($cout, 'can be updated.'), 'lang 1 bad');
	else          kwas(strpos($cout, 'can be installed immediately'), 'lang 1 bad');
	kwas(strpos($cout, 'security update'), 'lang 2 bad');	
	
	$arr = explode("\n", $cout);
	kwas($arr && count($arr) >= 2, 'arr is false or < 2');
	preg_match('/(\d+) package/', $arr[0], $matches);
	kwas(isset($matches[1]), 'row 1 failed');
	$this->std =  $matches[1] > 0;
	preg_match('/(\d+) update/', $arr[1], $matches);
	kwas(isset($matches[1]), 'row 2 failed');
	$this->security =  $matches[1] > 0;
    }
}
