# Energy-Efficient-WordPress-Development

```markdown
# Project Setup on Raspberry Pi (Ubuntu 20.04)

This project requires both a **WordPress server** (with multiple instances, wpsite and wpsite2) and a **client-side Python script** to be installed on a Raspberry Pi running Ubuntu 20.04. Follow the steps below to set up both the server and client environments before running the project.

## Prerequisites

- A Raspberry Pi running **Ubuntu 20.04**.
- WordPress installed on the server (with instances named wpsite and wpsite2- we created 6 of those, this is just an example ).
- Python and `pip` installed on the client (for running the script).
- Network connectivity between the client and server.

## Server Setup (WordPress for wpsite and wpsite2)

### 1. Update the Raspberry Pi

Ensure your Raspberry Pi is up to date:

```bash
sudo apt update
sudo apt upgrade
```

### 2. Create a New WordPress Instance (`wpsite2`)

To create another WordPress instance called **wpsite2** with permalinks accessible at `192.168.137.102/wpsite2`, follow these steps:

#### a. **Create a New Directory for `wpsite2`**

```bash
sudo mkdir /var/www/html/wpsite2
```

#### b. **Download and Set Up WordPress for `wpsite2`**

Either download a fresh WordPress package or copy the existing WordPress files from `wpsite`:

- Download the WordPress package:
    ```bash
    cd /var/www/html/wpsite2
    sudo wget https://wordpress.org/latest.tar.gz
    sudo tar -xzvf latest.tar.gz
    sudo mv wordpress/* .
    sudo rm -rf wordpress latest.tar.gz
    ```

- Or copy from `wpsite`:
    ```bash
    sudo cp -r /var/www/html/wpsite/* /var/www/html/wpsite2/
    ```

#### c. **Set Up a Separate Database for `wpsite2`**

1. Log into MySQL:
    ```bash
    sudo mysql -u root -p
    ```

2. Create a new database for `wpsite2`:
    ```sql
    CREATE DATABASE wordpress_wpsite2_db;
    CREATE USER 'wpsite2user'@'localhost' IDENTIFIED BY 'your_password';
    GRANT ALL PRIVILEGES ON wordpress_wpsite2_db.* TO 'wpsite2user'@'localhost';
    FLUSH PRIVILEGES;
    EXIT;
    ```

#### d. **Configure `wp-config.php` for `wpsite2`**

Update the `wp-config.php` file in `/var/www/html/wpsite2` to point to the new database:

```php
define('DB_NAME', 'wordpress_wpsite2_db');
define('DB_USER', 'wpsite2user');
define('DB_PASSWORD', 'your_password');
define('WP_HOME', 'http://192.168.137.102/wpsite2');
define('WP_SITEURL', 'http://192.168.137.102/wpsite2');
```

#### e. **Set Correct Permissions for `wpsite2`**

```bash
sudo chown -R www-data:www-data /var/www/html/wpsite2
sudo find /var/www/html/wpsite2/ -type d -exec chmod 755 {} \;
sudo find /var/www/html/wpsite2/ -type f -exec chmod 644 {} \;
```

#### f. **Enable Permalinks for `wpsite2`**

1. Enable Apache's `mod_rewrite` module:
    ```bash
    sudo a2enmod rewrite
    ```

2. Modify the `.htaccess` file in `/var/www/html/wpsite2`:
    ```apache
    # BEGIN WordPress
    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /wpsite2/
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /wpsite2/index.php [L]
    </IfModule>
    # END WordPress
    ```

#### g. **Restart Apache**

```bash
sudo systemctl restart apache2
```

### 3. Complete WordPress Setup for `wpsite2`

Go to `http://192.168.137.102/wpsite2` in your browser to complete the WordPress installation. Set up permalinks in **Settings > Permalinks**.

## Client Setup (Python Script)

### 1. Install Python and Pip

On the client machine (which is also the Raspberry Pi), install Python 3.x and `pip`:

```bash
sudo apt install python3 python3-pip
```

Verify the installation:

```bash
python3 --version
pip3 --version
```

### 2. Install Required Python Packages

Navigate to the project folder where your script is located and install the necessary Python dependencies using `pip`:

```bash
pip3 install selenium webdriver-manager
```

### 3. Install Chrome and ChromeDriver

To run Selenium on the Raspberry Pi, you need to install Chrome and ChromeDriver:

```bash
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo apt install ./google-chrome-stable_current_amd64.deb
```

Then install `chromedriver` via `webdriver-manager`:

```bash
pip3 install webdriver-manager
```

### 4. Configure the Client (Script)

Make sure the `config.json` file is properly configured for the Python script to interact with the WordPress instances (wpsite or wpsite2). This file should include the correct URLs and actions to be performed by the script.

## Running the Project

### 1. Start WordPress Server

Ensure the WordPress server for `wpsite` and `wpsite2` is up and running. You can access your WordPress installation at:

```
http://192.168.137.102/wpsite
http://192.168.137.102/wpsite2
```

### 2. Run the Python Script on the Client

Once the server is running and accessible, you can run the Python script on the client:

```bash
python3 main.py
```

This will execute the Selenium script that interacts with the WordPress site based on the configuration in `config.json`.

## Notes

- Make sure the server and client are on the same local network for smooth communication.
- Ensure the correct paths to ChromeDriver and other resources are set in the environment or project settings.
- If you encounter issues, check logs or output for troubleshooting and verify the connection between the client (script) and server (WordPress).
```


