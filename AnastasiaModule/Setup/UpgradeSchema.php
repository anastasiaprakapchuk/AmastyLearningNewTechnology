<?php

namespace Amasty\AnastasiaModule\Setup;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('amasty_anastasia_blacklist'),
                'email_body',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'default' => '',
                    'nullable' => false,
                    'comment' => 'Blacklist email body'
                ],
            );
        }
        $setup->endSetup();

    }
}
