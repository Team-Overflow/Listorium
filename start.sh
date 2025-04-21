#!/bin/bash
cd $(dirname "$0")
fuser -k 8000/tcp > /dev/null 2>&1
php -S localhost:8000 &
sleep 1
xdg-open http://localhost:8000