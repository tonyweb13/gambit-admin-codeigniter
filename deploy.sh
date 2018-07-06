#!/usr/bin/env bash

ENV=$(php artisan env)
IFS=':'
array=( $ENV )
ENV="${array[1]}"

echo ">>> Current environment is${ENV}"

echo ">>> Updating your local copy" && \
cd ~/Code/gbit-opadmin-vlaravel && \

if [ $ENV=" production" ]; then
    CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
    if git remote | grep $CURRENT_BRANCH > /dev/null; then
       echo ">>> Pulling any update for $CURRENT_BRANCH from remote "  && \
       git fetch && git pull origin $CURRENT_BRANCH
    fi
else
    git fetch --tags
    git checkout tags/latest
fi

echo ">>> Installing any new packages from package.json"
if [ $ENV=" production" ]; then
    npm install
else
    npm install --production
fi

echo ">>> Installing any new packages from composer.json"
if [ $ENV=" production" ]; then
    composer install
else
    echo ">>>> Installing without dev"
    composer install --no-dev
fi

echo ">>> Doing some migration script if there is" && \
php artisan migrate && \

echo ">>> Done! Updated."