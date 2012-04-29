#!/bin/sh

rm *.tgz
#pear channel-discover moowahaha.github.com/pear
pear package
cd tmp
rm -fr pear
git clone git@github.com:moowahaha/pear.git
cd pear
pirum add . ../../*.tgz
pirum build .
git add .
git commit -m 'updated package'
git push

