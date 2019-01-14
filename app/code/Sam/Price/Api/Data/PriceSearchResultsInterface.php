<?php

namespace Sam\Price\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PriceSearchResultsInterface extends SearchResultsInterface
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