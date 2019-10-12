<?php

namespace Mageplaza\HelloWorld\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.0') < 0) {
            $setup->startSetup();
            $setup->getConnection()->addColumn(
                $setup->getTable('sm_article'),
                'adddress',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => 255,
                        'nullable' => true,
                        'default' => 'hello madafaka',
                        'comment' => 'Test create column'
                    ]
                );
            $setup->endSetup();
        }
    }
}
