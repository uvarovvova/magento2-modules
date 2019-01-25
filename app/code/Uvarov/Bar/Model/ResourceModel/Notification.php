<?php

namespace Uvarov\Bar\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Notification
 * @package Uvarov\Bar\Model\ResourceModel
 */
class Notification extends AbstractDb
{

	/**
	 * Store model
	 *
	 * @var null|Store
	 */
	protected $_store = null;

	/**
	 * Store manager
	 *
	 * @var StoreManagerInterface
	 */
	protected $_storeManager;

	public function __construct(Context $context, StoreManagerInterface $storeManager)
	{
		parent::__construct($context);
		$this->_storeManager = $storeManager;
	}


	/**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('uvarov_bar_notification', 'entity_id');
    }


    protected function _getLoadSelect($field, $value, $object)
    {
	    $select = parent::_getLoadSelect($field, $value, $object);

	    if ($object->getStoreId()) {
		    $storeIds = [
			    Store::DEFAULT_STORE_ID,
			    (int)$object->getStoreId(),
		    ];
		    $select->join(
			    ['cms_page_store' => $this->getTable('cms_page_store')],
			    $this->getMainTable() . '.' . $linkField . ' = cms_page_store.' . $linkField,
			    []
		    )
			    ->where('is_active = ?', 1)
			    ->where('cms_page_store.store_id IN (?)', $storeIds)
			    ->order('cms_page_store.store_id DESC')
			    ->limit(1);
	    }

	    return $select;

    }

	/**
	 * Set store model
	 *
	 * @param Store $store
	 * @return $this
	 */
	public function setStore($store)
	{
		$this->_store = $store;
		return $this;
	}

	/**
	 * Retrieve store model
	 *
	 * @return Store
	 */
	public function getStore()
	{
		return $this->_storeManager->getStore($this->_store);
	}
}
