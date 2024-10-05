

## How to Deploy Your Project on Ubuntu 22.04.4 LTS After Setting Up LAMP

Once you've successfully set up a LAMP (Linux, Apache, MySQL, PHP) stack on Ubuntu 22.04.4 LTS, the next step is to deploy your project. This tutorial guides you through transferring your files, installing necessary packages and dependencies, and running your script.

### Step 1: Identifying Your USB Drive

First, determine the device identifier for your USB drive using the following commands:

```bash
lsblk
sudo blkid
sudo fdisk -l
```

These commands will list your drives, helping you identify your USB drive, typically labeled as `/dev/sdb1`, `/dev/sda1`, or similar.

### Step 2: Mounting the USB Drive

Create a directory to mount your USB drive and then mount it:

```bash
sudo mkdir /media/usb
sudo mount /dev/sdb1 /media/usb
```
*Note:* Replace `/dev/sdb1` with your actual USB device identifier if different.

### Step 3: Locating the Project Paths

To locate the specific directories you need to transfer your files to, you might need to install `plocate`:

```bash
sudo apt install plocate
```

Then, use `locate` to find your project's paths:

```bash
locate <YourProjectName>
```

### Step 4: Transferring Files from USB

#### For Selenium Scripts:

```bash
cp -R /media/usb/seleniumScript/ /home/user01/Energy-Languages-master/Selenium/
```

#### For WordPress:

```bash
cp -R /media/usb/wordpress/ /var/www/html/
```

### Step 5: Importing the Database

Access MySQL, create a new database, and import your `.sql` file:

```bash
sudo mysql -u root -p
```

Then, within MySQL:

```sql
CREATE DATABASE selenium;
USE selenium;
SOURCE /media/usb/selenium.sql;
```

### Step 6: Installing Selenium and Chrome

Update your package lists and install Google Chrome:

```bash
sudo apt update
sudo apt upgrade
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i google-chrome-stable_current_amd64.deb
sudo apt -f install  # Run this if you encounter dependency issues
```

Verify Chrome installation:

```bash
google-chrome --version
```

Install Selenium and WebDriver Manager:

```bash
pip3 install selenium webdriver-manager
```

### Step 7: Setting Up Node.js and Nodemon

Update your system and install Node.js:

```bash
sudo apt update
sudo apt install npm
sudo npm install -g nodemon
```

### Step 8: Unmounting the USB Drive

Safely eject your USB drive:

```bash
sudo umount /media/usb
```

### Step 9: Running Your Script

Finally, run your project script with Nodemon:

```bash
nodemon --exec python3 /home/user01/Energy-Languages-master/Selenium/seleniumScript/main.py
```

