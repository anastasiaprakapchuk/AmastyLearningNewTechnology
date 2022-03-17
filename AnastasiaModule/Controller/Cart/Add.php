<?php

namespace Amasty\AnastasiaModule\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;


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

    /**
     * @var StockItemRepository
     */
    protected $stockItemRepository;


    public function __construct(
        Context                    $context,
        CheckoutSession            $session,
        ProductRepositoryInterface $productRepository,
        RedirectFactory            $resultRedirectFactory,
        StockItemRepository $stockItemRepository
    )
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->stockItemRepository=$stockItemRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        //получаем данные из формы
        $data = $this->getRequest()->getParams();
        $sku = $data['sku'];
        $qty = $data['qty'];

        //получаем продукт по sku
        try{
            $product = $this->productRepository->get($sku);
            $productId=$product->getId();
            $productStock = $this->stockItemRepository->get($productId);;
            $maxProducts=$productStock->getQty();


        //проверяем некоторые условия

        if($product->getTypeId()!=='simple'){
            $this->messageManager->addWarningMessage('The product must be simple!');
        }

        else if($maxProducts<$qty){
            $this->messageManager->addWarningMessage("You can order a maximum of $maxProducts products!");
        }

        else{
            //сохраняем
            $quote = $this->session->getQuote();
            if (!$quote->getId()) {
                $quote->save();
            }
            $quote->addProduct($product, $qty);
            $quote->save();
        }
        }
        catch (Exeption $ex){
            $this->messageManager->addWarningMessage('This product does not exist!');
        } finally {
            //редирект на страницу с формой
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('anastasia');
        }

    }
}
