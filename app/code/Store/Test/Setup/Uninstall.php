<?php

/**
 * Uninstall.php
 *
 * @copyright Copyright © 30 Demo. All rights reserved.
 * @author    uvarov.vova@gmail.com
 */
namespace Store\Test\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    /**
     * @var array
     */
    protected $tablesToUninstall = [
        PixelSetup::ENTITY_TYPE_CODE . '_entity',
        PixelSetup::ENTITY_TYPE_CODE . '_eav_attribute',
        PixelSetup::ENTITY_TYPE_CODE . '_entity_datetime',
        PixelSetup::ENTITY_TYPE_CODE . '_entity_decimal',
        PixelSetup::ENTITY_TYPE_CODE . '_entity_int',
        PixelSetup::ENTITY_TYPE_CODE . '_entity_text',
        PixelSetup::ENTITY_TYPE_CODE . '_entity_varchar'
    ];

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();

        foreach ($this->tablesToUninstall as $table) {
            if ($setup->tableExists($table)) {
                $setup->getConnection()->dropTable($setup->getTable($table));
            }
        }

        $setup->endSetup();
    }
}
