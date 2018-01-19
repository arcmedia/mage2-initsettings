<?php
/**
 * Ready to Level Up using this neat Upgrade Script
 *
 * ______██████████████
 * -____██▓▓▓▓▓▓▓▓▓ M ▓████
 * -__██▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓██
 * -__██████░░░░██░░██████
 * ██░░░░████░░██░░░░░░░░██
 * ██░░░░████░░░░██░░░░░░██
 * -__████░░░░░░██████████
 * -__██░░░░░░░░░░░░░██
 * _____██░░░░░░░░░██
 * -______██░░░░░░██
 * -____██▓▓████▓▓▓█
 * -_██▓▓▓▓▓▓████▓▓█
 * ██▓▓▓▓▓▓███░░███░
 * -__██░░░░░░███████
 * -____██░░░░███████
 * -______██████████
 * -_____██▓▓▓▓▓▓▓▓▓██
 * -_____█████████████
 */
namespace Arcmedia\InitSettings\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

class UpgradeSchema implements UpgradeSchemaInterface
{
    protected $_resourceConfig;

    /**
     * @var CustomerSetupFactory
     */
    protected $_customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $_attributeSetFactory;

    public function __construct(
        \Magento\Config\Model\ResourceModel\Config $_resourceConfig,
        CustomerSetupFactory $_customerSetupFactory
    ) {
        $this->_resourceConfig       = $_resourceConfig;
        $this->_customerSetupFactory = $_customerSetupFactory;
    }

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //Handle all Versions

        //Upgrade to 1.0.0
        // TODO: run this after data migration
        if (version_compare($context->getVersion(), '1.0.0') < 0) {
            $arrConfigs = [
                'general/country/default' => 'CH',
                'general/country/allow' => 'CH,DE,AT,FL,IT,LU',
                'general/store_information/name' => '',
                'general/store_information/country_id' => 'CH',
                'general/region/display_all' => '0',
                'general/region/state_required' => 'US',
                'general/locale/code' => 'de_CH',
                'general/locale/timezone' => 'Europe/Zurich',
                'general/locale/weight_unit' => 'kgs',
                'general/locale/firstday' => '1',
                'general/locale/weekend' => '0,6',
                'design/header/welcome' => '',
                'design/header/logo_alt' => '',
                'design/head/default_title' => '',
                'design/head/default_description' => '',
                'design/head/default_keywords' => '',
                'design/footer/copyright' => 'Copyright © 2018',
				'advanced/modules_disable_output/Magento_AdminNotification' => '1',
                'design/search_engine_robots/custom_instructions' => 'User-agent: *
Disallow: /index.php/
Disallow: /*?
Disallow: /checkout/
Disallow: /app/
Disallow: /lib/
Disallow: /*.php$
Disallow: /pkginfo/
Disallow: /report/
Disallow: /var/
Disallow: /catalog/
Disallow: /customer/
Disallow: /sendfriend/
Disallow: /review/
Disallow: /*SID=',
                'currency/options/base' => 'CHF',
                'currency/options/default' => 'CHF',
                'currency/options/allow' => 'CHF',
                'customer/address/prefix_show' => 'req',
                'customer/address/prefix_options' => 'Frau;Herr',
				'customer/password/lockout_failures' => 0,
                'customer/password/min_time_between_password_reset_requests' => 0,
                'customer/password/max_number_password_reset_requests' => 0,
                'catalog/frontend/default_sort_by' => 'name',
                'wishlist/general/active' => '0',
                'tax/defaults/country' => 'CH',
                'shipping/origin/country_id' => 'CH',
                'web/seo/use_rewrites' => 1,
                'admin/security/session_lifetime' => '86400',
                'admin/security/password_is_forced' => 0, //Magento has a nasty habbit of locking out users (real bug)
				'admin/security/lockout_threshold' => 10,
                'admin/security/lockout_failures' => 10,
                'admin/security/admin_account_sharing' => 1,
                'admin/security/password_reset_protection_type' => 0,
            ];

            $arrRemove = array_keys($arrConfigs);
            $sqlClean = "DELETE FROM `core_config_data` "
                . "WHERE `scope_id` = '0' "
                . "AND `path` IN ('".implode("','", $arrRemove)."')";

            foreach($arrConfigs as $key => $val){
                $this->_resourceConfig->saveConfig($key, $val, 'default', 0);
            }
        }

        
        $setup->endSetup();
    }//END upgrade($)
}