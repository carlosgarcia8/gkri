#!/bin/sh

sudo -u postgres dropdb gkri_test
sudo -u postgres createdb -O gkri gkri_test
