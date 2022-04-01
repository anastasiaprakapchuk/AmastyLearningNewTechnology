<?php

namespace Amasty\AnastasiaModule\Plugin;

use Magento\Framework\App\Request\Http;

class ChangeRequest
{
    /**
     * @var Http
     */
    protected $request;

    public function __construct(
        Http $request
    )
    {
        $this->request = $request;
    }

    public function aroundExecute(
        \Amasty\SecondAnastasiaModule\Observer\CheckAddProductObserver $subject,
        callable                                                       $proceed,
        $observer
    )
    {
        return die(($observer->getData('request'))->isAjax());
        if ($observer->getData('request')->isAjax()) {
            $proceed($observer);
        }
    }
}
