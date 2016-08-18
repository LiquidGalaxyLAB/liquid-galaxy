#!/bin/bash

#
# Google Earth perfect full screen (hides top white menu)
#

echo "Installing..."
sudo apt-get install -qq openbox devilspie > /dev/null
echo -e "[Desktop Entry]\nName=LG\nExec=bash "$HOME"/earth/scripts/run-devilspie.sh\nType=Application" > $HOME"/.config/autostart/ds.desktop"
sudo sed -i "s/\(autologin-session *= *\).*/\1openbox/" /etc/lightdm/lightdm.conf
sed -i "s/\(wasFullScreen *= *\).*/\1false/" $HOME/earth/config/master/GoogleEarthPlus.conf-7.1.2
sed -i "s/\(wasFullScreen *= *\).*/\1false/" $HOME/earth/config/slave/GoogleEarthPlus.conf-7.1.2