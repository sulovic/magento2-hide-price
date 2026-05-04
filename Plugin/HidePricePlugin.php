<?php

declare(strict_types=1);

namespace Shoppy\Magento2HidePrice\Plugin;

use Magento\Catalog\Pricing\Render\FinalPriceBox;
use Shoppy\Magento2HidePrice\Helper\HidePriceHelper;

class HidePricePlugin
{
    private HidePriceHelper $hidePriceHelper;

    public function __construct(HidePriceHelper $hidePriceHelper)
    {
        $this->hidePriceHelper = $hidePriceHelper;
    }

    public function aroundToHtml(
        FinalPriceBox $subject,
        callable $proceed,
    ): string {
        if ($this->hidePriceHelper->shouldHidePrice()) {
            return '<span class="shoppy-hide-price-msg">Pozovi za cenu</span>';
        }

        return $proceed();
    }
}
