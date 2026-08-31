<?php

namespace Codilar\ShowPrice\Plugin;

use Magento\Catalog\Model\Product;

class ProductPricePlugin
{
    private const TARGET_CATEGORY_ID = 5;
    private const DISCOUNT_PERCENTAGE = 5;

    public function afterGetPrice(Product $subject, $result)
    {
        $categoryIds = $subject->getCategoryIds();

        if (!in_array(self::TARGET_CATEGORY_ID, $categoryIds)) {
            return $result;
        }

        $discount = ($result * self::DISCOUNT_PERCENTAGE) / 100;

        return $result - $discount;
    }
}
