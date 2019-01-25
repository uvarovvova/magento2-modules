<?php

namespace Uvarov\Bar\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Uvarov\Bar\Api\NotificationRepositoryInterface;
use Uvarov\Bar\Api\Data\NotificationInterface;
use Uvarov\Bar\Api\Data\NotificationInterfaceFactory;
use Uvarov\Bar\Api\Data\NotificationSearchResultsInterfaceFactory;
use Uvarov\Bar\Model\ResourceModel\Notification as ResourceNotification;
use Uvarov\Bar\Model\ResourceModel\Notification\CollectionFactory as NotificationCollectionFactory;

/**
 * Class NotificationRepository
 * @package Uvarov\Bar\Model
 */
class NotificationRepository implements NotificationRepositoryInterface
{
	/**
	 * @var array
	 */
	protected $_instances = [];
	/**
	 * @var ResourceNotification
	 */
	protected $_resource;
	/**
	 * @var NotificationCollectionFactory
	 */
	protected $_notificationCollectionFactory;
	/**
	 * @var NotificationSearchResultsInterfaceFactory
	 */
	protected $_searchResultsFactory;
	/**
	 * @var NotificationInterfaceFactory
	 */
	protected $_notificationInterfaceFactory;


	public function __construct(
		ResourceNotification $resource,
		NotificationCollectionFactory $notificationCollectionFactory,
		NotificationSearchResultsInterfaceFactory $notificationSearchResultsInterfaceFactory,
		NotificationInterfaceFactory $notificationInterfaceFactory
	)
	{
		$this->_resource = $resource;
		$this->_notificationCollectionFactory = $notificationCollectionFactory;
		$this->_searchResultsFactory = $notificationSearchResultsInterfaceFactory;
		$this->_notificationInterfaceFactory = $notificationInterfaceFactory;
	}

	/**
	 * @param NotificationInterface $data
	 * @return NotificationInterface
	 * @throws CouldNotSaveException
	 */
	public function save(NotificationInterface $data)
	{
		try {
			/** @var NotificationInterface|\Magento\Framework\Model\AbstractModel $data */
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
			/** @var \Uvarov\Bar\Api\Data\NotificationInterface|\Magento\Framework\Model\AbstractModel $data */
			$data = $this->_notificationInterfaceFactory->create();
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
	 * @return \Uvarov\Bar\Api\Data\NotificationSearchResultsInterface
	 */
	public function getList(SearchCriteriaInterface $searchCriteria)
	{
		/** @var \Uvarov\Bar\Api\Data\NotificationSearchResultsInterface $searchResults */
		$searchResults = $this->_searchResultsFactory->create();
		$searchResults->setSearchCriteria($searchCriteria);

		/** @var \Uvarov\Bar\Model\ResourceModel\Notification\Collection $collection */
		$collection = $this->_notificationCollectionFactory->create();

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
			$dataDataObject = $this->_notificationInterfaceFactory->create();
			$data[] = $dataDataObject;
		}
		$searchResults->setTotalCount($collection->getSize());
		return $searchResults->setItems($data);
	}

	/**
	 * @param NotificationInterface $data
	 * @return bool
	 * @throws CouldNotSaveException
	 * @throws StateException
	 */
	public function delete(NotificationInterface $data)
	{
		/** @var \Uvarov\Bar\Api\Data\NotificationInterface|\Magento\Framework\Model\AbstractModel $data */
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