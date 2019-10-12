<?php

namespace Smartosc\Article\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
/**
 * Class InstallData
 * @package Smartosc\Article\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $sampleTemplates = [
            'name'         => 'article',
            'url_key'      => 'article_url',
            'post_content' => 'THIS IS ARTICLE CONTENT',
            'tags'         => 'just a tag'
        ];
        $setup->getConnection()->insert($setup->getTable('sm_article'), $sampleTemplates);
        $installer->endSetup();
    }
}