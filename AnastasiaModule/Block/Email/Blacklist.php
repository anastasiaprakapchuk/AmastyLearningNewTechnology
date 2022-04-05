<?php

namespace Amasty\AnastasiaModule\Block\Email;

use Magento\Framework\View\Element\Template;

class Blacklist extends Template
{
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function getBlacklist()
    {
        return $this->getData('blacklist');
    }
}

