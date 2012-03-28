#!/bin/bash

if [ "x$1" = "x" ] 
 then
   echo "USAGE: addlang.sh INPUT-FILE"
   echo "----------------------------"
   echo "This script will append the contents of INPUT-FILE to every "
   echo "available language file."
   exit 1
 else
   find -maxdepth 1 -name \*.php -exec ./append.sh $1 {} \;
   cd UTF-8
   ./recode.sh
fi
