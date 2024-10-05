from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import json
import logging
import logging.handlers
import csv
import os
from dotenv import load_dotenv
from time import sleep
from queue import Queue  # Make sure to import Queue


# Remove all handlers associated with the root logger object.
for handler in logging.root.handlers[:]:
    logging.root.removeHandler(handler)


# Configure logging
log_queue = Queue(-1)  # Initialize the log_queue
queue_handler = logging.handlers.QueueHandler(log_queue)
file_handler = logging.FileHandler("logs/selenium_log.csv")
stream_handler = logging.StreamHandler()
formatter = logging.Formatter("%(asctime)s - %(levelname)s - %(message)s")
file_handler.setFormatter(formatter)
stream_handler.setFormatter(formatter)

logger = logging.getLogger()
logger.addHandler(queue_handler)
logger.addHandler(file_handler)
logger.addHandler(stream_handler)
logger.setLevel(logging.INFO)

# Write headers to CSV
if not os.path.exists("logs"):
    os.makedirs("logs")

with open("logs/selenium_log.csv", "w", newline="") as f:
    writer = csv.writer(f)
    writer.writerow(["Timestamp", "Level", "Message"])

# Load environment variables
load_dotenv(".env.local")

# Load JSON config
with open("config.json", "r") as f:
    config = json.load(f)


class WebLoggerHandler(logging.Handler):
    def __init__(self, driver):
        super().__init__()
        self.driver = driver

    def emit(self, record):
        message = self.format(record).replace('"', '"')  # escape double quotes
        update_logger_element_script = f"""
        var logDiv = document.getElementById('loggerElement');
        var messageDiv = document.createElement('div');
        messageDiv.textContent = "{message}";
        logDiv.appendChild(messageDiv);
        logDiv.scrollTop = logDiv.scrollHeight;
        """
        try:
            self.driver.execute_script(update_logger_element_script)
        except:
            pass


# Use site1 as the default site; change as needed
current_site = "site1"

# Set up WebDriver
s = Service("./chromedrivers/128/chromedriver")
logger.info("Starting the WebDriver.")
sleep(2)


# Navigate to the site
logger.info(f"Navigating to {config[current_site]['url']}.")
driver = webdriver.Chrome(service=s)
driver.get(config[current_site]["url"])
sleep(2)

# Create the logger element in the browser
create_logger_element_script = """
var logDiv = document.createElement('div');
logDiv.id = 'loggerElement';
logDiv.style.position = 'fixed';
logDiv.style.bottom = '0';
logDiv.style.right = '0';
logDiv.style.maxHeight = '100px';
logDiv.style.width = '300px';
logDiv.style.overflowY = 'scroll';
logDiv.style.background = 'rgba(0,0,0,0.7)';
logDiv.style.color = 'white';
logDiv.style.padding = '10px';
logDiv.style.borderRadius = '5px';
logDiv.style.zIndex = '9999';
document.body.appendChild(logDiv);
"""

driver.execute_script(create_logger_element_script)

# Add the web logger handler
web_logger_handler = WebLoggerHandler(driver)
web_logger_handler.setFormatter(formatter)
logger.addHandler(web_logger_handler)

# Wait for WebDriver
wait = WebDriverWait(driver, 10)


# Define a function to style an element with background color, border, and animation
def style_element(xpath):
    try:
        logger.info(f"Waiting for the element with xpath: {xpath} to be present.")
        element = wait.until(EC.presence_of_element_located((By.XPATH, xpath)))

        # Scroll to the element smoothly
        scroll_script = """
        var elementPosition = arguments[0].getBoundingClientRect().top + window.pageYOffset;
        window.scroll({
          top: elementPosition - (window.innerHeight / 2),  // to center the element
          behavior: 'smooth'
        });
        """
        # attempting to push the execute_script below 1 second will create a false fail during runtime.

        driver.execute_script(scroll_script, element)
        sleep(
            1
        )  # Adjust the delay based on the smoothness desired. A delay ensures the scroll completes.

        logger.info(f"Styling the element with xpath: {xpath}.")

        # Add red background, a border, and a short animation
        style_script = """
        arguments[0].style.backgroundColor = 'red';
        arguments[0].style.borderRadius = '5px';
        arguments[0].style.transition = 'all 0.2s';
        arguments[0].style.transform = 'scale(1.1)';
        """

        # attempting to push the execute_script below 1 second will create a false fail during runtime.
        driver.execute_script(style_script, element)
        sleep(1)

        # Revert the transform scale after the animation duration
        revert_script = "arguments[0].style.transform = 'scale(1.0)';"
        driver.execute_script(revert_script, element)
        sleep(0.1)

    except:
        logger.warning(f"Element with xpath: {xpath} not found.")


def click_element(xpath):
    try:
        logger.info(
            f"Waiting for the clickable element with xpath: {xpath} to be present."
        )
        element = wait.until(EC.element_to_be_clickable((By.XPATH, xpath)))
        element.click()
        logger.info(f"Clicked the element with xpath: {xpath}.")
    except:
        logger.warning(f"Clickable element with xpath: {xpath} not found.")


# Style each element in the config for site1
for key, xpath in config[current_site].items():
    if key != "url":  # "url" is not an action or xpath; skip it
        if "click_" in key:
            click_element(xpath)
        elif "back_" in key:
            driver.back()
            logger.info(f"Performed browser 'back' action.")
        else:
            style_element(xpath)


# Wait and locate h2 element
# h2_selector = config[current_site]["h2"]
# logger.info("Waiting for the h2 element to be present.")
# h2_element = wait.until(EC.presence_of_element_located((By.XPATH, h2_selector)))
# sleep(2)

# Perform actions on h2 element
# logger.info("Changing the background color of the h2 element.")
# driver.execute_script("arguments[0].style.backgroundColor = 'red'", h2_element)
# sleep(2)

# logger.info("Clicking the h2 element.")
# h2_element.click()
# sleep(2)

# Keep browser window open
# logger.info("Keeping the browser window open.")

# while True:
# sleep(1)
