<?php

declare(strict_types=1);

namespace Shoppy\Magento2HidePrice\Helper;

use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class HidePriceHelper
{
    public function __construct(
        private HttpContext $httpContext,
        private ScopeConfigInterface $scopeConfig,
        private StoreManagerInterface $storeManager,
    ) {}

    public function isEnabled(): bool
    {
        $storeId = (int) $this->storeManager->getStore()->getId();

        return $this->scopeConfig->isSetFlag(
            "shoppy_hideprice/general/enabled",
            ScopeInterface::SCOPE_STORE,
            $storeId,
        );
    }

    public function isLoggedIn(): bool
    {
        return (bool) $this->httpContext->getValue(
            CustomerContext::CONTEXT_AUTH,
        );
    }

    public function isGuestRestricted(): bool
    {
        return $this->isEnabled() && !$this->isLoggedIn();
    }

    public function shouldHidePrice(): bool
    {
        return $this->isGuestRestricted();
    }
}
