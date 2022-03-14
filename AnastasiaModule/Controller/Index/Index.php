<?php
declare(strict_types=1);

namespace Amasty\AnastasiaModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

//use Magento\Framework\App\Config\ScopeConfigInterface;
use Amasty\AnastasiaModule\Helper\ConfigProvider;

class Index extends Action
{
    /**
     * @var ConfigProvider
     */
    private $scopeConfig;

    public function __construct(
        Context        $context,
        ConfigProvider $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->scopeConfig->getIsEnabled()) {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            die('Sorry, module disabled!');
        }
    }
}
