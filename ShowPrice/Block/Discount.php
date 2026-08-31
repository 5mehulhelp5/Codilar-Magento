<?php

declare(strict_types=1);

namespace Codilar\ShowPrice\Block;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Discount extends Template
{
    public function __construct(
        Context $context,
        private ProductRepositoryInterface $productRepository,
        private RequestInterface $request,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get current product
     */
    public function getProduct(): ?Product
    {
        $productId = (int) $this->request->getParam('id');

        if ($productId <= 0) {
            return null;
        }

        try {
            return $this->productRepository->getById($productId);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get regular price
     */
    public function getRegularPrice(): float
    {
        $product = $this->getProduct();

        if (!$product) {
            return 0.0;
        }

        return (float) $product
            ->getPriceInfo()
            ->getPrice('regular_price')
            ->getValue();
    }

    /**
     * Get final/selling price
     */
    public function getSpecialPrice(): float
    {
        $product = $this->getProduct();

        if (!$product) {
            return 0.0;
        }

        return (float) $product
            ->getPriceInfo()
            ->getPrice('final_price')
            ->getValue();
    }

    /**
     * Calculate discount percentage
     */
    public function getDiscountPercentage(): int
    {
        $regularPrice = $this->getRegularPrice();
        $specialPrice = $this->getSpecialPrice();

        if (
            $regularPrice <= 0 ||
            $specialPrice <= 0 ||
            $specialPrice >= $regularPrice
        ) {
            return 0;
        }

        return (int) round(
            (($regularPrice - $specialPrice) / $regularPrice) * 100
        );
    }
}
