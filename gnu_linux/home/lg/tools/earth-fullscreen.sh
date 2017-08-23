#!/bin/bash

#
# Google Earth perfect full screen (hides top white menu)
# https://groups.google.com/d/msg/liquid-galaxy/7yK4BDstM3o/t8WxCbvMgRAJ
# Installs Openbox, a windows manager which unlike Gnome 
# makes moving a window below negative vertical axis possible
# Devilspie will automatically detect when Earth window is
# open and move it to the right coordinates.
#

echo "Installing..."
sudo apt-get install -qq openbox devilspie > /dev/null
echo -e "[Desktop Entry]\nName=LG\nExec=bash "$HOME"/earth/scripts/run-devilspie.sh\nType=Application" > $HOME"/.config/autostart/ds.desktop"
sudo sed -i "s/\(autologin-session *= *\).*/\1openbox/" /etc/lightdm/lightdm.conf
sed -i "s/\(wasFullScreen *= *\).*/\1false/" $HOME/earth/config/master/GoogleEarthPro.conf
sed -i "s/\(wasFullScreen *= *\).*/\1false/" $HOME/earth/config/slave/GoogleEarthPro.conf