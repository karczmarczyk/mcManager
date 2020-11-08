#!/bin/bash

#"/var/www/minecraft/mcManager"
REMOTE_PATH=$1

#"master"
BRANCH=$2

cd $REMOTE_PATH;
git pull origin $BRANCH;
/usr/local/php/bin/php $REMOTE_PATH/bin/console cache:clear;