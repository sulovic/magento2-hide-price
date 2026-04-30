<?php

declare(strict_types=1);

namespace Shoppy\HidePrice\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class SaleablePlugin
{
    private HttpContext $httpContext;
    private ScopeConfigInterface $scopeConfig;
    private StoreManagerInterface $storeManager;

    public function __construct(
        HttpContext $httpContext,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->httpContext = $httpContext;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

   public function afterIsSaleable(Product $subject, bool $result): bool
    {
        if (!$result) {
            return false;
        }

        if (!$this->isEnabled($subject->getStoreId())) {
            return $result;
        }

        if (!$this->isLoggedIn()) {
            return false;
        }

        return true;
    }

    private function isLoggedIn(): bool
    {
        return (bool) $this->httpContext->getValue(CustomerContext::CONTEXT_AUTH);
    }

    private function isEnabled(?int $storeId = null): bool
    {
        if ($storeId === null || $storeId === 0) {
            $storeId = (int) $this->storeManager->getStore()->getId();
        }

        return $this->scopeConfig->isSetFlag(
            'shoppy_hideprice/general/enabled',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
