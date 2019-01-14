<?php

namespace Sam\Price\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();
		$tableName = $installer->getTable('request_price');

		if (!$installer->tableExists('request_price')) {
			$table = $installer->getConnection()
				->newTable($tableName)
				->addColumn(
					'entity_id',
					Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'unsigned' => true,
						'nullable' => false,
						'primary' => true
					],
					'Entity Id'
				)
				->addColumn(
					'name',
					Table::TYPE_TEXT,
					64,
					['nullable' => false],
					'User Name'
				)
				->addColumn(
					'email',
					Table::TYPE_TEXT,
					64,
					['nullable' => false],
					'Email'
				)
				->addColumn(
					'sku',
					Table::TYPE_TEXT,
					64,
					['nullable' => false],
					'Product Sku'
				)
				->addColumn(
					'comment',
					Table::TYPE_TEXT,
					255,
					['nullable' => true],
					'Comment'
				)
				->addColumn(
					'status',
					Table::TYPE_INTEGER,
					null,
					['nullable' => false, 'default' => 0],
					'Status'
				)
				->addColumn(
					'created_at',
					Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default'  => Table::TIMESTAMP_INIT_UPDATE],
					'Created at'
				);
			$installer->getConnection()->createTable($table);
		}
		$installer->endSetup();
	}
}