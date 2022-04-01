<?php

namespace Amasty\AnastasiaModule\Block;

use Amasty\AnastasiaModule\Model\ConfigProvider;
use Magento\Framework\View\Element\Template;

class Form extends Template
{
    const FORM_ACTION = '*/cart/add';
    /**
     * @var \Amasty\AnastasiaModule\Model\ConfigProvider
     */
    private $scopeConfig;

    public function __construct(
        Template\Context $context,
        ConfigProvider   $scopeConfig,
        array            $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function isEnabledQty()
    {
        return $this->scopeConfig->getIsEnabledQty();
    }

    public function getDefaultQty()
    {
        return $this->scopeConfig->getDefaultQty();
    }

    public function getFormAction(): string
    {
        return self::FORM_ACTION;
    }
}

//class Form extends Template
//{
//    /**
//     * @var ScopeConfigInterface
//     */
//    private $scopeConfig;
//
//    public function __construct(
//        Template\Context     $context,
//        ScopeConfigInterface $scopeConfig,
//        array                $data = []
//    )
//    {
//        $this->scopeConfig = $scopeConfig;
//        parent::__construct($context, $data);
//    }
//
//    public function isEnabledQty()
//    {
//        return $this->scopeConfig->isSetFlag('anastasia_config/general/enabled_qty');
//    }
//
//    public function getDefaultQty()
//    {
//        return $this->scopeConfig->getValue('anastasia_config/general/qty_default');
//    }
//}
