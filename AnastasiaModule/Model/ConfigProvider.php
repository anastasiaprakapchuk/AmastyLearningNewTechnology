<?php

namespace Amasty\AnastasiaModule\Model;

class ConfigProvider extends ConfigProviderAbstract
{
    const GENERAL_ENABLED = 'general/enabled';
    const GENERAL_ENABLED_QTY = 'general/enabled_qty';
    const GENERAL_QTY_DEFAULT = 'general/qty_default';
    const GENERAL_GREETING_TEXT = 'general/greeting_text';

    const EMAIL_SEND_TO = 'email/send_email';
    const EMAIL_TEMPLATE = 'blacklist_template';

    const EMAIL_SEND_FROM = 'trans_email/ident_custom1/email';
    const NAME_SEND_FROM = 'trans_email/ident_custom1/name';


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

    public function getSendEmailToFromConfig()
    {
        return $this->getValue(self::EMAIL_SEND_TO);
    }

    public function getEmailTemplateFromConfig()
    {
        return $this->getValue(self::EMAIL_TEMPLATE);
    }

    public function getEmailSendFrom()
    {
        return $this->scopeConfig->getValue(self::EMAIL_SEND_FROM);
    }

    public function getNameSendFrom()
    {
        return $this->scopeConfig->getValue(self::NAME_SEND_FROM);
    }

}
