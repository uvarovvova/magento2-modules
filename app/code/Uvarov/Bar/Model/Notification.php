<?php

namespace Uvarov\Bar\Model;

use Magento\Framework\Model\AbstractModel;
use Uvarov\Bar\Model\ResourceModel\Notification as NotificationResource;
use Uvarov\Bar\Api\Data\NotificationInterface;

/**
 * Class Notification
 *
 * @package Uvarov\Bar\Model
 */
class Notification extends AbstractModel implements NotificationInterface
{

	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 0;

	/**
	 * Initialise resource model
	 */
	protected function _construct()
	{
		$this->_init(NotificationResource::class);
	}

	/**
	 * Get Title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->getData(NotificationInterface::TITLE);
	}

	/**
	 * Set Title
	 *
	 * @param string $title
	 * @return mixed
	 */
	public function setTitle($title)
	{
		return $this->setData(NotificationInterface::TITLE, $title);
	}

	/**
	 * Get Content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->getData(NotificationInterface::CONTENT);
	}

	/**
	 * Set Content
	 *
	 * @param string $content
	 * @return mixed
	 */
	public function setContent($content)
	{
		return $this->setData(NotificationInterface::CONTENT, $content);
	}

	/**
	 * Get Background Color
	 *
	 * @return string
	 */
	public function getBackgroundColor()
	{
		return $this->getData(NotificationInterface::BACKGROUND_COLOR);
	}

	/**
	 * Set Background Color
	 *
	 * @param string $backgroundColor
	 * @return mixed
	 */
	public function setBackgroundColor($backgroundColor)
	{
		return $this->setData(NotificationInterface::BACKGROUND_COLOR, $backgroundColor);
	}

	/**
	 * Get status
	 *
	 * @return bool|int
	 */
	public function getStatus()
	{
		return $this->getData(NotificationInterface::STATUS);
	}

	/**
	 * Set status
	 *
	 * @param int $status
	 * @return $this
	 */
	public function setStatus($status)
	{
		return $this->setData(NotificationInterface::STATUS, $status);
	}

	/**
	 * @return mixed
	 */
	public function getPriority()
	{
		return $this->getData(NotificationInterface::PRIORITY);

	}

	/**
	 * Priority
	 *
	 * @param integer $priority
	 * @return mixed
	 */
	public function setPriority($priority)
	{
		return $this->setData(NotificationInterface::PRIORITY, $priority);
	}

	/**
	 * @return array
	 */
	public function getStatuses()
	{
		return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
	}
}
