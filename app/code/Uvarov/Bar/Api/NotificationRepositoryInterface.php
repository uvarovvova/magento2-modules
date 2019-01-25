<?php

namespace Uvarov\Bar\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Uvarov\Bar\Api\Data\NotificationInterface;

/**
 * Interface NotificationRepositoryInterface
 * @package Uvarov\Bar\Api
 */
interface NotificationRepositoryInterface
{

	/**
	 * @param NotificationInterface $data
	 * @return mixed
	 */
	public function save(NotificationInterface $data);


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
	 * @param NotificationInterface $data
	 * @return mixed
	 */
	public function delete(NotificationInterface $data);

	/**
	 * @param $dataId
	 * @return mixed
	 */
	public function deleteById($dataId);
}