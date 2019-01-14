<?php

namespace Sam\Price\Controller\Adminhtml\Price;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Sam\Price\Api\Data\PriceInterfaceFactory;
use Sam\Price\Api\PriceRepositoryInterface;

/**
 * Class Save
 * @package Sam\Price\Controller\Adminhtml\Price
 */
class Save extends Action
{

	/**
	 * @var PriceInterfaceFactory
	 */
	protected $priceInterfaceFactory;

	/**
	 * @var PriceRepositoryInterface
	 */
	protected $priceRepositoryInterface;


	/**
	 * Save constructor.
	 * @param Context $context
	 * @param PriceInterfaceFactory $priceInterfaceFactory
	 * @param PriceRepositoryInterface $priceRepositoryInterface
	 */
	public function __construct(
		Context $context,
		PriceInterfaceFactory $priceInterfaceFactory,
		PriceRepositoryInterface $priceRepositoryInterface
	)
	{
		$this->priceInterfaceFactory = $priceInterfaceFactory;
		$this->priceRepositoryInterface = $priceRepositoryInterface;
		parent::__construct($context);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Sam_Price::price');
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
			$objectInstance = $this->priceInterfaceFactory->create();
			$idField = $objectInstance::ENTITY_ID;

			if (empty($data[$idField])) {
				$data[$idField] = null;
			} else {
				$this->priceRepositoryInterface->getById($data[$idField]);
//				$this->resourceQuestion->load($objectInstance, $data[$idField]);
				$params[$idField] = $data[$idField];
			}

			$objectInstance->addData($data);

			$this->_eventManager->dispatch(
				'sam_price_prepare_save',
				['object' => $this->priceInterfaceFactory, 'request' => $this->getRequest()]
			);

			try {
				$this->priceRepositoryInterface->save($objectInstance);
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
