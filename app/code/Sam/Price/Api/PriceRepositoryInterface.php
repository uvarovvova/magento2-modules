<?php

namespace Sam\Price\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Sam\Price\Api\Data\PriceInterface;

interface PriceRepositoryInterface
{

	/**
	 * @param PriceInterface $data
	 * @return mixed
	 */
	public function save(PriceInterface $data);


	/**
	 * @param $dataId
	 * @return mixed
	 */
	public function getById($dataId);

	/**
	 * @param SearchCriteriaInterface $searchCriteria
	 * @return \Sam\Price\Api\Data\PriceSearchResultsInterface
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getList(SearchCriteriaInterface $searchCriteria);

	/**
	 * @param PriceInterface $data
	 * @return mixed
	 */
	public function delete(PriceInterface $data);

	/**
	 * @param $dataId
	 * @return mixed
	 */
	public function deleteById($dataId);
}