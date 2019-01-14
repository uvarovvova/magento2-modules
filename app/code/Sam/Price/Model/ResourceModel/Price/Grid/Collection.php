<?php

namespace Sam\Price\Model\ResourceModel\Price\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Api\Search\AggregationInterface;
use Psr\Log\LoggerInterface;
use Sam\Price\Model\ResourceModel\Price\Collection as PriceCollection;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;

/**
 * Class Collection
 * @package Sam\Price\Model\ResourceModel\Question\Grid
 */
class Collection extends PriceCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    protected $aggregations;

	/**
	 * Collection constructor.
	 * @param EntityFactoryInterface $entityFactory
	 * @param LoggerInterface $logger
	 * @param FetchStrategyInterface $fetchStrategy
	 * @param ManagerInterface $eventManager
	 * @param $mainTable
	 * @param $eventPrefix
	 * @param $eventObject
	 * @param $resourceModel
	 * @param null $connection
	 * @param AbstractDb|null $resource
	 */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init(Document::class, $resourceModel);
        $this->setMainTable($mainTable);
    }

	/**
	 * @return AggregationInterface
	 */
    public function getAggregations()
    {
        return $this->aggregations;
    }

	/**
	 * @param AggregationInterface $aggregations
	 * @return $this|void
	 */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }


	/**
	 * @param null $limit
	 * @param null $offset
	 * @return array
	 */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

	/**
	 * @return \Magento\Framework\Api\Search\SearchCriteriaInterface|null
	 *
	 */
    public function getSearchCriteria()
    {
        return null;
    }

	/**
	 * @param SearchCriteriaInterface|null $searchCriteria
	 * @return $this
	 */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

	/**
	 * @return int
	 */
    public function getTotalCount()
    {
        return $this->getSize();
    }

	/**
	 * @param int $totalCount
	 * @return $this
	 */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

	/**
	 * @param array|null $items
	 * @return $this
	 */
    public function setItems(array $items = null)
    {
        return $this;
    }
}
