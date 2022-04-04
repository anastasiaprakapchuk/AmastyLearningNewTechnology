<?php

namespace Amasty\AnastasiaModule\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Catalog\Model\Product\Type;
use Magento\Framework\Event\ManagerInterface;


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

    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var \Amasty\AnastasiaModule\Model\ResourceModel\Blacklist\CollectionFactory
     */
    private $blacklistCollectionFactory;


    public function __construct(
        Context                                                                 $context,
        CheckoutSession                                                         $session,
        ProductRepositoryInterface                                              $productRepository,
        RedirectFactory                                                         $resultRedirectFactory,
        StockItemRepository                                                     $stockItemRepository,
        ManagerInterface                                                        $eventManager,
        \Amasty\AnastasiaModule\Model\ResourceModel\Blacklist\CollectionFactory $blacklistCollectionFactory
    )
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->stockItemRepository = $stockItemRepository;
        $this->eventManager = $eventManager;
        $this->blacklistCollectionFactory = $blacklistCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        //получаем данные из формы
        $data = $this->getRequest()->getParams();
        $sku = $data['sku'];
        $qty = $data['qty'];

        try {

            $product = $this->productRepository->get($sku);
            $productId = $product->getId();
            $productStock = $this->stockItemRepository->get($productId);
            $maxProducts = $productStock->getQty();


            if ($product->getTypeId() !== Type::TYPE_SIMPLE) {

                $this->messageManager->addWarningMessage('This product must be simple!');

            } else {

                $quote = $this->session->getQuote();
                if (!$quote->getId()) {
                    $quote->save();
                }

                $blacklistQty = $this->checkBlackList($sku);

                if ($blacklistQty) {

                    $productInCart = $quote->getItemByProduct($product);

                    $qtyInCart = $productInCart ? $productInCart->getQty() : 0;

                    $totalQty = $qty + $qtyInCart;

                    if ($blacklistQty > $totalQty) {

                        $this->saveProductInCart($quote, $product, $qty);

                    } else {

                        $newQty = $blacklistQty - $qtyInCart;

                        $newQty ?
                            $this->saveProductInCart($quote, $product, $newQty, false) :
                            $this->messageManager->addErrorMessage('Products are not added to the cart. Limit exceeded!');
                    }

                } else {

                    if ($maxProducts < $qty) {

                        $this->messageManager->addWarningMessage("You can order $sku a maximum of $maxProducts products!");

                    } else {

                        $this->saveProductInCart($quote, $product, $qty);

                    }

                }

            }
        } catch (NoSuchEntityException $e) {

            $this->messageManager->addErrorMessage('This product does not exist!');

        } finally {

            //редирект на страницу с формой
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('anastasia');

        }
    }

    private function checkBlackList($sku)
    {
        /** @var \Amasty\AnastasiaModule\Model\ResourceModel\Blacklist\Collection $blacklistCollection */
        $blacklistCollection = $this->blacklistCollectionFactory->create();
        $blacklistCollection->addFieldToFilter('sku', ['eq' => $sku]);

        if ($blacklistCollection->count()) {
            return $blacklistCollection->getFirstItem()['qty'];
        } else {
            return 0;
        }
    }

    private function saveProductInCart($quote, $product, $qty, $successMessage = true)
    {
        $quote->addProduct($product, $qty);
        $quote->save();

        $successMessage ?
            $this->messageManager->addSuccessMessage('Product added to cart successfully!') :
            $this->messageManager->addErrorMessage("Product added to cart in quantity $qty");

        $sku = $product->getSku();

        $this->eventManager->dispatch(
            'amasty_anastasiamodule_checkaddproduct',
            ['check_sku' => $sku]
        );
    }
}
