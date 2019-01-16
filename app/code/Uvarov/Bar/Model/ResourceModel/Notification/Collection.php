<?php

namespace Uvarov\Bar\Model\ResourceModel\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Uvarov\Bar\Model\Notification;
use Uvarov\Bar\Model\ResourceModel\Notification as ResourceNotification;

/**
 * Class Collection
 * @package Uvarov\Bar\Model\ResourceModel\Notification
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Notification::class, ResourceNotification::class);
    }
}
