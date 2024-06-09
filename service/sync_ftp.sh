#!/bin/bash

HOST='zzz.com.ua'
USER='zorkiysv'
PASS='CfBzjRHUb574@TW'
LOCAL_DIR='/var/www/html/document-flow.loc/'
REMOTE_DIR='/notes.petamicr.zzz.com.ua'

lftp -u $USER,$PASS $HOST << EOF
mirror --reverse --delete --verbose --exclude ".git" --exclude "service" --exclude "README.md" --exclude ".gitignore" --exclude "test.sql" --exclude ".editorconfig" --exclude ".vscode" --exclude ".php81" $LOCAL_DIR $REMOTE_DIR
quit
EOF
