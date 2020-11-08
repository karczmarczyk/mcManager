#!/bin/bash

NOW=$(date +"%F")
LOCAL_PATH="/home/mateusz/www/symfony4/mcManager"
REMOTE_PATH="/var/www/minecraft/mcManager"
BRANCH="master"

echo "\nsend to repo to branch $BRANCH\n";
cd $LOCAL_PATH;
git add .
git commit -m "deploy $NOW"
git push origin $BRANCH

#REMOTE
echo "\nGo to remote\n"
ssh mateusz@192.168.10.102 sh $REMOTE_PATH/bin/deployRemote.sh $REMOTE_PATH $BRANCH;

echo "\nDONE!\n";