<?php
/**
 * PixelSetup
 *
 * @copyright Copyright © 30 Demo. All rights reserved.
 * @author    uvarov.vova@gmail.com
 */

namespace Store\Test\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;

/**
 * @codeCoverageIgnore
 */
class PixelSetup extends EavSetup
{
    /**
     * Entity type for Pixel EAV attributes
     */
    const ENTITY_TYPE_CODE = 'store_pixel';

    /**
     * Retrieve Entity Attributes
     *
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function getAttributes()
    {
        $attributes = [];

        $attributes['identifier'] = [
            'type' => 'static',
            'label' => 'identifier',
            'input' => 'text',
            'required' => true,
            'sort_order' => 10,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'General',
            'validate_rules' => 'a:2:{s:15:"max_text_length";i:100;s:15:"min_text_length";i:1;}'
        ];

        $attributes['pixelimage'] = [
            'type' => 'varchar',
            'label' => 'Pixelimage',
            'input' => 'image',
            'backend' => 'Store\Test\Model\Pixel\Attribute\Backend\Pixelimage',
            'required' => false,
            'sort_order' => 99,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'General',
        ];

        // Add your entity attributes here... For example:
//        $attributes['is_active'] = [
//            'type' => 'int',
//            'label' => 'Is Active',
//            'input' => 'select',
//            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
//            'sort_order' => 10,
//            'global' => ScopedAttributeInterface::SCOPE_STORE,
//            'group' => 'General',
//        ];

        return $attributes;
    }

    /**
     * Retrieve default entities: pixel
     *
     * @return array
     */
    public function getDefaultEntities()
    {
        $entities = [
            self::ENTITY_TYPE_CODE => [
                'entity_model' => 'Store\Test\Model\ResourceModel\Pixel',
                'attribute_model' => 'Store\Test\Model\ResourceModel\Eav\Attribute',
                'table' => self::ENTITY_TYPE_CODE . '_entity',
                'increment_model' => null,
                'additional_attribute_table' => self::ENTITY_TYPE_CODE . '_eav_attribute',
                'entity_attribute_collection' => 'Store\Test\Model\ResourceModel\Attribute\Collection',
                'attributes' => $this->getAttributes()
            ]
        ];

        return $entities;
    }
}
