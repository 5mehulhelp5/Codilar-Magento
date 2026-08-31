<?php

namespace Codilar\QwickView\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;

class QuickView extends Template
{
    public function getQuickViewUrl()
    {
        return $this->getUrl('qwickview/product/view');
    }
}
