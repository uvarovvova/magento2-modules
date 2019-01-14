<?php

namespace Sam\Price\Model;

use Magento\Framework\Model\AbstractModel;
use Sam\Price\Api\Data\PriceInterface;
use Sam\Price\Model\ResourceModel\Price as ResourcePrice;

/**
 * Class Price
 * @package Sam\Price\Model
 */
class Price extends AbstractModel implements PriceInterface
{

	const STATUS_NEW = 0;
	const STATUS_IN_PROGRESS = 1;
	const STATUS_CLOSED = 2;

	/**
	 * Cache tag
	 */
	const CACHE_TAG = 'request_price';

	/**
	 * Initialise resource model
	 */
	protected function _construct()
	{
		$this->_init(ResourcePrice::class);
	}

	/**
	 * Get cache identities
	 *
	 * @return array
	 */
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->getData(PriceInterface::NAME);
	}

	/**
	 * @param $name
	 * @return $this
	 */
	public function setName($name)
	{
		return $this->setData(PriceInterface::NAME, $name);
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->getData(PriceInterface::EMAIL);
	}

	/**
	 * @param $email
	 * @return $this
	 */
	public function setEmail($email)
	{
		return $this->setData(PriceInterface::EMAIL, $email);
	}

	/**
	 * @return string
	 */
	public function getSku()
	{
		return $this->getData(PriceInterface::SKU);
	}

	/**
	 * @param $sku
	 * @return $this
	 */
	public function setSku($sku)
	{
		return $this->setData(PriceInterface::SKU, $sku);
	}

	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->getData(PriceInterface::COMMENT);
	}

	/**
	 * @param $comment
	 * @return $this
	 */
	public function setComment($comment)
	{
		return $this->setData(PriceInterface::COMMENT, $comment);
	}

	/**
	 * @return bool|int
	 */
	public function getStatus()
	{
		return $this->getData(PriceInterface::STATUS);
	}

	/**
	 * @return array
	 */
	public function getStatuses()
	{
		return [self::STATUS_NEW => __('New'), self::STATUS_IN_PROGRESS => __('In Progress'), self::STATUS_CLOSED => __('Closed')];
	}

	/**
	 * @param $status
	 * @return $this
	 */
	public function setStatus($status)
	{
		return $this->setData(PriceInterface::STATUS, $status);
	}

	/**
	 * @return string
	 */
	public function getCreatedAt()
	{
		return $this->getData(PriceInterface::CREATED_AT);
	}


}