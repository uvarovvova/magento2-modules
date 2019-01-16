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
		$setup->startSetup();

		/**
		 * Create table 'uvarov_bar_notification'
		 */
		$table = $setup->getConnection()->newTable(
			$setup->getTable('uvarov_bar_notification')
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
			->addIndex(
				$setup->getIdxName(
					$setup->getTable('uvarov_bar_notification'),
					['title'],
					AdapterInterface::INDEX_TYPE_FULLTEXT),
				['title'],
				['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
			)->setComment(
				'Notification Table'
			);

		$setup->getConnection()->createTable($table);

		$setup->endSetup();
	}
}
