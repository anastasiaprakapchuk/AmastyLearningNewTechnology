<?php

namespace Amasty\AnastasiaModule\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

abstract class ConfigProviderAbstract
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    protected $pathPrefix = 'anastasia_config/';

    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    protected function getValue($path, $scope = 'store')
    {
        return $this->scopeConfig->getValue($this->pathPrefix . $path, $scope);
    }

    abstract function getIsEnabled();

    abstract function getIsEnabledQty();

    abstract function getDefaultQty();

    abstract function getGreetingFromConfig();

}
