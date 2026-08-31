<?php

namespace Codilar\ShowPrice\Block\Cart;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductRepository;

class Sku extends Template
{
    private ProductRepository $productRepository;

    public function __construct(
        Template\Context $context,
        ProductRepository $productRepository,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function getProductSku(): string
    {
        $item = $this->getItem();

        if (!$item) {
            return '';
        }

        $product = $item->getProduct();

        return $product ? (string) $product->getSku() : '';
    }

    public function getProductNote(): string
    {
        $item = $this->getItem();

        if (!$item) {
            return '';
        }

        $product = $item->getProduct();

        if (!$product || !$product->getId()) {
            return '';
        }

        try {
            $product = $this->productRepository->getById(
                (int) $product->getId()
            );

            return (string) $product->getData('product_note');
        } catch (\Exception $e) {
            return '';
        }
    }
}
