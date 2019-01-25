<?php

namespace Uvarov\Bar\Controller\Adminhtml\Notification;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Uvarov\Bar\Api\Data\NotificationInterfaceFactory;
use Uvarov\Bar\Api\NotificationRepositoryInterface;

/**
 * Class Edit
 * @package Uvarov\Bar\Controller\Adminhtml\Notification
 */
class Edit extends Action
{
	/**
	 * @var Registry|null
	 */
	protected $_coreRegistry = null;

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @var NotificationInterfaceFactory
	 */
	protected $notificationInterfaceFactory;

	/**
	 * @var NotificationRepositoryInterface
	 */
	protected $notificationRepositoryInterface;


	/**
	 * Edit constructor.
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 * @param Registry $registry
	 * @param NotificationInterfaceFactory $notificationInterfaceFactory
	 * @param NotificationRepositoryInterface $notificationRepositoryInterface
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		Registry $registry,
		NotificationInterfaceFactory $notificationInterfaceFactory,
		NotificationRepositoryInterface $notificationRepositoryInterface
	)
	{
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
		$this->notificationInterfaceFactory = $notificationInterfaceFactory;
		$this->notificationRepositoryInterface = $notificationRepositoryInterface;
		parent::__construct($context);
	}

	/**
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Uvarov_bar::notification');
	}

	/**
	 * @return $this|\Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$id = $this->getRequest()->getParam('entity_id');
		$objectInstance = $this->notificationInterfaceFactory->create();

		if ($id) {

			$entity = $this->notificationRepositoryInterface->getById($id);

			if (!$entity->getId()) {

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
		$resultPage->getConfig()->getTitle()->prepend(__('Request notification edit'));
		return $resultPage;
	}
}
