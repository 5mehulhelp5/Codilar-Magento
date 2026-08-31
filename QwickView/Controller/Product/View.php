<?php

namespace Codilar\QwickView\Controller\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class View extends Action
{
    public function __construct(
        Context $context,
        private ProductRepositoryInterface $productRepository,
        private JsonFactory $resultJsonFactory,
        private Image $imageHelper
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        $productId = (int) $this->getRequest()->getParam('product_id');

        if (!$productId) {
            return $result->setData([
                'success' => false,
                'message' => 'Product ID is missing.'
            ]);
        }

        try {
            $product = $this->productRepository->getById($productId);

            $image = $this->imageHelper
                ->init($product, 'product_base_image')
                ->getUrl();

            return $result->setData([
                'success' => true,
                'product' => [
                    'name' => $product->getName(),
                    'sku' => $product->getSku(),
                    'price' => $product->getFinalPrice(),
                    'description' => $product->getDescription(),
                    'image' => $image,
                    'stock_status' => $product->isAvailable()
                        ? 'In Stock'
                        : 'Out of Stock'
                ]
            ]);
        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'message' => 'Unable to load product.'
            ]);
        }
    }
}
