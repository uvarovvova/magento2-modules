<?php

namespace Uvarov\Bar\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Uvarov\Bar\Model\Notification;

/**
 * Class Status
 * @package Uvarov\Bar\Ui\Component\Listing\Column
 */
class NotificationStatus implements OptionSourceInterface
{
	/** @var Notification  */
	protected $notification;

	/**
	 * Status constructor.
	 * @param Notification $notification
	 */
	public function __construct(Notification $notification)
	{
		$this->notification = $notification;
	}

	/**
	 * @return array
	 */
	public function toOptionArray()
	{

		$availableOptions = $this->notification->getStatuses();
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