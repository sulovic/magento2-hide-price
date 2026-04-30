# Magento 2 Hide Price Module – Development Instructions

## Overview

This is a Magento 2.4.8 module (PHP 8.3 compatible) that conditionally hides product prices for non-authenticated users.

## Key Features

- Hide prices for guest users
- Display custom message ("Pozovi za cenu")
- Fully cache-aware using HttpContext
- Store-scope configuration support
- Plugin-based (non-invasive, no core overrides)

## Architecture

- Uses Magento Plugin (Interceptor pattern)
- Targets: Magento\Catalog\Pricing\Render\FinalPriceBox::toHtml
- Configuration path: shoppy_hideprice/general/enabled

## Important Constraints

- MUST remain compatible with Full Page Cache (FPC)
- DO NOT use CustomerSession for auth checks
- ALWAYS use HttpContext (Magento\Framework\App\Http\Context)
- Avoid preferences (use plugins instead)

## Coding Guidelines

- Follow PSR-12
- Use strict typing where possible
- Keep logic minimal inside plugins
- No business logic in templates

## Magento Compatibility

- Magento 2.4.8
- PHP 8.3
- Compatible with Luma and most custom themes

## Future Improvements

- Hide "Add to Cart" for guests
- Custom message configurable from admin
- Support for category, search, and minicart rendering
- GraphQL / PWA support

## Testing Scenarios

- Guest user → price hidden
- Logged user → price visible
- Cache enabled → behavior correct
- Multiple store views → config isolation

## Do NOT

- Break price rendering pipeline
- Disable cache globally
- Use ObjectManager directly

## Notes

This module is designed for B2B use cases.
