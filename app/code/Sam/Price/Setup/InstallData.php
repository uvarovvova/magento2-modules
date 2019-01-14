<?php
namespace Sam\Price\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;


class InstallData implements InstallDataInterface {

	/**
	 * Install data
	 *
	 * @param ModuleDataSetupInterface $setup
	 * @param ModuleContextInterface $context
	 */
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		if (version_compare($context->getVersion(), '1.0.0', '<')) {
			$data = [
				[
					'name' => 'First Name Demo',
					'email' => 'demo@demo.com',
					'sku' => 'b-3r3r',
					'status' => 1
				],
				[
					'name' => 'Second Name ',
					'email' => 'second@demo.com',
					'sku' => 'b2-546565',
					'status' => 2
				]
			];

			foreach ($data as $datum) {
				$setup->getConnection()
					->insertForce($setup->getTable('request_price'), $datum);
			}
		}
	}
}