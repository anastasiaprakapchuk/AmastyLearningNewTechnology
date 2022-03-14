<?php

namespace Amasty\AnastasiaModule\Helper;

class ConfigProvider extends ConfigProviderAbstract
{
    const GENERAL_ENABLED = 'general/enabled';
    const GENERAL_ENABLED_QTY = 'general/enabled_qty';
    const GENERAL_QTY_DEFAULT = 'general/qty_default';
    const GENERAL_GREETING_TEXT = 'general/greeting_text';

    public function getIsEnabled()
    {
        return $this->getValue(self::GENERAL_ENABLED);
    }

    public function getIsEnabledQty()
    {
        return $this->getValue(self::GENERAL_ENABLED_QTY);
    }

    public function getDefaultQty()
    {
        return $this->getValue(self::GENERAL_QTY_DEFAULT);
    }

    public function getGreetingFromConfig()
    {
        return $this->getValue(self::GENERAL_GREETING_TEXT);
    }

}
