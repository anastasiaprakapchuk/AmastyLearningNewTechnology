<?php

namespace Amasty\SecondAnastasiaModule\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    protected $pathPrefix = 'second_anastasia_config/';

    const GENERAL_PROMO_SKU = 'general/promo_sku';
    const GENERAL_FOR_SKU = 'general/for_sku';

    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getValue($path)
    {
        return $this->scopeConfig->getValue($this->pathPrefix . $path);
    }

    public function getForSKU(): string
    {
        return $this->getValue(self::GENERAL_FOR_SKU);
    }

    public function getPromoSKU(): string
    {
        return $this->getValue(self::GENERAL_PROMO_SKU);
    }
}
