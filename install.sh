#!/bin/bash

cat << "EOM"
 _ _             _     _               _                  
| (_) __ _ _   _(_) __| |   __ _  __ _| | __ ___  ___   _ 
| | |/ _` | | | | |/ _` |  / _` |/ _` | |/ _` \ \/ / | | |
| | | (_| | |_| | | (_| | | (_| | (_| | | (_| |>  <| |_| |
|_|_|\__, |\__,_|_|\__,_|  \__, |\__,_|_|\__,_/_/\_\\__, |
        |_|                |___/                    |___/ 
https://github.com/LiquidGalaxy/liquid-galaxy
https://github.com/LiquidGalaxyLAB/liquid-galaxy
-------------------------------------------------------------

EOM

# Parameters
MASTER=false
MASTER_IP=""
MASTER_USER=$USER
MASTER_HOME=$HOME
MASTER_PASSWORD=""
LOCAL_USER=$USER
MACHINE_ID="1"
MACHINE_NAME="lg"$MACHINE_ID
TOTAL_MACHINES="3"
LG_FRAMES="lg3 lg1 lg2"
OCTET="42"
SCREEN_ORIENTATION="V"
GIT_FOLDER_NAME="liquid-galaxy"
GIT_URL="https://github.com/LiquidGalaxyLAB/liquid-galaxy"
EARTH_DEB="http://dl.google.com/dl/earth/client/current/google-earth-stable_current_i386.deb"
EARTH_FOLDER="/opt/google/earth/pro/"
NETWORK_INTERFACE=$(/sbin/route -n | grep "^0.0.0.0" | rev | cut -d' ' -f1 | rev)
NETWORK_INTERFACE_MAC=$(ifconfig | grep $NETWORK_INTERFACE | awk '{print $5}')
SSH_PASSPHRASE=""

read -p "Machine id (i.e. 1 for lg1) (1 == master): " MACHINE_ID
if [ "$(echo $MACHINE_ID | cut -c-2)" == "lg" ]; then
	MACHINE_ID="$(echo $MACHINE_NAME | cut -c3-)"
fi
MACHINE_NAME="lg"$MACHINE_ID
if [ $MACHINE_ID == "1" ]; then
	MASTER=true
else
	echo "Make sure Master machine (lg1) is connected to the network before proceding!"
	read -p "Master machine IP (i.e. 192.168.1.42): " MASTER_IP
	read -p "Master local user password (i.e. lg password): " MASTER_PASSWORD
fi
read -p "Total machines count (i.e. 3): " TOTAL_MACHINES
read -p "LG frames (i.e. lg3 lg1 lg2): " LG_FRAMES
read -p "Unique number that identifies your Galaxy (octet) (i.e. 42): " OCTET

#
# Pre-start
#

PRINT_IF_NOT_MASTER=""
if [ $MASTER == false ]; then
	PRINT_IF_NOT_MASTER=$(cat <<- EOM

	MASTER_IP: $MASTER_IP
	MASTER_USER: $MASTER_USER
	MASTER_HOME: $MASTER_HOME
	MASTER_PASSWORD: $MASTER_PASSWORD
	EOM
	)
fi

cat << EOM

Liquid Galaxy will be installed with the following configuration:
MASTER: $MASTER
LOCAL_USER: $LOCAL_USER
MACHINE_ID: $MACHINE_ID
MACHINE_NAME: $MACHINE_NAME $PRINT_IF_NOT_MASTER
TOTAL_MACHINES: $TOTAL_MACHINES
OCTET (UNIQUE NUMBER): $OCTET
GIT_URL: $GIT_URL 
GIT_FOLDER: $GIT_FOLDER_NAME
EARTH_DEB: $EARTH_DEB
EARTH_FOLDER: $EARTH_FOLDER
NETWORK_INTERFACE: $NETWORK_INTERFACE
NETWORK_MAC_ADDRESS: $NETWORK_INTERFACE_MAC

Is it correct? Press any key to continue or CTRL-C to exit
EOM
read

if [ "$(cat /etc/os-release | grep NAME=\"Ubuntu\")" == "" ]; then
	echo "Warning!! This script is meant to be run on an Ubuntu OS. It may not work as expected."
	echo -n "Press any key to continue or CTRL-C to exit"
	read
fi

if [[ $EUID -eq 0 ]]; then
   echo "Do not run it as root!" 1>&2
   exit 1
fi

# Initialize sudo access
sudo -v

#
# General
#

export DEBIAN_FRONTEND=noninteractive

# Update OS
echo "Checking for system updates..."
sudo apt-get update

echo "Upgrading system packages ..."
sudo apt-get -yq upgrade

echo "Installing new packages..."
sudo apt-get install -yq git chromium-browser nautilus openssh-server sshpass squid3 squid-cgi apache2 xdotool unclutter

echo "Installing Google Earth..."
wget -q $EARTH_DEB
sudo dpkg -i google-earth-stable*.deb
sudo apt-get -yq -f install
sudo dpkg -i google-earth-stable*.deb
rm google-earth-stable*.deb

# OS config tweaks (like disabling idling, hiding launcher bar, ...)
echo "Setting system configuration..."
sudo tee /etc/lightdm/lightdm.conf > /dev/null << EOM
[Seat:*]
autologin-guest=false
autologin-user=$LOCAL_USER
autologin-user-timeout=0
autologin-session=ubuntu
EOM
echo autologin-user=lg >> sudo /etc/lightdm/lightdm.conf
gsettings set org.gnome.desktop.screensaver idle-activation-enabled false
gsettings set org.gnome.desktop.session idle-delay 0
gsettings set org.gnome.desktop.screensaver lock-enabled false
gsettings set org.gnome.settings-daemon.plugins.power idle-dim false
echo -e 'Section "ServerFlags"\nOption "blanktime" "0"\nOption "standbytime" "0"\nOption "suspendtime" "0"\nOption "offtime" "0"\nEndSection' | sudo tee -a /etc/X11/xorg.conf > /dev/null
gsettings set org.compiz.unityshell:/org/compiz/profiles/unity/plugins/unityshell/ launcher-hide-mode 1
sudo update-alternatives --set x-www-browser /usr/bin/chromium-browser
sudo update-alternatives --set gnome-www-browser /usr/bin/chromium-browser
sudo apt-get remove --purge -yq update-notifier*

#
# Liquid Galaxy
#

# Setup Liquid Galaxy files
echo "Setting up Liquid Galaxy..."
git clone $GIT_URL

sudo cp -r $GIT_FOLDER_NAME/earth/ $HOME
sudo ln -s $EARTH_FOLDER $HOME/earth/builds/latest
awk '/LD_LIBRARY_PATH/{print "export LC_NUMERIC=en_US.UTF-8"}1' $HOME/earth/builds/latest/googleearth | sudo tee $HOME/earth/builds/latest/googleearth > /dev/null

# Enable solo screen for slaves
if [ $MASTER != true ]; then
	sudo sed -i -e 's/slave_x/slave_'${MACHINE_ID}'/g' $HOME/earth/kml/slave/myplaces.kml
	sudo sed -i -e 's/sync_nlc_x/sync_nlc_'${MACHINE_ID}'/g' $HOME/earth/kml/slave/myplaces.kml
fi

sudo cp -r $GIT_FOLDER_NAME/gnu_linux/home/lg/. $HOME

cd $HOME"/dotfiles/"
for file in *; do
    sudo mv "$file" ".$file"
done
sudo cp -r . $HOME
cd - > /dev/null

sudo cp -r $GIT_FOLDER_NAME/gnu_linux/etc/ $GIT_FOLDER_NAME/gnu_linux/patches/ $GIT_FOLDER_NAME/gnu_linux/sbin/ /

sudo chmod 0440 /etc/sudoers.d/42-lg
sudo ln -s /etc/apparmor.d/sbin.dhclient /etc/apparmor.d/disable/
sudo apparmor_parser -R /etc/apparmor.d/sbin.dhclient
sudo /etc/init.d/apparmor restart > /dev/null
sudo chown -R $LOCAL_USER:$LOCAL_USER $HOME
sudo chown $LOCAL_USER:$LOCAL_USER /home/lg/earth/builds/latest/drivers.ini

# Configure SSH
if [ $MASTER == true ]; then
	echo "Setting up SSH..."
	$HOME/tools/clean-ssh.sh
else
	echo "Starting SSH files sync with master..."
	sshpass -p "$MASTER_PASSWORD" scp -o StrictHostKeyChecking=no $MASTER_IP:$MASTER_HOME/ssh-files.zip $HOME/
	unzip $HOME/ssh-files.zip -d $HOME/ > /dev/null
	sudo cp -r $HOME/ssh-files/etc/ssh /etc/
	sudo cp -r $HOME/ssh-files/root/.ssh /root/ 2> /dev/null
	sudo cp -r $HOME/ssh-files/user/.ssh $HOME/
	sudo rm -r $HOME/ssh-files/
	sudo rm $HOME/ssh-files.zip
fi
sudo chmod 0600 $HOME/.ssh/lg-id_rsa
sudo chmod 0600 /root/.ssh/authorized_keys
sudo chmod 0600 /etc/ssh/ssh_host_dsa_key
sudo chmod 0600 /etc/ssh/ssh_host_ecdsa_key
sudo chmod 0600 /etc/ssh/ssh_host_rsa_key
sudo chown -R $LOCAL_USER:$LOCAL_USER $HOME/.ssh

# prepare SSH files for other nodes (slaves)
if [ $MASTER == true ]; then
	mkdir -p ssh-files/etc
	sudo cp -r /etc/ssh ssh-files/etc/
	mkdir -p ssh-files/root/
	sudo cp -r /root/.ssh ssh-files/root/ 2> /dev/null
	mkdir -p ssh-files/user/
	sudo cp -r $HOME/.ssh ssh-files/user/
	sudo zip -FSr "ssh-files.zip" ssh-files
	if [ $(pwd) != $HOME ]; then
		sudo mv ssh-files.zip $HOME/ssh-files.zip
	fi
	sudo chown -R $LOCAL_USER:$LOCAL_USER $HOME/ssh-files.zip
	sudo rm -r ssh-files/
fi

# Screens configuration
cat > $HOME/personavars.txt << 'EOM'
DHCP_LG_FRAMES="lg3 lg1 lg2"
DHCP_LG_FRAMES_MAX=3

FRAME_NO=$(cat /home/lg/frame 2>/dev/null)
DHCP_LG_SCREEN="$(( ${FRAME_NO} + 1 ))"
DHCP_LG_SCREEN_COUNT=1
DHCP_OCTET=42
DHCP_LG_PHPIFACE="http://lg1:81/"

DHCP_EARTH_PORT=45678
DHCP_EARTH_BUILD="latest"
DHCP_EARTH_QUERY="/tmp/query.txt"

DHCP_MPLAYER_PORT=45680
EOM
sed -i "s/\(DHCP_LG_FRAMES *= *\).*/\1\"$LG_FRAMES\"/" $HOME/personavars.txt
sed -i "s/\(DHCP_LG_FRAMES_MAX *= *\).*/\1$TOTAL_MACHINES/" $HOME/personavars.txt
sed -i "s/\(DHCP_OCTET *= *\).*/\1$OCTET/" $HOME/personavars.txt
sudo $HOME/bin/personality.sh $MACHINE_ID $OCTET > /dev/null

# Network configuration
sudo tee -a "/etc/network/interfaces" > /dev/null << EOM
auto eth0
iface eth0 inet dhcp
EOM
sudo sed -i "s/\(managed *= *\).*/\1true/" /etc/NetworkManager/NetworkManager.conf
echo "SUBSYSTEM==\"net\",ACTION==\"add\",ATTR{address}==\"$NETWORK_INTERFACE_MAC\",KERNEL==\"$NETWORK_INTERFACE\",NAME=\"eth0\"" | sudo tee /etc/udev/rules.d/10-network.rules > /dev/null
sudo sed -i '/lgX.liquid.local/d' /etc/hosts
sudo sed -i '/kh.google.com/d' /etc/hosts
sudo sed -i '/10.42./d' /etc/hosts
sudo tee -a "/etc/hosts" > /dev/null 2>&1 << EOM
10.42.$OCTET.1  lg1
10.42.$OCTET.2  lg2
10.42.$OCTET.3  lg3
10.42.$OCTET.4  lg4
10.42.$OCTET.5  lg5
10.42.$OCTET.6  lg6
10.42.$OCTET.7  lg7
10.42.$OCTET.8  lg8
EOM
sudo sed -i '/10.42./d' /etc/hosts.squid
sudo tee -a "/etc/hosts.squid" > /dev/null 2>&1 << EOM
10.42.$OCTET.1  lg1
10.42.$OCTET.2  lg2
10.42.$OCTET.3  lg3
10.42.$OCTET.4  lg4
10.42.$OCTET.5  lg5
10.42.$OCTET.6  lg6
10.42.$OCTET.7  lg7
10.42.$OCTET.8  lg8
EOM
sudo tee "/etc/iptables.conf" > /dev/null << EOM
*filter
:INPUT ACCEPT [0:0]
:FORWARD ACCEPT [0:0]
:OUTPUT ACCEPT [43616:6594412]
-A INPUT -i lo -j ACCEPT
-A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
-A INPUT -p icmp -j ACCEPT
-A INPUT -p tcp -m multiport --dports 22 -j ACCEPT
-A INPUT -s 10.42.0.0/16 -p udp -m udp --dport 161 -j ACCEPT
-A INPUT -s 10.42.0.0/16 -p udp -m udp --dport 3401 -j ACCEPT
-A INPUT -p tcp -m multiport --dports 81,8111 -j ACCEPT
-A INPUT -s 10.42.$OCTET.0/24 -p tcp -m multiport --dports 80,3128,3130 -j ACCEPT
-A INPUT -s 10.42.$OCTET.0/24 -p udp -m multiport --dports 80,3128,3130 -j ACCEPT
-A INPUT -s 10.42.$OCTET.0/24 -p tcp -m multiport --dports 9335 -j ACCEPT
-A INPUT -s 10.42.$OCTET.0/24 -d 10.42.$OCTET.255/32 -p udp -j ACCEPT
-A INPUT -j DROP
-A FORWARD -j DROP
COMMIT
*nat
:PREROUTING ACCEPT [52902:8605309]
:INPUT ACCEPT [0:0]
:OUTPUT ACCEPT [358:22379]
:POSTROUTING ACCEPT [358:22379]
COMMIT
EOM

# Launch on boot
mkdir -p $HOME/.config/autostart/
echo -e "[Desktop Entry]\nName=LG\nExec=bash "$HOME"/bin/startup-script.sh\nType=Application" > $HOME"/.config/autostart/lg.desktop"

# Web interface
if [ $MASTER == true ]; then
	echo "Installing web interface (master only)..."
	sudo apt-get -yq install php php-cgi libapache2-mod-php
	sudo touch /etc/apache2/httpd.conf
	sudo sed -i '/accept.lock/d' /etc/apache2/apache2.conf
	sudo rm /var/www/html/index.html
	sudo cp -r $GIT_FOLDER_NAME/php-interface/. /var/www/html/
	sudo chown -R $LOCAL_USER:$LOCAL_USER /var/www/html/
fi

# Cleanup
sudo rm -r $GIT_FOLDER_NAME

#
# Global cleanup
#

echo "Cleaning up..."
sudo apt-get -yq autoremove

echo "Liquid Galaxy installation completed! :-)"
echo "Press any key to reboot now"
read
reboot

exit 0
