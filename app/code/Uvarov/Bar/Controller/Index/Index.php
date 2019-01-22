<?php

namespace Uvarov\Bar\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\Context;
use Uvarov\Bar\Model\ResourceModel\Notification\Collection as NotificationCollection;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Index
 * @package Uvarov\Bar\Controller\Index
 */
class Index extends Action
{

	/**
	 * @var JsonFactory
	 */
	protected $resultJsonFactory;

	/**
	 * @var NotificationCollection
	 */
	protected $collection;

	/**
	 * @var StoreManagerInterface
	 */
	protected $storeManager;

	/**
	 * Notifications constructor.
	 * @param Context $context
	 * @param JsonFactory $resultJsonFactory
	 * @param NotificationCollection $collection
	 * @param StoreManagerInterface $storeManager
	 */
	public function __construct(
		Context $context,
		JsonFactory $resultJsonFactory,
		NotificationCollection $collection,
		StoreManagerInterface $storeManager
	)
	{
		parent::__construct($context);
		$this->resultJsonFactory = $resultJsonFactory;
		$this->collection = $collection;
		$this->storeManager = $storeManager;
	}

	/**
	 * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
	 * @throws \Magento\Framework\Exception\NoSuchEntityException
	 */
	public function execute()
	{

		if ($this->getRequest()->isXmlHttpRequest()) {

			$notificationBars = $this->collection
				->addFilter('status', 1)
				->addFilter('store_id', $this->storeManager->getStore()->getId())
				->setOrder('priority', 'ASC')
				->load()
				->toArray();

			$resultJson = $this->resultJsonFactory
				->create()
				->setData($notificationBars);

			 return $resultJson;
		}

		return $this->_redirect($this->_redirect->getRefererUrl());
	}
}
