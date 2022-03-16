<?php

namespace Amasty\AnastasiaModule\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;


class Add extends Action
{
    /**
     * @var CheckoutSession
     */
    private $session;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;


    public function __construct(
        Context                    $context,
        CheckoutSession            $session,
        ProductRepositoryInterface $productRepository,
        RedirectFactory            $resultRedirectFactory
    )
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //получаем данные из формы
        $data = $this->getRequest()->getParams();
        $sku = $data['sku'];
        $qty = $data['qty'];

        //добавляем товар в корзину

        $product = $this->productRepository->get($sku);



        $quote = $this->session->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }
        $quote->addProduct($product, $qty);
        $quote->save();


        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('anastasia');

    }
}
