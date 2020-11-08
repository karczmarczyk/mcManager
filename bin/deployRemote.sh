#!/bin/bash

#"/var/www/minecraft/mcManager"
REMOTE_PATH=$1

#"master"
BRANCH=$2

cd $REMOTE_PATH;

echo "\n---pull from repo\n"
git pull origin $BRANCH;

echo "\n---clean cache\n"
/usr/local/php/bin/php $REMOTE_PATH/bin/console cache:clear;