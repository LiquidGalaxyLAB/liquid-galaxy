#!/bin/bash
if [[ $(/usr/bin/id -u) -ne 0 ]]; then
    echo "Not running as root"
    exit
fi

echo autologin-user=lg >> /etc/lightdm/lightdm.conf
gsettings set org.gnome.desktop.screensaver idle-activation-enabled false
apt-get install chromium-browser nautilus git
apt-get install openssh-server squid3 squid-cgi apache2 xdotool unclutter
update-alternatives --set x-www-browser /usr/bin/chromium-browser
update-alternatives --set gnome-www-browser /usr/bin/chromium-browser


