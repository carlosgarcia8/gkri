#!/bin/sh

cd ..
./yii migrate --migrationPath=@vendor/yii2mod/yii2-comments/migrations
./yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
