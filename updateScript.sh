# !bin/bash

rsync -rP * --exclude='*.sh' --update /mnt/srv/srv/http/judge
