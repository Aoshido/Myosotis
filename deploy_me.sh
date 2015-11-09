#!/bin/bash

if [ ! -f ./aosymf.zip ]; then
        echo "Creando Zip..."
        rm -rf ./app/cache/*
        rm -rf ./app/logs/*
        zip -r aosymf.zip app bin src web aosymf.db
        curl -T aosymf.zip ftp.aoshido.com.ar/ --user myosotis@aoshido.com.ar:Myosotis777
else
        echo "Ya hay un zip!"
fi
