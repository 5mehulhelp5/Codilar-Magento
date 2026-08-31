# Codilar_BuyNow

Magento 2 module that adds a **Buy Now** button to the product detail page.

## What does it do?

When the customer clicks **Buy Now**:

```text
Product Page
    ↓
Validate Product Form
    ↓
Add Product to Cart
    ↓
Redirect to Checkout
```

It uses the existing Magento product form, so product quantity, configurable options, custom options, etc. are submitted normally.

## Module Structure

```text
Codilar/BuyNow/
├── Block/
│   └── Product/BuyNow.php
├── Controller/
│   └── Index/Buy.php
├── etc/
│   ├── frontend/routes.xml
│   └── module.xml
├── view/frontend/
│   ├── layout/catalog_product_view.xml
│   ├── templates/product/buy-now.phtml
│   └── web/js/buy-now.js
└── registration.php
```

## Main Files

* `catalog_product_view.xml` → Adds the Buy Now button to the product page.
* `buy-now.phtml` → Displays the Buy Now button.
* `buy-now.js` → Validates and submits the product form.
* `routes.xml` → Creates the `buynow` route.
* `Buy.php` → Adds the product to cart and redirects to checkout.
* `BuyNow.php` → Provides product information to the template.

## Installation

Place the module inside:

```text
app/code/Codilar/BuyNow
```

Then run:

```bash
php bin/magento module:enable Codilar_BuyNow
php bin/magento setup:upgrade
php bin/magento cache:flush
```

If required:

```bash
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```

## Usage

Open any product detail page and click **Buy Now**.

The product will be added to the cart and the customer will be redirected directly to the checkout page.


