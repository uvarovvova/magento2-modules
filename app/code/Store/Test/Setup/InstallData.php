<?php
/**
 * InstallData
 *
 * @copyright Copyright © 30 Demo. All rights reserved.
 * @author    uvarov.vova@gmail.com
 */

namespace Store\Test\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Pixel setup factory
     *
     * @var PixelSetupFactory
     */
    protected $pixelSetupFactory;

    /**
     * Init
     *
     * @param PixelSetupFactory $pixelSetupFactory
     */
    public function __construct(PixelSetupFactory $pixelSetupFactory)
    {
        $this->pixelSetupFactory = $pixelSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        /** @var PixelSetup $pixelSetup */
        $pixelSetup = $this->pixelSetupFactory->create(['setup' => $setup]);

        $setup->startSetup();

        $pixelSetup->installEntities();
        $entities = $pixelSetup->getDefaultEntities();
        foreach ($entities as $entityName => $entity) {
            $pixelSetup->addEntityType($entityName, $entity);
        }

        $setup->endSetup();
    }
}
