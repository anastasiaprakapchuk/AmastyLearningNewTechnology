<?php

namespace Amasty\AnastasiaModule\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class BlacklistAction extends Column
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    public function __construct(
        \Magento\Framework\UrlInterface                              $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory           $uiComponentFactory,
        array                                                        $components = [],
        array                                                        $data = [])
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $indexField = $this->getData('config/indexField') ?: 'id';
                if (isset($item[$indexField])) {
                    $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
                    $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'id';
                    $item[$this->getData('name')] = ['view' => [
                        'href' => $this->urlBuilder->getUrl($viewUrlPath, [$urlEntityParamName => $item[$indexField]]),
                        'label' => __('Edit'),
                        '__disableTmpl' => true,
                    ]];
                }
            }
        }
        return $dataSource;
    }
}
