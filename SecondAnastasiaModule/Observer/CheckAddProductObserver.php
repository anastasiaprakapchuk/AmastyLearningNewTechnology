<?php

namespace Amasty\SecondAnastasiaModule\Observer;

use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Amasty\SecondAnastasiaModule\Model\ConfigProvider;
use Magento\Catalog\Api\ProductRepositoryInterface;

class CheckAddProductObserver implements ObserverInterface
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var Session
     */
    private $session;

    public function __construct(
        ConfigProvider             $configProvider,
        ProductRepositoryInterface $productRepository,
        Session                    $session
    )
    {
        $this->configProvider = $configProvider;
        $this->productRepository = $productRepository;
        $this->session = $session;
    }

    public function execute(Observer $observer)
    {
        $skuInForm = $observer->getData('check_sku');

        $strForSku = $this->configProvider->getForSKU();

        $forSku = preg_split("/[\s,]+/", $strForSku);

        if (in_array($skuInForm, $forSku)) {
            $promoSku = $this->configProvider->getPromoSKU();
            $product = $this->productRepository->get($promoSku);
            $this->addPromo($product);
        }
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    private function addPromo($product)
    {
        $quote = $this->session->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }
        $quote->addProduct($product, 1);
        $quote->save();
    }
}
