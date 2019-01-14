<?php

namespace Sam\Price\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Sam\Price\Api\PriceRepositoryInterface;
use Sam\Price\Api\Data\PriceInterface;
use Sam\Price\Api\Data\PriceInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;


class Index extends Action
{


	/**
	 * @var PriceRepositoryInterface
	 */
	protected $_priceRepository;

	/**
	 * @var PriceInterfaceFactory
	 */
	protected $_priceInterfaceFactory;

	/**
	 * Index constructor.
	 * @param Context $context
	 * @param PriceRepositoryInterface $priceRepository
	 * @param PriceInterfaceFactory $priceInterfaceFactory
	 */
	public function __construct(
		Context $context,
		PriceRepositoryInterface $priceRepository,
		PriceInterfaceFactory $priceInterfaceFactory
	)
	{
		parent::__construct($context);
		$this->_priceRepository = $priceRepository;
		$this->_priceInterfaceFactory = $priceInterfaceFactory;
	}

	public function execute()
	{
		$entity = $this->_priceRepository->getList();

		print_r($entity->getData());
exit;
		$model = $this->_priceInterfaceFactory->create();
		$data = [
			'data_title' => 'A short story',
			'data_description' => 'The quick brown fox jumped over the lazy dog',
			'is_active' => true
		];

		$this->_priceRepository->save($model);
	}
}