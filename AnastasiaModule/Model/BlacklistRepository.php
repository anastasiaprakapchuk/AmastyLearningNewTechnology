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

    public function save($blacklist)
    {
        $this->blacklistResource->save($blacklist);
    }
}
