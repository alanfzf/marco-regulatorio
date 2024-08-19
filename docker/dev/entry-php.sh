#!/bin/bash
set -eo pipefail

PROJECT_H="/var/www/${GIT_REPO}"
branch="test"

if [ ! -d "${PROJECT_H}" ]; then
    # CREATE THE FOLDER
    mkdir -p "${PROJECT_H}"
    # CLONE THE REPOSITORY
    git clone -b "$branch" "https://${GIT_TOKEN}@github.com/alanfzf/${GIT_REPO}" ${PROJECT_H} || exit -1
    # INSTALL THE COMPOSER DEPENDENCIES
    composer install --working-dir="${PROJECT_H}"
fi

# CHANGE DIRECTORY
cd "$PROJECT_H"

# CREATE LOCK FILE FOR CHECKHEALTH
touch /tmp/fs_ok.lock

exec php artisan serve --host=0.0.0.0 --port=80
