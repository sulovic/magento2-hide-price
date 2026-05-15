<?php
declare(strict_types=1);

namespace Shoppy\Magento2HidePrice\Plugin;

use Magento\Checkout\Controller\Cart\Add;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Shoppy\Magento2HidePrice\Helper\HidePriceHelper;

class AddToCartPlugin
{
    public function __construct(
        private HidePriceHelper $hidePriceHelper,
        private ManagerInterface $messageManager,
        private ResultFactory $resultFactory,
        private CustomerSession $customerSession,
    ) {}

    public function aroundExecute(Add $subject, callable $proceed)
    {
        if (
            $this->hidePriceHelper->isEnabled() &&
            !$this->customerSession->isLoggedIn()
        ) {
            $this->messageManager->addErrorMessage(
                __("Morate biti ulogovani da biste kupili."),
            );

            $resultRedirect = $this->resultFactory->create(
                ResultFactory::TYPE_REDIRECT,
            );

            return $resultRedirect->setPath("customer/account/login");
        }

        return $proceed();
    }
}
