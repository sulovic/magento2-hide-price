<?php

declare(strict_types=1);

namespace Shoppy\Magento2HidePrice\Plugin;

use Magento\Catalog\Block\Product\View\AddToCart;
use Shoppy\Magento2HidePrice\Helper\HidePriceHelper;

class HideAddToCartPlugin
{
    private HidePriceHelper $hidePriceHelper;

    public function __construct(HidePriceHelper $hidePriceHelper)
    {
        $this->hidePriceHelper = $hidePriceHelper;
    }

    public function aroundToHtml(AddToCart $subject, callable $proceed): string
    {
        if ($this->hidePriceHelper->shouldHideAddToCart()) {
            return "";
        }

        return $proceed();
    }
}
