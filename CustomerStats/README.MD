# Codilar_CustomerStats

A Magento 2 module that adds a **My Order Statistics** section to the customer account area.

## Features

The module displays the following information for the logged-in customer:

* Total number of orders
* Total amount spent
* Last order
* Number of completed orders
* Number of cancelled orders

## How It Works

The module adds a **My Order Statistics** link to the customer account navigation.

When the customer clicks the link:

1. Magento routes the request to the Statistics Controller.
2. The Controller loads the statistics page.
3. The `OrderStatistics` Block gets the logged-in customer's ID.
4. The Block loads the customer's orders.
5. The required statistics are calculated from the order collection.
6. The PHTML template displays the results.

## Module Structure

```text
Codilar/CustomerStats/
├── Block/
│   └── Customer/
│       └── OrderStatistics.php
├── Controller/
│   └── Order/
│       └── Statistics.php
├── view/
│   └── frontend/
│       ├── layout/
│       │   ├── customer_account.xml
│       │   └── customerstats_order_statistics.xml
│       ├── templates/
│       │   └── customer/
│       │       └── order_statistics.phtml
│       └── web/
│           └── css/
│               └── customer-stats.css
├── etc/
│   └── frontend/
│       └── routes.xml
└── registration.php
```

## Main Components

### Controller

**File:** `Controller/Order/Statistics.php`

Handles the customer statistics URL:

```text
/customerstats/order/statistics/
```

and returns the statistics page.

### Block

**File:** `Block/Customer/OrderStatistics.php`

Responsible for:

* Getting the logged-in customer ID
* Loading the customer's orders
* Calculating total orders
* Calculating total amount spent
* Getting the last order
* Counting completed orders
* Counting cancelled orders

### Layout

**File:** `view/frontend/layout/customer_account.xml`

Adds the **My Order Statistics** link to the customer account navigation.

**File:** `view/frontend/layout/customerstats_order_statistics.xml`

Defines the layout and Block used on the statistics page.

### Template

**File:** `view/frontend/templates/customer/order_statistics.phtml`

Displays the calculated customer order statistics.

### CSS

**File:** `view/frontend/web/css/customer-stats.css`

Provides styling for the order statistics section.

## Route

```text
Front Name : customerstats
Controller : order
Action     : statistics
```

**URL:**

```text
/customerstats/order/statistics/
```

## Technologies

* Magento 2.4.9
* PHP
* XML Layout
* PHTML
* CSS
* Magento Customer Session
* Magento Sales Order Collection

