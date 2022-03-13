<?php

namespace Amasty\AnastasiaModule\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Form extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Template\Context     $context,
        ScopeConfigInterface $scopeConfig,
        array                $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function isEnabledQty()
    {
        return $this->scopeConfig->isSetFlag('anastasia_config/general/enabled_qty');
    }

    public function getDefaultQty()
    {
        return $this->scopeConfig->getValue('anastasia_config/general/qty_default');
    }
}
