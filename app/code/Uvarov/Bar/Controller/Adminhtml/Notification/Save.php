<?php

namespace Uvarov\Bar\Controller\Adminhtml\Notification;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Uvarov\Bar\Model\NotificationFactory;
use Uvarov\Bar\Model\ResourceModel\Notification as ResourceNotification;

/**
 * Class Save
 * @package Uvarov\Bar\Controller\Adminhtml\Notification
 */
class Save extends Action
{
	/** @var NotificationFactory $objectFactory */
	protected $objectFactory;

	/** @var ResourceNotification */
	protected $resourceNotification;

	/**
	 * Save constructor.
	 * @param Context $context
	 * @param NotificationFactory $objectFactory
	 * @param ResourceNotification $resourceNotification
	 */
	public function __construct(
		Context $context,
		NotificationFactory $objectFactory,
		ResourceNotification $resourceNotification
	)
	{
		$this->objectFactory = $objectFactory;
		$this->resourceNotification = $resourceNotification;
		parent::__construct($context);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Uvarov_Bar::notification');
	}

	/**
	 * Save action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$data = $this->getRequest()->getParams();
		/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
		$resultRedirect = $this->resultRedirectFactory->create();

		if ($data) {
			$params = [];
			$objectInstance = $this->objectFactory->create();
			$idField = $objectInstance->getIdFieldName();

			if (empty($data[$idField])) {
				$data[$idField] = null;
			} else {
				$this->resourceNotification->load($objectInstance, $data[$idField]);
				$params[$idField] = $data[$idField];
			}

			$objectInstance->addData($data);

			$this->_eventManager->dispatch(
				'uvarov_bar_notification_prepare_save',
				['object' => $this->objectFactory, 'request' => $this->getRequest()]
			);

			try {
				$this->resourceNotification->save($objectInstance);
				$this->messageManager->addSuccessMessage(__('You saved this record.'));
				$this->_getSession()->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$params = [$idField => $objectInstance->getId(), '_current' => true];
					return $resultRedirect->setPath('*/*/edit', $params);
				}
				return $resultRedirect->setPath('*/*/');
			} catch (\Exception $e) {
				$this->messageManager->addErrorMessage($e->getMessage());
				$this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the record.'));
			}

			$this->_getSession()->setFormData($this->getRequest()->getPostValue());
			return $resultRedirect->setPath('*/*/edit', $params);
		}
		return $resultRedirect->setPath('*/*/');
	}
}
