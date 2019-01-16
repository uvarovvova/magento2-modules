<?php

namespace Uvarov\Bar\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Notification
 * @package Uvarov\Bar\Model\ResourceModel
 */
class Notification extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('uvarov_bar_notification', 'entity_id');
    }
}
