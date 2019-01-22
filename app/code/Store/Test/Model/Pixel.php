<?php

/**
 * Pixel.php
 *
 * @copyright Copyright © 30 Demo. All rights reserved.
 * @author    uvarov.vova@gmail.com
 */

namespace Store\Test\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;
use Store\Test\Model\Pixel\Attribute\Backend\ImageAbstract;
use Store\Test\Model\Pixel\Attribute\Backend\ImageFactory;

class Pixel extends AbstractModel implements IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'store_test_pixel';
    /**
     * @var string
     */
    protected $_cacheTag = 'store_test_pixel';
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'store_test_pixel';
    /**
     * @var ImageFactory
     */
    private $imageFactory;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Store\Test\Model\ResourceModel\Pixel');
    }

    public function __construct(
        ImageFactory $imageFactory,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->imageFactory = $imageFactory;
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
     * Save from collection data
     *
     * @param array $data
     * @return $this|bool
     */
    public function saveCollection(array $data)
    {
        if (isset($data[$this->getId()])) {
            $this->addData($data[$this->getId()]);
            $this->getResource()->save($this);
        }
        return $this;
    }

    public function getImageValueForForm(string $imageAttrCode): array
    {
        /** @var ImageAbstract $image */
        $image = $this->imageFactory->create($imageAttrCode);
        return $image->getFileValueForForm($this);
    }

    /**
     * @param string $imageAttrCode
     * @return mixed
     */
    public function getImageSrc(string $imageAttrCode)
    {
        /** @var ImageAbstract $image */
        $image = $this->imageFactory->create($imageAttrCode);
        return $image->getFileInfo($this)->getUrl();
    }

}
