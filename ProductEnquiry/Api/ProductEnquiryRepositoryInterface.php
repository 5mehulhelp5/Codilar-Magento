<?php

declare(strict_types=1);

namespace Codilar\ProductEnquiry\Api;

use Codilar\ProductEnquiry\Api\Data\ProductEnquiryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface ProductEnquiryRepositoryInterface
{
    /**
     * Save product enquiry.
     *
     * @param ProductEnquiryInterface $productEnquiry
     * @return ProductEnquiryInterface
     * @throws LocalizedException
     */
    public function save(
        ProductEnquiryInterface $productEnquiry
    ): ProductEnquiryInterface;

    /**
     * Get product enquiry by ID.
     *
     * @param int $entityId
     * @return ProductEnquiryInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): ProductEnquiryInterface;

    /**
     * Delete product enquiry.
     *
     * @param ProductEnquiryInterface $productEnquiry
     * @return bool
     * @throws LocalizedException
     */
    public function delete(
        ProductEnquiryInterface $productEnquiry
    ): bool;

    /**
     * Delete product enquiry by ID.
     *
     * @param int $entityId
     * @return bool
     * @throws LocalizedException
     */
    public function deleteById(int $entityId): bool;
}
