#!/bin/bash

app/console cache:clear --env=dev
app/console cache:clear --env=prod

app/console assets:install web

app/console assetic:dump --env=prod
app/console assetic:dump --env=dev

sudo chmod -R 775 app/cache/

