#!/bin/bash

sudo php app/console cache:clear --env=dev
sudo php app/console cache:clear --env=prod

sudo php app/console assets:install web

sudo php app/console assetic:dump --env=prod
sudo php app/console assetic:dump --env=dev

sudo chmod -R 777 /var/server/www/aoshido/.*

