<?php

namespace Amasty\AnastasiaModule\Block;

use Amasty\AnastasiaModule\Model\ConfigProvider;
use Magento\Framework\View\Element\Template;

class Greeting extends Template
{
    /**
     * @var ConfigProvider
     */
    private $scopeConfig;

    public function __construct(
        Template\Context      $context,
        ConfigProvider        $scopeConfig,
        array                 $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function sayGreetingFromConfig()
    {
        return $this->scopeConfig->getGreetingFromConfig();
    }

}
