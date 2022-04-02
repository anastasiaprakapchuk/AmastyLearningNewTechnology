<?php

namespace Amasty\SecondAnastasiaModule\Plugin;

class ChangeFormAction
{
    const FORM_NEW_ACTION = 'checkout/cart/add';

    public function aroundGetFormAction(
        \Amasty\AnastasiaModule\Block\Form $subject,
        callable                           $proceed
    ): string
    {
        return self::FORM_NEW_ACTION;
    }
}
