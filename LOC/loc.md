# LOC Calculation for WordPress Setup

This README outlines the method used to calculate the lines of code (LOC) in two different WordPress setups, along with comparisons between the custom themes and plugins used.

## WordPress Setup 1: Custom Theme & Plugin

### Overview
In the first WordPress setup, I deleted all the default themes and plugins. I then added:
- A custom theme created from scratch.
- A custom image compression plugin created from scratch.

### Steps:
1. **Delete default themes and plugins**:
   - Removed all default themes (e.g., Twenty Twenty-Three) and plugins.
2. **Add custom theme and plugin**:
   - Installed a custom theme designed from scratch.
   - Installed a custom image compressor plugin created from scratch.
3. **LOC Measurement**:
   - Measured the total LOC of this WordPress setup, including the custom theme and plugin.

---

## WordPress Setup 2: Default Theme & Smush Plugin

### Overview
In the second WordPress setup, I retained the default `Twenty Twenty-Three` theme and used the `Smush` plugin for image compression.

### Steps:
1. **Retain default theme**:
   - Kept the default `Twenty Twenty-Three` theme.
2. **Add Smush plugin**:
   - Installed the `Smush` image compression plugin.
3. **LOC Measurement**:
   - Measured the total LOC of this WordPress setup, including the `Twenty Twenty-Three` theme and `Smush` plugin.

---

## Additional Measurements

### Plugins Comparison
For both setups, I measured the LOC of the image compression plugins separately to compare them:
- **Custom Image Compressor Plugin**: LOC measured independently.
- **Smush Plugin**: LOC measured independently.

### Themes Comparison
I also measured the LOC of the two themes separately:
- **Custom Theme**: LOC measured independently.
- **Twenty Twenty-Three Theme**: LOC measured independently.

---

## LOC Calculation Method

To calculate the lines of code for each WordPress setup, the following method was used:

```bash
find . -name '*.php' -o -name '*.css' -o -name '*.js' -o -name '*.html' | xargs wc -l