<?php

namespace Amasty\AnastasiaModule\Controller\Adminhtml\Blacklist;

use Magento\Backend\App\Action;

class Save extends Action
{
    /**
     * @var \Amasty\AnastasiaModule\Model\Blacklist
     */
    private $blacklistFactory;
    /**
     * @var \Amasty\AnastasiaModule\Model\ResourceModel\Blacklist
     */
    private $blacklistResource;

    public function __construct(
        Action\Context                                        $context,
        \Amasty\AnastasiaModule\Model\BlacklistFactory        $blacklistFactory,
        \Amasty\AnastasiaModule\Model\ResourceModel\Blacklist $blacklistResource
    )
    {
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($data = $this->getRequest()->getParams()) {
            $blacklistId = $this->getRequest()->getParam('blacklist_id');
            try {
                $blacklist = $this->blacklistFactory->create();
                if ($blacklistId) {
                    $this->blacklistResource->load($blacklist, $blacklistId);
                }
                $blacklist->addData($data);
                $this->blacklistResource->save($blacklist);
                $this->messageManager->addSuccessMessage(__('Blacklist saved.'));
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage($exception, $exception->getMessage());
            }
        }
        return $this->_redirect('*/*/index');
    }
}
