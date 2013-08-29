#!/bin/bash
if [[ $(/usr/bin/id -u) -ne 0 ]]; then
    echo "Not running as root"
    exit
fi

chmod 0600 /home/lg/.ssh/lg-id_rsa
chmod 0600 /root/.ssh/authorized_keys
chmod 0600 /etc/ssh/ssh_host_dsa_key
chmod 0600 /etc/ssh/ssh_host_ecdsa_key
chmod 0600 /etc/ssh/ssh_host_rsa_key

chown -R lg:lg /home/lg/.ssh
