<?php

namespace Uvarov\Bar\Controller\Adminhtml\Notification;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Uvarov\Bar\Model\NotificationFactory;
use Uvarov\Bar\Model\ResourceModel\Notification as ResourceNotification;

/**
 * Class Edit
 * @package Uvarov\Bar\Controller\Adminhtml\Notification
 */
class Edit extends Action
{
	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $_coreRegistry = null;

	/** @var ResourceNotification */
	protected $resourceNotification;

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/** @var notificationFactory $objectFactory */
	protected $objectFactory;

	/**
	 * Edit constructor.
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 * @param Registry $registry
	 * @param NotificationFactory $objectFactory
	 * @param ResourceNotification $resourceNotification
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		Registry $registry,
		NotificationFactory $objectFactory,
		ResourceNotification $resourceNotification
	)
	{
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
		$this->objectFactory = $objectFactory;
		$this->resourceNotification = $resourceNotification;
		parent::__construct($context);
	}

	/**
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Uvarov_Bar::notification');
	}

	/**
	 * @return $this|\Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$id = $this->getRequest()->getParam('entity_id');
		$objectInstance = $this->objectFactory->create();

		if ($id) {
			$objectInstance = $this->objectFactory->create();
			$this->resourceNotification->load($objectInstance, $id);
			if (!$objectInstance->getId()) {

				$this->messageManager->addErrorMessage(__('This record no longer exists.'));
				/** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
				$resultRedirect = $this->resultRedirectFactory->create();

				return $resultRedirect->setPath('*/*/');
			}
		}

		$data = $this->_session->getFormData(true);

		if (!empty($data)) {
			$objectInstance->addData($data);
		}

		$this->_coreRegistry->register('entity_id', $id);

		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();

		$resultPage->setActiveMenu('Uvarov_Bar::notification');
		$resultPage->getConfig()->getTitle()->prepend(__('Notification Edit'));
		return $resultPage;
	}
}
