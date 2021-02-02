#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>

void main(int argc, char *argv[])
{
	
    setreuid(geteuid(), getuid());
    system("echo C is owned by `whoami`");
    system("/home/k/sm20/ubuup/test/testsuid.php");
    system("/usr/bin/php ./t2.php");

}

/*
gcc testsuid.c
mv a.out ubuup
chmod 710 ubuup
sudo chown root:www-data ubuup
sudo chmod ug+s ubuup
chmod 755 testsuid.php
*/