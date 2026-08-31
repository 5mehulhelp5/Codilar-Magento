# Codilar_Helloworld

A simple Magento 2 module created to understand how **Routes, Controllers, Blocks, Layout XML, and Templates** work together.

## What does it do?

This module creates custom frontend pages and displays **Hello World** messages.

It demonstrates:

* Custom frontend route
* Controller
* Block
* Layout XML
* `.phtml` template

## Module Structure

```text
Codilar/Helloworld/
├── Block/
│   └── Hello.php
├── Controller/
│   └── Page/
│       ├── Helloworld.php
│       ├── Index.php
│       └── Test.php
├── etc/
│   ├── frontend/routes.xml
│   └── module.xml
├── view/frontend/
│   ├── layout/
│   │   └── test_page_index.xml
│   └── templates/
│       └── hello.phtml
└── registration.php
```

## URL

The module uses:

```text
test
```

as the frontend route.

### Main Page

```text
/test/page/index
```

This page uses:

```text
Controller → Layout → Block → Template
```

and displays:

```text
Hello World from Block
```

### Other Pages

```text
/test/page/helloworld
```

Displays:

```text
Hello World Page
```

And:

```text
/test/page/test
```

Displays:

```text
Hello World Test Page
```

## How It Works

For `/test/page/index`:

```text
URL
 ↓
routes.xml
 ↓
Controller/Page/Index.php
 ↓
test_page_index.xml
 ↓
Block/Hello.php
 ↓
hello.phtml
 ↓
Hello World from Block
```

## Installation

Place the module inside:

```text
app/code/Codilar/Helloworld
```

Then run:

```bash
php bin/magento module:enable Codilar_Helloworld
php bin/magento setup:upgrade
php bin/magento cache:flush
```

If required:

```bash
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```


