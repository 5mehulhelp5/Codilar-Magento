<?php

declare(strict_types=1);

namespace Codilar\CustomerStats\Controller\Order;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Statistics implements ActionInterface
{
    public function __construct(
        private readonly ResultFactory $resultFactory
    ) {
    }

    public function execute(): ResultInterface
    {
        return $this->resultFactory->create(
            ResultFactory::TYPE_PAGE
        );
    }
}
