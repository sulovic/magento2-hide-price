<?php

namespace Shoppy\HidePrice\Plugin;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class HidePricePlugin
{
    private $customerSession;
    private $scopeConfig;

    public function __construct(
        Session $customerSession,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
    }

    public function aroundToHtml($subject, callable $proceed)
    {
        // proveri da li je modul uključen za trenutni store
        $enabled = $this->scopeConfig->isSetFlag(
            'shoppy_hideprice/general/enabled',
            ScopeInterface::SCOPE_STORE
        );

        if (!$enabled) {
            return $proceed();
        }

        // ako je user ulogovan → normalna cena
        if ($this->customerSession->isLoggedIn()) {
            return $proceed();
        }

        // guest → custom tekst
        return '<span class="hide-price-msg">Pozovi za cenu</span>';
    }
}
