import os
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from dotenv import load_dotenv  # Import the load_dotenv function

load_dotenv(".env.local")  # Load environment variables from .env.local file

# Set the location of the webdriver
s = Service("./chromedriver.exe")

driver = webdriver.Chrome(service=s)

driver.get("http://selenium-masterthesis.test/wp-admin")

# Get username and password from environment variables
username = os.environ["WP_USER"]
password = os.environ["WP_PASS"]

# Fill in username
username_box = driver.find_element(By.ID, "user_login")
username_box.send_keys(username)

# Fill in password
password_box = driver.find_element(By.ID, "user_pass")
password_box.send_keys(password)

# Click the login button
login_button = driver.find_element(By.ID, "wp-submit")
login_button.click()


display_name = driver.find_element(by=By.CLASS_NAME, value="display-name")
if display_name.text == "admin":
    print("Login succesful")


while True:
    pass
