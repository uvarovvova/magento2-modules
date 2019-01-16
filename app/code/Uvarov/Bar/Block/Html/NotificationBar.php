<?php

namespace Uvarov\Bar\Block\Html;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Uvarov\Bar\Model\ResourceModel\Notification\Collection as NotificationCollection;

/**
 * Class NotificationBar
 * @package Uvarov\Bar\Block\Html
 */
class NotificationBar extends Template
{

	/**
	 * @var NotificationCollection
	 */
	protected $collection;

	/**
	 * @param Context $context
	 * @param NotificationCollection $collection
	 * @param array $data
	 */
	public function __construct(Context $context, NotificationCollection $collection, array $data = [])
	{
		parent::__construct($context, $data);
		$this->collection = $collection;
	}

	/**
	 * @return NotificationCollection
	 * @throws NoSuchEntityException
	 */
	public function getNotificationBars()
	{
		$notificationBars = $this->collection
			->addFilter('status', 1)
			->addFilter('store_id', 	$this->_storeManager->getStore()->getId())
			->setOrder('priority', 'ASC')
			->load();

		return $notificationBars;
	}
}
