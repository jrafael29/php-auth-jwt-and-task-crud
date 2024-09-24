#!/bin/bash

service nginx start &

php worker.php &

php-fpm

# php testarScrap.php