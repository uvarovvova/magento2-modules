<?php
namespace Sam\Price\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Price
 * @package Sam\Price\Model\ResourceModel
 */
class Price extends AbstractDb
{
	/**
	 * Example constructor.
	 * @param Context $context
	 */
	public function __construct(
		Context $context
	) {
		parent::__construct($context);
	}

	/**
	 * Resource initialisation
	 */
	protected function _construct()
	{
		$this->_init('request_price', 'entity_id');
	}
}