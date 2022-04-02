<?php

namespace Amasty\AnastasiaModule\Controller\Autocomplete;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;


class Autocomplete extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;


    public function __construct(
        Context                  $context,
        JsonFactory              $resultJsonFactory,
        ProductCollectionFactory $productCollectionFactory,
        RedirectFactory          $resultRedirectFactory
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //получаем данные из формы
        $data = $this->getRequest()->getParams();
        $sku = $data['q'];

        try {
            $productCollection = $this->productCollectionFactory->create()
                ->addAttributeToSelect(['sku', 'name'])
                ->addAttributeToFilter('sku', ['like' => $sku . '%'])
                ->setPageSize(5);

            $products = [];
            foreach ($productCollection as $product) {
                $products[] = ['sku' => $product->getSku(), 'name' => $product->getName()];
            }

            $resultJson = $this->resultJsonFactory->create();
            $resultJson->setData($products);
            return $resultJson;

        } catch (Exception $e) {
            $this->messageManager->addErrorMessage('Что-то пошло не так...');
        }
    }
}
