<?php

declare(strict_types=1);

namespace Shoppy\Magento2HidePrice\Plugin;

use Magento\Catalog\Pricing\Render\FinalPriceBox;
use Shoppy\Magento2HidePrice\Helper\HidePriceHelper;

class HidePricePlugin
{
    public function __construct(private HidePriceHelper $hidePriceHelper) {}

    public function aroundToHtml(
        FinalPriceBox $subject,
        callable $proceed,
    ): string {
        if ($this->hidePriceHelper->shouldHidePrice()) {
            return '<span class="price shoppy-hide-price-msg">' .
                __("Pozovi za cenu") .
                "</span>";
        }

        return $proceed();
    }
}
