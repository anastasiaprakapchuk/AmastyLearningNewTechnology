<?php

namespace Amasty\AnastasiaModule\Model\ResourceModel\Blacklist;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Amasty\AnastasiaModule\Model\Blacklist::class,
            \Amasty\AnastasiaModule\Model\ResourceModel\Blacklist::class
        );
    }
}
