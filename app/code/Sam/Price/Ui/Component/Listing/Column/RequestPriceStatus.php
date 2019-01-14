<?php

namespace Sam\Price\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Sam\Price\Api\Data\PriceInterfaceFactory;


/**
 * Class RequestPriceStatus
 * @package Sam\Price\Ui\Component\Listing\Column
 */
class RequestPriceStatus implements OptionSourceInterface
{

	/**
	 * @var PriceInterfaceFactory
	 */
	protected $_priceInterfaceFactory;

	public function __construct(PriceInterfaceFactory $priceRepository)
	{
		$this->_priceInterfaceFactory = $priceRepository;
	}

	/**
	 * @return array
	 */
	public function toOptionArray()
	{
		$model = $this->_priceInterfaceFactory->create();
		$availableOptions = $model->getStatuses();
		$options = [];
		foreach ($availableOptions as $key => $value) {
			$options[] = [
				'label' => $value,
				'value' => $key,
			];
		}

		return $options;
	}
}