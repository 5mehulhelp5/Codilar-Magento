# Codilar_ShowPrice

This Magento 2 module contains multiple customizations related to **product price, discount, cart information, product attributes, and customer login logging**.

## 1. Show Discount Percentage on PDP

**What it does:**
Displays the discount percentage on the Product Detail Page by comparing the regular price and final/special price.

Example:

```text
$100  $90  (10% Off)
```

**Files:**

* `Block/Discount.php` → Calculates the discount percentage.
* `view/frontend/templates/discount.phtml` → Displays the discount percentage.
* `view/frontend/layout/catalog_product_view.xml` → Adds the discount block to the PDP.
* `view/frontend/web/css/discount.css` → Styles the price and discount.

---

## 2. Apply 5% Discount for a Specific Category

**What it does:**
Applies a **5% discount** to products that belong to a specific category.

Currently:

```text
Category ID: 5
Discount: 5%
```

**File:**

* `Plugin/ProductPricePlugin.php` → Checks the product category and applies a 5% discount if the category matches.

---

## 3. Show SKU in Cart

**What it does:**
Displays the product **SKU** on the cart page.

Example:

```text
SKU: BAG-001
```

**Files:**

* `Block/Cart/Sku.php` → Gets the product SKU.
* `view/frontend/templates/cart/item/sku.phtml` → Displays the SKU.
* `view/frontend/layout/checkout_cart_index.xml` → Adds the SKU block to the cart item.

---

## 4. Create Product Note Attribute and Show It in Cart

**What it does:**
Creates a custom product attribute called:

```text
Product Note
```

The note can be added to a product and is displayed below the SKU on the cart page.

Example:

```text
SKU: BAG-001
Product Note: New Arrival
```

**Files:**

* `Setup/Patch/Data/AddProductNoteAttribute.php` → Creates the `product_note` attribute.
* `Setup/Patch/Data/AddProductNoteToAllAttributeSets.php` → Adds the attribute to all product attribute sets.
* `Block/Cart/Sku.php` → Gets the Product Note value.
* `view/frontend/templates/cart/item/sku.phtml` → Displays the Product Note below the SKU.

---

## 5. Custom Customer Login Logger

**What it does:**
Logs customer login information whenever a customer logs in.

The following information is logged:

* Customer ID
* Customer Email
* Login Time

Log file:

```text
var/log/customer_login.log
```

**Files:**

* `etc/events.xml` → Observes the `customer_login` event.
* `Observer/CustomerLogin.php` → Gets customer login information and sends it to the logger.
* `Logger/Handler.php` → Defines the custom log file.
* `etc/di.xml` → Configures the custom logger and handler.

---

## Module Concepts Used

This module demonstrates:

```text
Plugin
Observer
Custom Logger
Data Patch
Block & Template
Layout XML
Product Attribute
CSS
```
