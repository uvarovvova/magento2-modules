<?php

namespace Uvarov\Bar\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Class InstallSchema
 * @package Uvarov\Bar\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
	/**
	 * @param SchemaSetupInterface $setup
	 * @param ModuleContextInterface $context
	 * @throws \Zend_Db_Exception
	 */
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();

		/**
		 * Create table 'uvarov_bar_notification'
		 */
		$table = $installer->getConnection()->newTable(
			$installer->getTable('uvarov_bar_notification')
		)
			->addColumn(
				'entity_id',
				Table::TYPE_SMALLINT,
				null,
				['identity' => true, 'nullable' => false, 'primary' => true],
				'Notification ID')
			->addColumn(
				'title',
				Table::TYPE_TEXT,
				50,
				['nullable' => false],
				'Name of the bar')
			->addColumn(
				'content',
				Table::TYPE_TEXT,
				255,
				['nullable' => false],
				'Content of the Info bar')
			->addColumn(
				'background_color',
				Table::TYPE_TEXT,
				11,
				['nullable' => true],
				'Color in #XXXXXX format to set Info bar background')
			->addColumn(
				'status',
				Table::TYPE_BOOLEAN,
				1,
				['nullable' => false],
				'Enabled/Disabled')
			->addColumn(
				'priority',
				Table::TYPE_INTEGER,
				null,
				['nullable' => true],
				'Enabled/Disabled')
			->setComment(
				'Notification Table'
			);
		$installer->getConnection()->createTable($table);


		$table = $installer->getConnection()->newTable(
			$installer->getTable('uvarov_bar_notification_store')
		)->addColumn(
			'entity_id',
			Table::TYPE_SMALLINT,
			null,
			['nullable' => false, 'primary' => true],
			'Notification ID'
		)->addColumn(
			'store_id',
			Table::TYPE_SMALLINT,
			null,
			['unsigned' => true, 'nullable' => false, 'primary' => true],
			'Store ID'
		)->addIndex(
			$installer->getIdxName('uvarov_bar_notification_store', ['store_id']),
			['store_id']
		)->addForeignKey(
			$installer->getFkName('uvarov_bar_notification_store', 'entity_id', 'uvarov_bar_notification', 'entity_id'),
			'entity_id',
			$installer->getTable('uvarov_bar_notification'),
			'entity_id',
			Table::ACTION_CASCADE
		)->addForeignKey(
			$installer->getFkName('uvarov_bar_notification_store', 'store_id', 'store', 'store_id'),
			'store_id',
			$installer->getTable('store'),
			'store_id',
			Table::ACTION_CASCADE
		)->setComment(
			'Store Linkage Table'
		);
		$installer->getConnection()->createTable($table);


		$installer->endSetup();
	}
}
