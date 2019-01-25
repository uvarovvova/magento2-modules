<?php

namespace Uvarov\Bar\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface NotificationSearchResultsInterface
 * @package Sam\Price\Api\Data
 */
interface NotificationSearchResultsInterface extends SearchResultsInterface
{
	/**
	 * get data list
	 *
	 * @return $this
	 */
	public function getItems();

	/**
	 *
	 * set param list
	 *
	 * @param array $items
	 * @return $this
	 */
	public function setItems(array $items);
}