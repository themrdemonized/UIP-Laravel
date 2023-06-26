#!/bin/bash

sed -i "s/{{DB_CONNECTION}}/${DB_CONNECTION}/g" /etc/apache2/sites-enabled/000-default.conf
sed -i "s/{{DB_HOST}}/${DB_HOST}/g" /etc/apache2/sites-enabled/000-default.conf
sed -i "s/{{DB_PORT}}/${DB_PORT}/g" /etc/apache2/sites-enabled/000-default.conf
sed -i "s/{{DB_DATABASE}}/${DB_DATABASE}/g" /etc/apache2/sites-enabled/000-default.conf
sed -i "s/{{DB_USERNAME}}/${DB_USERNAME}/g" /etc/apache2/sites-enabled/000-default.conf
sed -i "s/{{DB_PASSWORD}}/${DB_PASSWORD}/g" /etc/apache2/sites-enabled/000-default.conf

service apache2 start

sleep infinity
