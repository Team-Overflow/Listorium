#!/bin/bash
cd $(dirname "$0")
php -S localhost:8000 &
sleep 1
xdg-open http://localhost:8000