# Codilar_QwickView

A Magento 2 module that adds a **Quick View** feature to product listing pages. Customers can view basic product information in a popup without opening the product detail page.

## 1. Add Quick View Button

**What it does:**
Adds a **Quick View** button beside the Add to Cart button on product listing items.

The button gets the product ID and uses it to load the product information.

**Files:**

* `view/frontend/web/js/quickview.js` → Finds product items and dynamically adds the Quick View button.
* `view/frontend/layout/default.xml` → Loads the Quick View block and CSS on frontend pages.

---

## 2. Create Quick View Popup

**What it does:**
Creates a popup where the product information is displayed.

The popup shows:

* Product Image
* Product Name
* Price
* SKU
* Stock Status
* Description

**Files:**

* `view/frontend/templates/product/quickview.phtml` → Contains the popup HTML structure.
* `view/frontend/web/js/quickview.js` → Opens and controls the Magento modal popup.
* `view/frontend/web/css/quickview.css` → Styles the popup and makes it responsive.

---

## 3. Load Product Data Using AJAX

**What it does:**
When the customer clicks Quick View, JavaScript sends an AJAX request with the product ID.

The controller loads the product and returns the product information as JSON.

**Files:**

* `view/frontend/web/js/quickview.js` → Sends the AJAX request and displays the response.
* `Controller/Product/View.php` → Loads the product and returns product data as JSON.
* `Block/Product/QuickView.php` → Provides the Quick View AJAX URL to JavaScript.
* `etc/frontend/routes.xml` → Defines the `qwickview` frontend route.

### AJAX Flow

```text
Quick View Button
        ↓
JavaScript
        ↓
AJAX Request
        ↓
Controller/Product/View.php
        ↓
Load Product
        ↓
JSON Response
        ↓
Display Data in Popup
```

---

## 4. Display Product Information

**What it does:**
The controller returns the following product information:

```text
Name
SKU
Final Price
Description
Product Image
Stock Status
```

The JavaScript receives this data and updates the popup dynamically.

**Files:**

* `Controller/Product/View.php` → Provides product data.
* `view/frontend/web/js/quickview.js` → Inserts the data into the popup.
* `view/frontend/templates/product/quickview.phtml` → Provides the HTML elements for displaying the data.

---

## 5. Responsive Quick View

**What it does:**
The Quick View popup is responsive.

On desktop, the product image and details are displayed side by side. On smaller screens, they are displayed vertically.

**File:**

* `view/frontend/web/css/quickview.css` → Contains the responsive CSS.

---

## Module Configuration

**Files:**

* `etc/module.xml` → Defines the `Codilar_QwickView` module.
* `registration.php` → Registers the module with Magento.

## Installation

Place the module in:

```text
app/code/Codilar/QwickView
```

Then run:

```bash
php bin/magento module:enable Codilar_QwickView
php bin/magento setup:upgrade
php bin/magento cache:flush
```

If required:

```bash
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```
