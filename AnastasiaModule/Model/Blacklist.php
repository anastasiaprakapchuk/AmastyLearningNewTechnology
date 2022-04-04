<?php

namespace Amasty\AnastasiaModule\Model;

use Magento\Framework\Model\AbstractModel;

class Blacklist extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Amasty\AnastasiaModule\Model\ResourceModel\Blacklist::class);
    }
}
