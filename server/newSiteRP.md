To create another WordPress instance called **site** with permalinks accessible at `192.168.137.102/site`, follow these steps:

### Steps to Create WordPress Instance for `site`

#### 1. **Create a New Directory for `site`:**

First, create a directory for `site` inside `/var/www/html`:

```bash
sudo mkdir /var/www/html/site
```

#### 2. **Download and Set Up WordPress for `site`:**

Download the latest WordPress package or copy the existing WordPress files from your current installation (site1) to the new `site` folder.

- If you want to download it:

```bash
cd /var/www/html/site
sudo wget https://wordpress.org/latest.tar.gz
sudo tar -xzvf latest.tar.gz
sudo mv wordpress/* .
sudo rm -rf wordpress latest.tar.gz
```

- Alternatively, you can copy the WordPress files from already existing wordpress  `wpSite` installation:

```bash
sudo cp -r /var/www/html/wpSite/* /var/www/html/site/
```

#### 3. **Set Up a Separate Database for `site`:**

Create a new database for the `site` WordPress installation.

1. Log in to MySQL:

   ```bash
   sudo mysql -u root -p
   ```

2. Create a new database:

   ```sql
   CREATE DATABASE wordpress_site_db;
   ```

3. Create a new user and grant privileges (or reuse an existing user like `root` if you prefer):

   ```sql
   CREATE USER 'siteuser'@'localhost' IDENTIFIED BY 'your_password';
   GRANT ALL PRIVILEGES ON wordpress_site_db.* TO 'siteuser'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

#### 4. **Configure wp-config.php for `site`:**

1. Navigate to the `site` directory:

   ```bash
   cd /var/www/html/site
   ```

2. Edit the `wp-config.php` file to use the new database for `site`:

   ```bash
   sudo nano wp-config.php
   ```

3. Update the database settings for `site`:

   ```php
   define('DB_NAME', 'wordpress_site_db');
   define('DB_USER', 'siteuser');
   define('DB_PASSWORD', 'your_password');
   define('DB_HOST', 'localhost');
   ```

4. Set the correct URL for `site` in the same `wp-config.php` file:

   ```php
   define('WP_HOME', 'http://192.168.137.102/site');
   define('WP_SITEURL', 'http://192.168.137.102/site');
   ```

Save and exit (`Ctrl + X`, then `Y`, and `Enter`).

#### 5. **Set Correct Permissions for `site`:**

Make sure `site` has the correct ownership and permissions:

```bash
sudo chown -R www-data:www-data /var/www/html/site
sudo find /var/www/html/site/ -type d -exec chmod 755 {} \;
sudo find /var/www/html/site/ -type f -exec chmod 644 {} \;
```

#### 6. **Enable Permalinks for `site`:**

WordPress needs Apache’s `mod_rewrite` module for permalinks to work. If it’s not enabled, enable it:

```bash
sudo a2enmod rewrite
```

Create or modify the `.htaccess` file in `/var/www/html/site` to include WordPress rewrite rules:

```bash
sudo nano /var/www/html/site/.htaccess
```

Add the following content:

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /site/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /site/index.php [L]
</IfModule>
# END WordPress
```

Save the file and exit.

#### 7. **Restart Apache**:

After making these changes, restart Apache:

```bash
sudo systemctl restart apache2
```

#### 8. **Complete WordPress Setup for `site`:**

Now, go to your browser and navigate to `http://192.168.137.102/site` to complete the WordPress installation.

Once you log into the WordPress dashboard for `site`, you can go to **Settings > Permalinks** and configure your preferred permalink structure (like "Post name") and save it to generate the appropriate `.htaccess` rules.

After completing these steps, you should be able to access `site` at `http://192.168.137.102/site` with permalinks enabled.

