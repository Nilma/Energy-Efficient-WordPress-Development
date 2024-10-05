## Environment Setup

### 1. Install Python and Pip

Make sure Python 3.x and `pip` (Python's package installer) are installed on your machine. You can verify this by running the following commands:

```bash
python --version
pip --version
```

If you do not have Python installed, you can download it from [python.org](https://www.python.org/downloads/).

### 2. Install Node.js and npm

If you plan to use additional JavaScript testing frameworks (e.g., running frontend tests alongside Selenium), you will also need Node.js. Install Node.js and npm by downloading them from [nodejs.org](https://nodejs.org/).

To verify the installation:

```bash
node -v
npm -v
```

### 3. Install Required Python Libraries

In the project directory, install the required Python dependencies using `pip`. The primary dependency is `selenium`:

```bash
pip install selenium
```

Additionally, this project uses `webdriver_manager` to manage the WebDriver for Chrome:

```bash
pip install webdriver-manager
```

### 4. Install Required npm Packages (Optional)

If your project requires npm packages (e.g., for JavaScript-based testing tools), you can install them with npm.

First, initialize an npm project:

```bash
npm init -y
```

Then install any required npm packages. For example, you might install `mocha` or `chai` for frontend testing:

```bash
npm install mocha chai
```

### 5. Download ChromeDriver

You will need a ChromeDriver to automate Chrome. The `webdriver_manager` package will automatically download and manage the appropriate version for your installed Chrome browser.

However, if you want to download it manually, you can find it here: [ChromeDriver Downloads](https://sites.google.com/a/chromium.org/chromedriver/). Make sure to add the ChromeDriver to your system's PATH.

### 6. Project Structure

```bash
.
├── main.py          # The Python script to automate browsing tasks
├── config.json      # The configuration file with site URLs and element locators
├── README.md        # This documentation file
├── package.json     # npm project configuration (if using npm)
└── node_modules/    # Directory for npm packages (created after npm install)
```

### 7. Configuring the Automation

The configuration for the sites is stored in the `config.json` file. You can modify this file to change the URLs and the specific actions to be performed on each page.

Here is an example of the `config.json` structure:

```json
{
  "site1": {
    "url": "http://192.168.137.102",
    "h1_heading": "//h1[text()='All Blogs']",
    "post_1_link": "//h2/a[text()='Tips for Reducing Your Technology-related Energy Usage']"
  },
  "site2": {
    "url": "http://localhost:8888/wordpress/",
    "h1_heading": "//h1[text()='Mindblown: a blog about philosophy.']",
    "post_1_link": "//h2/a[text()='Tips for Reducing Your Technology-related Energy Usage']"
  }
}
```

### 8. Running the Python Script

Once you have your environment set up and `config.json` is properly configured, you can run the script:

```bash
python main.py
```

This script will:
- Load the configuration from `config.json`
- Automate browser actions using the specified element locators
- Print browser titles and navigate through the specified pages

### 9. Running npm-based Tests (Optional)

If you're using any npm-based tools (like `mocha` for testing), you can run them using the following command:

```bash
npx mocha
```

Make sure to add your test cases in the appropriate location and configure them in `package.json`.

### Notes

- Ensure that the URLs in `config.json` are reachable from your machine.
- If you are using different browsers or specific WebDriver settings, modify the script in `main.py` to suit your needs.
```

---

This updated README now includes the setup for npm in case you are using JavaScript-based testing or utilities alongside your Python Selenium script. Let me know if you need further clarification!
