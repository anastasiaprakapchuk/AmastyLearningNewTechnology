<?php

namespace Amasty\AnastasiaModule\Model;


class BlacklistRepository
{
    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;

    /**
     * @var ResourceModel\Blacklist
     */
    private $blacklistResource;

    public function __construct(
        \Amasty\AnastasiaModule\Model\BlacklistFactory        $blacklistFactory,
        \Amasty\AnastasiaModule\Model\ResourceModel\Blacklist $blacklistResource
    )
    {
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
    }

    public function getById(int $id): \Amasty\AnastasiaModule\Model\Blacklist
    {
        $blacklist = $this->blacklistFactory->create();
        $this->blacklistResource->load(
            $blacklist,
            $id
        );

        return $blacklist;
    }

    public function getBySku(int $id)
    {
        $blacklist = $this->getById($id);
        return $blacklist->getData('sku');
    }

    public function getByQty(int $id)
    {
        $blacklist = $this->getById($id);
        return $blacklist->getData('qty');
    }

    public function setEmailBody(int $id, $emailBody)
    {
        $blacklist = $this->getById($id);
        $blacklist->setData('email_body', $emailBody);
        $this->blacklistResource->save($blacklist);
    }
}
