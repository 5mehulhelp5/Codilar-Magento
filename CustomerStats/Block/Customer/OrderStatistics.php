<?php

namespace Codilar\CustomerStats\Block\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class OrderStatistics extends Template
{
    private ?int $cachedCustomerId = null;
    private $cachedCustomerOrders = null;

    public function __construct(
        Template\Context $context,
        private Session $customerSession,
        private CustomerRepositoryInterface $customerRepository,
        private CollectionFactory $orderCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
    }

    public function getCustomerId(): int
    {
        if ($this->cachedCustomerId !== null) {
            return $this->cachedCustomerId;
        }

        if (!$this->customerSession->isLoggedIn()) {
            $this->cachedCustomerId = 0;
            return 0;
        }

        $this->cachedCustomerId = (int) $this->customerSession->getCustomerId();
        return $this->cachedCustomerId;
    }

    public function getCustomer()
    {
        $customerId = $this->getCustomerId();
        if (!$customerId) {
            return null;
        }

        try {
            return $this->customerRepository->getById($customerId);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getCustomerOrders()
    {
        if ($this->cachedCustomerOrders !== null) {
            return $this->cachedCustomerOrders;
        }

        $collection = $this->orderCollectionFactory->create();
        $customer = $this->getCustomer();

        if (!$customer) {
            $collection->addFieldToFilter('customer_id', 0);
            $this->cachedCustomerOrders = $collection;
            return $this->cachedCustomerOrders;
        }

        $collection->addFieldToFilter('customer_id', $customer->getId());
        $this->cachedCustomerOrders = $collection;

        return $this->cachedCustomerOrders;
    }

    public function getTotalOrders(): int
    {
        return (int) $this->getCustomerOrders()->getSize();
    }

    public function getTotalSpent(): float
    {
        $totalSpent = 0;

        foreach ($this->getCustomerOrders() as $order) {
            $totalSpent += (float) $order->getGrandTotal();
        }

        return $totalSpent;
    }

    public function getLastOrder()
    {
        $collection = clone $this->getCustomerOrders();
        return $collection
            ->setOrder('created_at', 'DESC')
            ->setPageSize(1)
            ->getFirstItem();
    }

    public function getCompletedOrders(): int
    {
        $collection = clone $this->getCustomerOrders();
        return (int) $collection
            ->addFieldToFilter('state', \Magento\Sales\Model\Order::STATE_COMPLETE)
            ->getSize();
    }

    public function getCancelledOrders(): int
    {
        $collection = clone $this->getCustomerOrders();
        return (int) $collection
            ->addFieldToFilter('state', \Magento\Sales\Model\Order::STATE_CANCELED)
            ->getSize();
    }
}
