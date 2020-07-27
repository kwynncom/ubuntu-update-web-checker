<?php

require_once('/opt/kwynn/kwutils.php');

function kwynn_ubuup_exec() {
    
    if (isAWS()) $base = '/usr/bin/';
    else         $base = '';
    
    $base .= 'ubuup';
    if (!isAWS()) $cmd  = $base . (PHP_SAPI === 'cli' ? 'cli' : '');
    else          $cmd  = $base;
    return shell_exec($cmd);
}

if (iscli() && 0) {
    $res = kwynn_ubuup_exec();
    echo $res . "\n";
    unset($res);
}

/* To create the binary, create and run the following bash script and then move the binary to somewhere in the PATH
 * Better yet, set the path in $base above.  See notes below
 
#! /bin/bash

gcc updates.c
mv a.out ubuup
chmod 710 ubuup
sudo chown root:www-data ubuup
sudo chmod ug+s ubuup

*** END SCRIPT
 * The correct results should be something like:
 * /usr/bin$ ls -l ubuup
-rws--s--- 1 root www-data 8472 Feb  4  2018 ubuup
 * 
 * When I upgraded to Ubuntu 20.04 and kernel 5.4 and whatever version of Apache and all, I had trouble with the PATH, so 
 * I added the path explicity above.
 */
