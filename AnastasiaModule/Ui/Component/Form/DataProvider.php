<?php

namespace Amasty\AnastasiaModule\Ui\Component\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Amasty\AnastasiaModule\Model\ResourceModel\Blacklist\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected $loadedData;

    /**
     * @var \Amasty\AnastasiaModule\Model\ResourceModel\Blacklist\Collection
     */
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [])
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (!isset($this->loadedData)) {
            $blacklist = $this->collection->getItems();
            foreach ($blacklist as $blacklistItem) {
                $this->loadedData[$blacklistItem->getId()] = $blacklistItem->getData();
            }
        }
        return $this->loadedData;
    }
}
