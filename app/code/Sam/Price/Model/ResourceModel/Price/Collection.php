<?php
namespace Sam\Price\Model\ResourceModel\Price;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Sam\Price\Model\Price;
use Sam\Price\Model\ResourceModel\Price as PriceResource;

class Collection extends AbstractCollection
{
	/**
	 * @var string
	 */
	protected $_idFieldName = 'entity_id';

	/**
	 * Collection initialisation
	 */
	protected function _construct()
	{
		$this->_init(Price::class,PriceResource::class);
	}
}