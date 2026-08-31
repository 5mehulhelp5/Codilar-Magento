# Codilar_SameCategorySlider

A Magento 2 module that displays **other products from the same category** as a product slider on the Product Detail Page (PDP).

The module identifies the current product's deepest category and displays other products belonging to that category.

## 1. Show Same Category Products on PDP

**What it does:**
When a customer opens a product page, the module finds the category associated with the current product and displays other products from that category.

The current product is excluded from the result.

It only displays products that are:

* Enabled
* Visible in catalog/search
* From the same deepest category

A maximum of **8 products** are displayed.

**Files:**

* `Block/Widget/SameCategoryProducts.php` → Gets the current product, finds its deepest category, and loads the matching products.
* `view/frontend/templates/widget/same-category-products.phtml` → Displays the product image, name, price, and navigation buttons.
* `view/frontend/layout/catalog_product_view.xml` → Adds the slider container to the product page.

---

## 2. Find the Deepest Product Category

**What it does:**
A product can belong to multiple categories. The module checks all categories assigned to the current product and selects the category with the highest category level.

For example:

```text
Default Category
    ↓
Bags
    ↓
Leather Bags
```

If the product belongs to all three, **Leather Bags** is selected as the deepest category.

**File:**

* `Block/Widget/SameCategoryProducts.php` → `getCurrentCategoryId()` finds the deepest category.

---

## 3. Load Related Products

**What it does:**
After finding the deepest category, the module creates a product collection and filters it to show suitable products.

The collection:

* Selects required product attributes
* Filters by the selected category
* Excludes the current product
* Includes only enabled products
* Includes only visible products
* Limits the result to 8 products

**File:**

* `Block/Widget/SameCategoryProducts.php` → `getProducts()` handles the product collection and filtering.

---

## 4. Display Product Information

**What it does:**
Each product in the slider displays:

* Product image
* Product name
* Product price
* Product URL

The product image is generated using Magento's image helper.

**Files:**

* `view/frontend/templates/widget/same-category-products.phtml` → Displays the product information.
* `Block/Widget/SameCategoryProducts.php` → Provides the product image URL.

---

## 5. Create Same Category Products Widget

**What it does:**
The module registers a custom Magento widget named:

```text
Same Category Products Slider
```

This makes the functionality available as a Magento widget.

**File:**

* `etc/widget.xml` → Registers the custom widget and connects it with the `SameCategoryProducts` block.

---

## 6. Add Product Slider

**What it does:**
The products are displayed using a **Swiper slider** with Previous and Next navigation buttons.

The slider shows:

```text
Desktop  → 4 products
Tablet   → 3 products
Mobile   → 2 / 1 products
```

**Files:**

* `view/frontend/web/js/same-category-slider.js` → Initializes and configures the Swiper slider.
* `view/frontend/web/css/same-category-slider.css` → Handles the slider design and responsive layout.

---

## 7. Module Configuration

**Files:**

* `etc/module.xml` → Defines the module and its dependencies on `Magento_Catalog` and `Magento_Widget`.
* `registration.php` → Registers the `Codilar_SameCategorySlider` module with Magento.

## Module Flow

```text
Product Detail Page
        ↓
Get Current Product
        ↓
Find Product Categories
        ↓
Find Deepest Category
        ↓
Load Other Products
        ↓
Exclude Current Product
        ↓
Display Products
        ↓
Initialize Swiper Slider
```

## Installation

Place the module in:

```text
app/code/Codilar/SameCategorySlider
```

Then run:

```bash
php bin/magento module:enable Codilar_SameCategorySlider
php bin/magento setup:upgrade
php bin/magento cache:flush
```

If required:

```bash
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```
