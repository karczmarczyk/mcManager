#!/bin/bash
echo pwd;
git add .
git commit -m "deploy"
git push origin master
ssh mateusz@192.168.10.102 cd /var/www/minecraft/mcManager; git pull origin master;  /usr/local/php/bin/php bin/console cache:clear;
echo "DONE!";