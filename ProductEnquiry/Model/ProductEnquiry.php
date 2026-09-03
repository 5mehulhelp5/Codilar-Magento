<?php

declare(strict_types=1);

namespace Codilar\ProductEnquiry\Model;

use Codilar\ProductEnquiry\Api\Data\ProductEnquiryInterface;
use Codilar\ProductEnquiry\Model\ResourceModel\ProductEnquiry as ProductEnquiryResourceModel;
use Magento\Framework\Model\AbstractModel;

class ProductEnquiry extends AbstractModel implements ProductEnquiryInterface
{
    protected function _construct(): void
    {
        $this->_init(ProductEnquiryResourceModel::class);
    }

    public function getName(): string
    {
        return (string) $this->getData(ProductEnquiryInterface::NAME);
    }

    public function setName(string $name): ProductEnquiryInterface
    {
        return $this->setData(ProductEnquiryInterface::NAME, $name);
    }

    public function getEmail(): string
    {
        return (string) $this->getData(ProductEnquiryInterface::EMAIL);
    }

    public function setEmail(string $email): ProductEnquiryInterface
    {
        return $this->setData(ProductEnquiryInterface::EMAIL, $email);
    }

    public function getAddress(): string
    {
        return (string) $this->getData(ProductEnquiryInterface::ADDRESS);
    }

    public function setAddress(string $address): ProductEnquiryInterface
    {
        return $this->setData(ProductEnquiryInterface::ADDRESS, $address);
    }

    public function getSku(): string
    {
        return (string) $this->getData(ProductEnquiryInterface::SKU);
    }

    public function setSku(string $sku): ProductEnquiryInterface
    {
        return $this->setData(ProductEnquiryInterface::SKU, $sku);
    }

    public function getQty(): int
    {
        return (int) $this->getData(ProductEnquiryInterface::QTY);
    }

    public function setQty(int $qty): ProductEnquiryInterface
    {
        return $this->setData(ProductEnquiryInterface::QTY, $qty);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(ProductEnquiryInterface::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): ProductEnquiryInterface
    {
        return $this->setData(ProductEnquiryInterface::CREATED_AT, $createdAt);
    }
}
