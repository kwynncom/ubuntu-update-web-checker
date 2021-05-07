#include <stdlib.h>
#include <unistd.h>

void main(int argc, char *argv[]) { // version 2021/04/30 5:48pm EDT (New York / Atlanta)
	setreuid(geteuid(), getuid());
	system("/etc/update-motd.d/90-updates-available");
        system("/etc/update-motd.d/98-reboot-required");
}

/* To create the binary, create and run the following bash script and then move the binary to somewhere in the PATH.
 
#! /bin/bash

gcc updates.c
mv a.out ubuup
chmod 710 ubuup
sudo chown root:www-data ubuup
sudo chmod ug+s ubuup
sudo mv ubuup /usr/bin/ubuup

*** END SCRIPT
 * The correct results should be something like:
 * /usr/bin$ ls -l ubuup
-rws--s--- 1 root www-data 8472 Feb  4  2018 ubuup

* As of sometime in early 2021, I am assuming ubuup is in /usr/bin or otherwise in the path.  I am assuming this locally, too.
*/
