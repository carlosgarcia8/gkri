#!/bin/sh

sudo -u postgres dropuser gkri
sudo -u postgres dropdb gkri
sudo -u postgres psql -c "create user gkri password 'gkri' superuser;"
sudo -u postgres createdb -O gkri gkri
