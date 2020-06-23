#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>

void main(int argc, char *argv[])
{
	char *version = "2018/02/03 3:31am EST";

	setreuid(geteuid(), getuid());
	system("/etc/update-motd.d/90-updates-available");
        system("/etc/update-motd.d/98-reboot-required");
	printf("\n%s - C version\n", version);
}
