<?php

namespace Sam\Price\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Sam\Price\Api\PriceRepositoryInterface;
use Sam\Price\Api\Data\PriceInterface;
use Sam\Price\Api\Data\PriceInterfaceFactory;
use Sam\Price\Api\Data\PriceSearchResultsInterfaceFactory;
use Sam\Price\Model\ResourceModel\Price as ResourcePrice;
use Sam\Price\Model\ResourceModel\Price\CollectionFactory as PriceCollectionFactory;

class PriceRepository implements PriceRepositoryInterface
{
	/**
	 * @var array
	 */
	protected $_instances = [];
	/**
	 * @var ResourcePrice
	 */
	protected $_resource;
	/**
	 * @var PriceCollectionFactory
	 */
	protected $_priceCollectionFactory;
	/**
	 * @var PriceSearchResultsInterfaceFactory
	 */
	protected $_searchResultsFactory;
	/**
	 * @var PriceInterfaceFactory
	 */
	protected $_priceInterfaceFactory;


	public function __construct(
		ResourcePrice $resource,
		PriceCollectionFactory $priceCollectionFactory,
		PriceSearchResultsInterfaceFactory $priceSearchResultsInterfaceFactory,
		PriceInterfaceFactory $priceInterfaceFactory
	)
	{
		$this->_resource = $resource;
		$this->_priceCollectionFactory = $priceCollectionFactory;
		$this->_searchResultsFactory = $priceSearchResultsInterfaceFactory;
		$this->_priceInterfaceFactory = $priceInterfaceFactory;
	}

	/**
	 * @param PriceInterface $data
	 * @return PriceInterface
	 * @throws CouldNotSaveException
	 */
	public function save(PriceInterface $data)
	{
		try {
			/** @var PriceInterface|\Magento\Framework\Model\AbstractModel $data */
			$this->_resource->save($data);
		} catch (\Exception $exception) {
			throw new CouldNotSaveException(__(
				'Could not save the data: %1',
				$exception->getMessage()
			));
		}
		return $data;
	}

	/**
	 * Get data record
	 *
	 * @param $dataId
	 * @return mixed
	 * @throws NoSuchEntityException
	 */
	public function getById($dataId)
	{
		if (!isset($this->_instances[$dataId])) {
			/** @var \Sam\Price\Api\Data\PriceInterface|\Magento\Framework\Model\AbstractModel $data */
			$data = $this->_priceInterfaceFactory->create();
			$this->_resource->load($data, $dataId);
			if (!$data->getId()) {
				throw new NoSuchEntityException(__('Requested data doesn\'t exist'));
			}
			$this->_instances[$dataId] = $data;
		}
		return $this->_instances[$dataId];
	}

	/**
	 * @param SearchCriteriaInterface $searchCriteria
	 * @return \Sam\Price\Api\Data\PriceSearchResultsInterface
	 */
	public function getList(SearchCriteriaInterface $searchCriteria)
	{
		/** @var \Sam\Price\Api\Data\PriceSearchResultsInterface $searchResults */
		$searchResults = $this->_searchResultsFactory->create();
		$searchResults->setSearchCriteria($searchCriteria);

		/** @var \Sam\Price\Model\ResourceModel\Price\Collection $collection */
		$collection = $this->_priceCollectionFactory->create();

		//Add filters from root filter group to the collection
		/** @var FilterGroup $group */
		foreach ($searchCriteria->getFilterGroups() as $group) {
			$this->addFilterGroupToCollection($group, $collection);
		}
		$sortOrders = $searchCriteria->getSortOrders();
		/** @var SortOrder $sortOrder */
		if ($sortOrders) {
			foreach ($searchCriteria->getSortOrders() as $sortOrder) {
				$field = $sortOrder->getField();
				$collection->addOrder(
					$field,
					($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
				);
			}
		} else {
			$field = 'data_id';
			$collection->addOrder($field, 'ASC');
		}
		$collection->setCurPage($searchCriteria->getCurrentPage());
		$collection->setPageSize($searchCriteria->getPageSize());

		$data = [];
		foreach ($collection as $datum) {
			$dataDataObject = $this->_priceInterfaceFactory->create();
			$data[] = $dataDataObject;
		}
		$searchResults->setTotalCount($collection->getSize());
		return $searchResults->setItems($data);
	}

	/**
	 * @param PriceInterface $data
	 * @return bool
	 * @throws CouldNotSaveException
	 * @throws StateException
	 */
	public function delete(PriceInterface $data)
	{
		/** @var \Sam\Price\Api\Data\PriceInterface|\Magento\Framework\Model\AbstractModel $data */
		$id = $data->getId();
		try {
			unset($this->_instances[$id]);
			$this->_resource->delete($data);
		} catch (ValidatorException $e) {
			throw new CouldNotSaveException(__($e->getMessage()));
		} catch (\Exception $e) {
			throw new StateException(
				__('Unable to remove data %1', $id)
			);
		}
		unset($this->_instances[$id]);
		return true;
	}

	/**
	 * @param $dataId
	 * @return bool|mixed
	 * @throws CouldNotSaveException
	 * @throws NoSuchEntityException
	 * @throws StateException
	 */
	public function deleteById($dataId)
	{
		$data = $this->getById($dataId);
		return $this->delete($data);
	}
}