<?php

namespace Sam\Price\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Sam\Price\Api\Data\PriceInterfaceFactory;
use Sam\Price\Api\PriceRepositoryInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Send
 * @package Sam\Price\Controller\Index
 */
class Send extends Action
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
	 * @var JsonFactory
	 */
	protected $resultJsonFactory;

	/**
	 * Send constructor.
	 * @param Context $context
	 * @param JsonFactory $resultJsonFactory
	 * @param PriceInterfaceFactory $priceInterfaceFactory
	 * @param PriceRepositoryInterface $priceRepositoryInterface
	 */
	public function __construct(
		Context $context,
		JsonFactory $resultJsonFactory,
		PriceInterfaceFactory $priceInterfaceFactory,
		PriceRepositoryInterface $priceRepositoryInterface
	)
	{
		parent::__construct($context);
		$this->resultJsonFactory = $resultJsonFactory;
		$this->priceInterfaceFactory = $priceInterfaceFactory;
		$this->priceRepositoryInterface = $priceRepositoryInterface;

	}

	/**
	 * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		if($this->getRequest()->isXmlHttpRequest()) {

			$data = $this->getRequest()->getParams();
			$resultJson = $this->resultJsonFactory->create();

			$objectInstance = $this->priceInterfaceFactory->create();

			try {
				$objectInstance->setSku($data['sku']);
				$objectInstance->setName($data['name']);
				$objectInstance->setEmail($data['email']);
				$objectInstance->setComment($data['comment']);
				$this->priceRepositoryInterface->save($objectInstance);

				$response = ['status' => true, 'message' => __('Request was send')];

			} catch (\Exception $e) {
				$response = ['status' => false, 'message' => __('Wrong')];
			}
			return $resultJson->setData($response);
		}

		return $this->_redirect($this->_redirect->getRefererUrl());

	}

}