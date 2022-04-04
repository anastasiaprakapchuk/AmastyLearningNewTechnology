<?php

namespace Amasty\AnastasiaModule\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table=$setup->getConnection()
            ->newTable($setup->getTable('amasty_anastasia_blacklist'))
            ->addColumn(
                'blacklist_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity'=>true,
                    'unsigned'=>true,
                    'nullable'=>false,
                    'primary'=>true
                ],
                'Blacklist ID'
            )
            ->addColumn(
                'sku',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable'=>false,
                    'default'=>''
                ],
                'Blacklist Sku'
            )
            ->addColumn(
                'qty',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                20,
                [
                    'nullable'=>false,
                    'default'=>0,
                    'unsigned'=>true,
                ],
                'Blacklist Qty'
            )
            ->setComment('Blacklist Table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
