#!/bin/bash

# Periksa apakah /opt/lampp/lampp sedang berjalan
if ! pgrep -x "lampp" > /dev/null
then
    echo "XAMPP is not running. Starting XAMPP..."
    sudo /opt/lampp/lampp start
else
    echo "XAMPP is already running."
fi

# Periksa apakah sub_mqtt.php sedang berjalan
if ! pgrep -f "php sub_mqtt.php" > /dev/null
then
    echo "sub_mqtt.php is not running. Starting sub_mqtt.php..."
    php /opt/lampp/htdocs/siap.smknbansari.sch.id/app/mqtt/sub_mqtt.php
else
    echo "sub_mqtt.php is already running."
fi
