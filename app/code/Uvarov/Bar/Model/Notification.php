<?php

namespace Uvarov\Bar\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Uvarov\Bar\Model\ResourceModel\Notification as NotificationResource;

/**
 * Class Notification
 * @package Uvarov\Bar\Model
 */
class Notification extends AbstractModel implements IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'uvarov_bar_notification';

    /**
     * @var string
     */
    protected $_cacheTag = 'uvarov_bar_notification';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'uvarov_bar_notification';

	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 0;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(NotificationResource::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

	/**
	 * @param array $data
	 * @return $this
	 * @throws \Exception
	 * @throws \Magento\Framework\Exception\AlreadyExistsException
	 */
    public function saveCollection(array $data)
    {
        if (isset($data[$this->getId()])) {
            $this->addData($data[$this->getId()]);
            $this->getResource()->save($this);
        }
        return $this;
    }

	/**
	 * @return array
	 */
	public function getStatuses()
	{
		return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
	}
}
