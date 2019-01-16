<?php

namespace Uvarov\Bar\Controller\Adminhtml\Notification;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Uvarov\Bar\Model\NotificationFactory;
use Uvarov\Bar\Model\ResourceModel\Notification as ResourceNotification;

class Delete extends Action
{
	/** @var notificationFactory $objectFactory */
	protected $objectFactory;

	/** @var ResourceNotification  */
	protected $resourceNotification;

	/**
	 * Delete constructor.
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
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Uvarov_Bar::notification');
	}

	/**
	 * Delete action
	 *
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$resultRedirect = $this->resultRedirectFactory->create();
		$id = $this->getRequest()->getParam('entity_id', null);

		try {
			$objectInstance = $this->objectFactory->create();
			$this->resourceNotification->load($objectInstance, $id);
			if ($objectInstance->getId()) {
				$this->resourceNotification->delete($objectInstance);
				$this->messageManager->addSuccessMessage(__('You deleted the record.'));
			} else {
				$this->messageManager->addErrorMessage(__('Record does not exist.'));
			}
		} catch (\Exception $exception) {
			$this->messageManager->addErrorMessage($exception->getMessage());
		}

		return $resultRedirect->setPath('*/*');
	}
}
