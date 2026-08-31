<?php

namespace Codilar\ShowPrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class CustomerLogin implements ObserverInterface
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();

        $customerId = $customer->getId();
        $customerEmail = $customer->getEmail();
        $loginTime = date('Y-m-d H:i:s');

        $this->logger->info(
            'Customer Login - ID: ' . $customerId .
            ', Email: ' . $customerEmail .
            ', Login Time: ' . $loginTime
        );
    }
}
