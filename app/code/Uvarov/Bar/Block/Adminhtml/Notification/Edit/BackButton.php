<?php

namespace Uvarov\Bar\Block\Adminhtml\Notification\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 * @package Uvarov\Bar\Block\Adminhtml\Notification\Edit
 */
class BackButton implements ButtonProviderInterface
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->urlBuilder->getUrl('*/*/');
    }
}
