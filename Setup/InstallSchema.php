<?php
namespace Arcmedia\InitSettings\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(
            SchemaSetupInterface $setup, 
            ModuleContextInterface $context) 
    {
        //No updates in initial file, I'm just not such a fan of a seperate file
    }
    
    
}