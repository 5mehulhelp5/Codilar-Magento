<?php

namespace Codilar\ShowPrice\Logger;

use Magento\Framework\Logger\Handler\Base;

class Handler extends Base
{
    protected $fileName = '/var/log/customer_login.log';

    protected $loggerType = \Monolog\Logger::INFO;
}
