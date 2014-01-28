#!/bin/bash
if [[ $(/usr/bin/id -u) -ne 0 ]]; then
    echo "Not running as root"
    exit
fi

chmod 0440 /etc/sudoers.d/42-lg
chmod 0440 /etc/sudoers.d/44-benchmark
ln -s /etc/apparmor.d/sbin.dhclient /etc/apparmor.d/disable/
apparmor_parser -R /etc/apparmor.d/sbin.dhclient
/etc/init.d/apparmor restart
chown -R lg:lg /home/lg/
chown lg:lg /home/lg/earth/builds/latest/drivers.ini
chmod +s /home/lg/chown_tmp_query

