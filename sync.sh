#!/bin/bash

# Will rsync (pull) uploads and plugin updates

rsync -avz --delete \
    --exclude-from='rsync-exclude.txt' \
    --progress \
    --rsh="ssh -i ~/.ssh/id_rsa" \
    root@guidestar.consulting:/var/www/guidestar-consulting/wp-content/ \
    ./wp-content/