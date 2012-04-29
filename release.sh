#!/bin/sh

rm *.tgz
pear package
cd tmp
rm -fr pear
git clone git@github.com:moowahaha/pear.git
cd pear
pirum add . ../../*.tgz
git add .
git commit -m 'updated package'
git push

