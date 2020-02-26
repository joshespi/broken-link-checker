#!/bin/bash

sites=/var/www
#grep -REo "(http|https)://[a-zA-Z0-9./?=_-]*" /var/www/sandbox.provo.edu/public-01-09-20/wp-content/themes/ | sed 's/:/ > /'| perl -pe 's/\n/ > /' >  linksfound.txt

grep -REo --exclude-dir={assets,icons} --exclude='*.png' --exclude='*.svg' --exclude='*.pdf' --exclude='*.jpg' "(http|https)://[a-zA-Z0-9./?=_-:]*" $sites/*/public_html/wp-content/themes/ | sed 's/:/ > /'| perl -pe 's/\n/ > /' >  linksfound.txt

#echo $sites/*/wp-content/themes/

/usr/bin/php check_links.php

rsync -az /home/joshe/broken_link_checker/results.txt /var/www/provo.edu/public_html/wp-content/uploads/broken-link-checker/mainweb.txt

#https://unix.stackexchange.com/questions/181254/how-to-use-grep-and-cut-in-script-to-obtain-website-urls-from-an-html-file