<?php

declare(strict_types=1);

namespace Codilar\ProductEnquiry\Model;

use Codilar\ProductEnquiry\Api\Data\ProductEnquiryInterface;
use Codilar\ProductEnquiry\Api\ProductEnquiryRepositoryInterface;
use Codilar\ProductEnquiry\Model\ResourceModel\ProductEnquiry as ProductEnquiryResourceModel;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductEnquiryRepository implements ProductEnquiryRepositoryInterface
{
    public function __construct(
        private readonly ProductEnquiryResourceModel $resourceModel,
        private readonly ProductEnquiryFactory $productEnquiryFactory
    ) {
    }

    public function save(
        ProductEnquiryInterface $productEnquiry
    ): ProductEnquiryInterface {
        $this->resourceModel->save($productEnquiry);

        return $productEnquiry;
    }

    public function getById(int $entityId): ProductEnquiryInterface
    {
        $productEnquiry = $this->productEnquiryFactory->create();

        $this->resourceModel->load($productEnquiry, $entityId);

        if (!$productEnquiry->getId()) {
            throw new NoSuchEntityException(
                __('Product enquiry with ID "%1" does not exist.', $entityId)
            );
        }

        return $productEnquiry;
    }

    public function delete(
        ProductEnquiryInterface $productEnquiry
    ): bool {
        $this->resourceModel->delete($productEnquiry);

        return true;
    }

    public function deleteById(int $entityId): bool
    {
        return $this->delete($this->getById($entityId));
    }
}
