<?php

namespace Amasty\SecondAnastasiaModule\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\Manager;

class ChangeMagentoCheckout
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository1;

    /**
     * @var Manager
     */
    private $messageManager;

    public function __construct(
        ProductRepositoryInterface $productRepository1,
        Manager                    $messageManager
    )
    {
        $this->productRepository1 = $productRepository1;
        $this->messageManager = $messageManager;
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeExecute(
        \Magento\Checkout\Controller\Cart\Add $subject
    )
    {
        try {
            $data = $subject->getRequest()->getParams();
            $sku = $data['sku'];
            $product = $this->productRepository1->get($sku);
            $productId = $product->getId();
            $dataAdditional = ['product' => $productId];
            $dataNew = array_merge($data, $dataAdditional);
            $subject->getRequest()->setParams($dataNew);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage('This product does not exist!');
        }
    }
}
