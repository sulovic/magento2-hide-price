# Magento 2 Hide Price

Hide product prices for non-logged-in users in Magento 2.

## Features

- Hide all product prices for guests
- Display custom message ("Pozovi za cenu")
- Fully compatible with Full Page Cache (FPC)
- Store view configuration support
- Plugin-based (no core overrides)

## Requirements

- Magento 2.4.8
- PHP 8.3

## Installation

### Option 1: Manual (app/code)

1. Copy module to:

```
app/code/Shoppy/HidePrice
```

2. Run:

```
php bin/magento module:enable Shoppy_HidePrice
php bin/magento setup:upgrade
php bin/magento cache:flush
```

---

### Option 2: Composer (recommended for production)

```
composer require shoppy/magento2-hide-price
php bin/magento module:enable Shoppy_HidePrice
php bin/magento setup:upgrade
php bin/magento cache:flush
```

---

## Configuration

Go to:

```
Stores → Configuration → Hide Price
```

Select store/scope

```

Enable:

```

Yes

```

---

## How It Works

The module uses a plugin on:

```

Magento\Catalog\Pricing\Render\FinalPriceBox::toHtml

```

- Guests → "Pozovi za cenu"
- Logged users → normal price

The module is cache-aware and uses:

```

Magento\Framework\App\Http\Context

```

---

## Use Case

Ideal for:

- B2B store
- Price-on-request catalogs
- Restricted pricing models

---

## Notes

- Does not modify product data
- Only affects frontend rendering
- Safe for Full Page Cache

---

## License

MIT
```
