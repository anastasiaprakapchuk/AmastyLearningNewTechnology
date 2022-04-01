<?php

namespace Amasty\SecondAnastasiaModule\Controller\Index;

use Amasty\AnastasiaModule\Controller\Index\Index as AnastasiaIndex;

class Index extends AnastasiaIndex
{
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');

        if ($customerSession->isLoggedIn()) {
            return parent::execute();
        } else {
            die('Sorry, module disabled! Log in!');
        }
    }
}
