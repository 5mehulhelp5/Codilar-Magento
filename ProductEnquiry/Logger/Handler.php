<?php

declare(strict_types=1);

namespace Codilar\ProductEnquiry\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    protected $loggerType = Logger::INFO;

    protected $fileName = '/var/log/codilar_product_enquiry.log';
}
