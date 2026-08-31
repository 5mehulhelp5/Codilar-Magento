<?php

namespace Codilar\Helloworld\Block;

use Magento\Framework\View\Element\Template;

class Hello extends Template{
    public function getMessage(){
        return "Hello World from Block";
    }
}
