nodefiles
=========

##Install Ubuntu
To get your BeagleBoard running Ubuntu you can follow these steps:

Download BBB-eMMC-flasher-ubuntu-14.04-console-armhf-2014-07-06-2gb.img.xz.  Note, the oringal file can also be downloaded from http://elinux.org/BeagleBoardUbuntu

Use pie baker http://www.tweaking4all.com/hardware/raspberry-pi/macosx-apple-pi-baker/ to image the SD card.  You can tip the author at 1Fz9fgpj2VcRodG5A5jJcQubiZLxtfjNRx

After you have put the BeageBone Black Ubuntu Flasher image on a micro SD card, insert it into the powered-off BBB.
Also make sure you have a keyboard, mouse, display, and Ethernet connected.

While holding down the 'boot' button, apply power to the board. Continue to hold the 'boot' button until the USER LEDs begin to flash.

You should use a 5V external power source, USB power may not work.
After about a minute your screen should show the login prompt.
Leave the board be for about 10 minutes; the image is being flashed to the eMMC.
After about 10 minutes have passed the 4 LEDs should be solid and not flickering. Remove the power, remove the mirco SD, and then re-apply power to the board.
It will take a minute or two for the board to boot to the log-in screen

User is: ubuntu
Password is: temppwd

Note: echo is turned off for typing in password
You should now be in the command terminal for Ubuntu and your BeagleBone Black will boot here from now on.

SSH into the box by SSH ubuntu@hostname.  Change the default password by using 'passwd' command.

###Pre Reqs
```
sudo apt-get update
sudo ntpdate 0.pool.ntp.org
sudo apt-get install build-essential libboost-all-dev automake libtool autoconf
sudo apt-get install libdb++-dev
sudo apt-get install libboost-all-dev
sudo apt-get install pkg-config
sudo apt-get install libssl-dev
sudo apt-get install pmount
sudo apt-get install git
```

###Mount drive
Format the usb flash drive using xfs
```
sudo mkfs.xfs /dev/sda -f
```

Find the usb flash drive by using sudo fdisk -l
```
sudo mkdir /media/external
pmount /dev/sda external
```

~~sudo mount -t vfat /dev/sda /media/external -o uid=1000,gid=1000,utf8,dmask=027,fmask=137~~

###Create swap file
The memory on the beagle board is too small to compile, so we will need to make a swap file on the SD card.
```
sudo free
sudo dd if=/dev/zero of=/var/swap.img bs=512k count=1000
sudo mkswap /var/swap.img
sudo swapon /var/swap.img
sudo free
```

###Build bitcoind
Now we will get bitcoin source from github (bitcoin brisbane fork) and compile.  Feel free to use the bitcoin/bitcoin repository if you like.
```
sudo git clone https://github.com/bitcoin/bitcoin
cd bitcoin
sudo git checkout 0.10
sudo ./autogen.sh
sudo ./configure --with-incompatible-bdb --with-boost-libdir=/usr/lib/arm-linux-gnueabihf
sudo make 
sudo make install
```

Note, if there is an error on autogen.sh, re install the pre reqs.

###Move blocks
Because the emmc memory is small, we will create a symbolic link to the SD card and move the gensis block (/media/external/blocks)
```
sudo mv ~/.bitcoin/blocks /media/external/
sudo mv ~/.bitcoin/chainstate /media/external/
sudo ln -s /media/external/blocks blocks
sudo ln -s /media/external/chainstate chainstate
```

###Configure
Last step we need to add the bitcoin config file.
```
cd ~/.bitcoin
sudo nano bitcoin.conf
```

Add the following:
```
server=1
daemon=1
rpcuser=bitcoinbrisbane
rpcpassword=441f5cc0839c6aa669506c734b8d6cadf10db229
```

**Notes**
```
chmod u+rwx backup
./backup
```

###Install PHP
```
sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt
```

###Install CURL
todo:  add curl instructions. PHP requires curl to call the node.

###Deploy the wallet website
```
cd ~ && sudo rm -rf /var/www/html && sudo git clone -b release https://github.com/bitcoinbrisbane/10000nodes /var/www/html
```

###Done
The daemon should now be ready to start.  Simply type bitcoind

###Todo
Startup scripts

**Refrences**
http://elinux.org/Beagleboard:Ubuntu_On_BeagleBone_Black
https://bitcointalk.org/index.php?topic=304389.0
