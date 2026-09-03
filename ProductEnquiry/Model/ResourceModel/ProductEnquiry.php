<?php

declare(strict_types=1);

namespace Codilar\ProductEnquiry\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductEnquiry extends AbstractDb
{
    private const MAIN_TABLE = 'codilar_product_enquiry';
    private const ID_FIELD_NAME = 'entity_id';

    protected function _construct(): void
    {
        $this->_init(
            self::MAIN_TABLE,
            self::ID_FIELD_NAME
        );
    }
}
