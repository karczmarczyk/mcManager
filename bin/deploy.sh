#!/bin/bash

NOW=$(date +"%F")
LOCAL_PATH="/home/mateusz/www/symfony4/mcManager"
REMOTE_PATH="/var/www/minecraft/mcManager"
BRANCH="master"

cd $LOCAL_PATH;
git add .
git commit -m "deploy $NOW"
git push origin $BRANCH

#REMOTE
ssh mateusz@192.168.10.102
  cd $REMOTE_PATH;
  git pull origin $BRANCH;
  /usr/local/php/bin/php $REMOTE_PATH/bin/console cache:clear;

echo "DONE!";