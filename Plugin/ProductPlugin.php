<?php

declare(strict_types=1);

namespace Shoppy\Magento2HidePrice\Plugin;

use Magento\Catalog\Model\Product;
use Shoppy\Magento2HidePrice\Helper\HidePriceHelper;

class ProductPlugin
{
    public function __construct(private HidePriceHelper $hidePriceHelper) {}

    public function afterIsSaleable(Product $subject, bool $result): bool
    {
        if ($this->hidePriceHelper->shouldHideAddToCart()) {
            return false;
        }

        return $result;
    }
}
