<?php

namespace Amasty\AnastasiaModule\Cron;

use Amasty\AnastasiaModule\Model\Blacklist;
use Amasty\AnastasiaModule\Model\ConfigProvider;

class AmNotification
{
    /**
     * @var ConfigProvider
     */
    protected $scopeConfig;

    /**
     * @var \Amasty\AnastasiaModule\Model\BlacklistRepository
     */
    private $blacklistRepository;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var \Magento\Framework\Mail\Template\Factory
     */
    private $templateFactory;

    public function __construct(
        ConfigProvider                                    $scopeConfig,
        \Amasty\AnastasiaModule\Model\BlacklistRepository $blacklistRepository,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Mail\Template\Factory          $templateFactory
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->blacklistRepository = $blacklistRepository;
        $this->transportBuilder = $transportBuilder;
        $this->templateFactory = $templateFactory;
    }

    public function execute()
    {
        $blacklistItem = $this->blacklistRepository->getById(1);

        $blacklistItemSku = $this->blacklistRepository->getBySku(1);
        $blacklistItemQty = $this->blacklistRepository->getByQty(1);

        $templateId = 'anastasia_config_email_blacklist_template';

        $templateVars = [
            'blacklistItem' => $blacklistItem,
            'blacklistItemSku' => $blacklistItemSku,
            'blacklistItemQty' => $blacklistItemQty
        ];

        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => 0
        ];

        $template = $this->templateFactory->get($templateId);
        $template->setVars($templateVars)
            ->setOptions($templateOptions);

        $messageBody = $template->processTemplate();

        $this->blacklistRepository->setEmailBody(1, $messageBody);

        //отправка на email
        $transport = $this->transportBuilder->setTemplateIdentifier($templateId)
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom([
                'name' => $this->scopeConfig->getNameSendFrom(),
                'email' => $this->scopeConfig->getEmailSendFrom()
            ])
            ->addTo(
                $this->scopeConfig->getSendEmailToFromConfig()
            )
            ->getTransport();

        $transport->sendMessage();

    }
}


