<?php

namespace Amasty\AnastasiaModule\Plugin;

use \Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;

class ChangeRequest
{
    /**
     * @var Http
     */
    protected $_request;

    public function __construct(
        Http $request
    )
    {
        $this->_request = $request;
    }

    public function aroundExecute(
        \Amasty\SecondAnastasiaModule\Observer\CheckAddProductObserver $subject,
        callable                                                       $proceed,
        Observer                                                       $observer
    )
    {
        if ($this->_request->isAjax()) {
            return $proceed($observer);
        }
    }
}
