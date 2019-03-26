#!/bin/bash

TAG=$1

# Build frontend
cd frontend
npm run build:prod
cd ..

# Copy frontend to /public
mkdir ./frontend/dist/public/assets/lang
cp -Rf ./frontend/dist/public/* ./backend/public
mv -f ./backend/public/index.html ./backend/resources/views/index.blade.php

mkdir release

# Init service

docker-compose up -d
echo "Waiting for container to be up..."
sleep 10
docker exec -it --user root actiogame_myapp_1 sh -c "chown bitnami:bitnami -R *"
docker cp actiogame_myapp_1:/app ./release
docker-compose down -v

git fetch
git checkout -t origin/release
git checkout release

# Delete all files but the release app folder
shopt -s extglob
rm -rf !(.git|release) 
rm -rf ./release/app/.git 
rm -f ./release/app/.gitignore 
mv ./release/app/* .
mv ./release/app/.* .
rm -rf ./release

git add -A
git commit -m "Release ${TAG}"
git tag -a $TAG -m "Release ${TAG}"

git checkout master
git submodule update

cd frontend
npm i