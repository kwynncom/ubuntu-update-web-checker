#include <stdlib.h>
#include <unistd.h>

// build this with $ bash install.txt
void main(int argc, char *argv[]) {
	setreuid(geteuid(), getuid());
	system("/etc/update-motd.d/90-updates-available");
        system("/etc/update-motd.d/98-reboot-required");
}
