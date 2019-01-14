<?php

namespace Sam\Price\Controller\Adminhtml\Price;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Sam\Price\Api\Data\PriceInterfaceFactory;
use Sam\Price\Api\PriceRepositoryInterface;

/**
 * Class Edit
 * @package Sam\Price\Controller\Adminhtml\Price
 */
class Edit extends Action
{
	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $_coreRegistry = null;

	/**
	 * @var PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @var PriceInterfaceFactory
	 */
	protected $priceInterfaceFactory;

	/**
	 * @var PriceRepositoryInterface
	 */
	protected $priceRepositoryInterface;


	/**
	 * Edit constructor.
	 * @param Context $context
	 * @param PageFactory $resultPageFactory
	 * @param Registry $registry
	 * @param PriceInterfaceFactory $priceInterfaceFactory
	 * @param PriceRepositoryInterface $priceRepositoryInterface
	 */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		Registry $registry,
		PriceInterfaceFactory $priceInterfaceFactory,
		PriceRepositoryInterface $priceRepositoryInterface
	)
	{
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
		$this->priceInterfaceFactory = $priceInterfaceFactory;
		$this->priceRepositoryInterface = $priceRepositoryInterface;
		parent::__construct($context);
	}

	/**
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Sam_Price::price');
	}

	/**
	 * @return $this|\Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$id = $this->getRequest()->getParam('entity_id');
		$objectInstance = $this->priceInterfaceFactory->create();

		if ($id) {

			$entity = $this->priceRepositoryInterface->getById($id);

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

		$resultPage->setActiveMenu('Sam_Price::price');
		$resultPage->getConfig()->getTitle()->prepend(__('Request price edit'));
		return $resultPage;
	}
}
