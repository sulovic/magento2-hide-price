<?php

declare(strict_types=1);

namespace Shoppy\HidePrice\Plugin;

use Magento\Checkout\Controller\Cart\Add;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;

class AddToCartPlugin
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

    public function aroundExecute(Add $subject, callable $proceed)
    {
        $enabled = $this->scopeConfig->isSetFlag(
            "shoppy_hideprice/general/enabled",
            ScopeInterface::SCOPE_STORE,
        );

        if (!$enabled) {
            return $proceed();
        }

        if (!$this->isLoggedIn()) {
            throw new LocalizedException(
                __("Morate biti ulogovani da biste kupili."),
            );
        }

        return $proceed();
    }

    private function isLoggedIn(): bool
    {
        return (bool) $this->httpContext->getValue(
            CustomerContext::CONTEXT_AUTH,
        );
    }
}
