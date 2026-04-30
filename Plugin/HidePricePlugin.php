<?php

declare(strict_types=1);

namespace Shoppy\HidePrice\Plugin;

use Magento\Catalog\Pricing\Render\FinalPriceBox;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Store\Model\ScopeInterface;

class HidePricePlugin
{
    private HttpContext $httpContext;
    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        HttpContext $httpContext,
        ScopeConfigInterface $scopeConfig,
    ) {
        $this->httpContext = $httpContext;
        $this->scopeConfig = $scopeConfig;
    }

    public function aroundToHtml(
        FinalPriceBox $subject,
        callable $proceed,
    ): string {
        if (!$this->isEnabled((int) $subject->getStore()->getId())) {
            return $proceed();
        }

        if ($this->isLoggedIn()) {
            return $proceed();
        }

        return '<span class="shoppy-hide-price-msg">Pozovi za cenu</span>';
    }

    private function isLoggedIn(): bool
    {
        return (bool) $this->httpContext->getValue(
            CustomerContext::CONTEXT_AUTH,
        );
    }

    private function isEnabled(int $storeId): bool
    {
        return $this->scopeConfig->isSetFlag(
            "shoppy_hideprice/general/enabled",
            ScopeInterface::SCOPE_STORE,
            $storeId,
        );
    }
}
