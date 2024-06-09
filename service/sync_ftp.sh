#!/bin/bash

HOST='zzz.com.ua'
USER='zorkiysv'
PASS='CfBzjRHUb574@TW'
LOCAL_DIR='/var/www/html/document-flow.loc/'
REMOTE_DIR='/notes.petamicr.zzz.com.ua'

lftp -u $USER,$PASS $HOST << EOF
mirror --reverse --delete --verbose $LOCAL_DIR $REMOTE_DIR
quit
EOF
