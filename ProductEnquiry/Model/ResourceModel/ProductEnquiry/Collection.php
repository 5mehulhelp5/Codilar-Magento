<?php

declare(strict_types=1);

namespace Codilar\ProductEnquiry\Model\ResourceModel\ProductEnquiry;

use Codilar\ProductEnquiry\Model\ProductEnquiry as ProductEnquiryModel;
use Codilar\ProductEnquiry\Model\ResourceModel\ProductEnquiry as ProductEnquiryResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct(): void
    {
        $this->_init(
            ProductEnquiryModel::class,
            ProductEnquiryResourceModel::class
        );
    }
}
