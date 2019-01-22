<?php

namespace Uvarov\Bar\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class UpgradeSchema
 * @package Uvarov\Bar\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
	/**
	 * @param SchemaSetupInterface $setup
	 * @param ModuleContextInterface $context
	 */
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		if (version_compare($context->getVersion(), '1.2.0', '<')) {
			$setup->startSetup();
			$tableItems = $setup->getTable('uvarov_bar_notification');

			$setup->getConnection()->addColumn(
				$tableItems,
				'store_view_id',
				[
					'type' => Table::TYPE_INTEGER,
					'length' => 1,
					'nullable' => true,
					'comment' => 'Store View'
				]
			);

			$setup->endSetup();
		}

		if (version_compare($context->getVersion(), '1.3.0', '<')) {
			$setup->getConnection()->changeColumn(
				$setup->getTable('uvarov_bar_notification'),
				'store_view_id',
				'store_id',
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'length' => 255,
					'comment' => 'Full name of customer'
				]
			);
			$setup->endSetup();
		}
	}
}