<?php

namespace Amasty\AnastasiaModule\Controller\Adminhtml\Blacklist;

use Magento\Backend\App\Action;

class Create extends Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
