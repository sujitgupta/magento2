<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Mage_Wishlist
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mage_Wishlist_Block_AbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mage_Wishlist_Block_Abstract
     */
    protected $_block;

    protected $_blockInjections = array(
        'Mage_Core_Controller_Request_Http',
        'Mage_Core_Model_Layout',
        'Mage_Core_Model_Event_Manager',
        'Mage_Core_Model_Url',
        'Mage_Core_Model_Translate',
        'Mage_Core_Model_Cache',
        'Mage_Core_Model_Design_Package',
        'Mage_Core_Model_Session',
        'Mage_Core_Model_Store_Config',
        'Mage_Core_Controller_Varien_Front',
        'Mage_Core_Model_Factory_Helper',
        'Mage_Core_Model_Dir',
        'Mage_Core_Model_Logger',
        'Magento_Filesystem',
    );

    protected function setUp()
    {
        $this->_block = $this->getMockForAbstractClass('Mage_Wishlist_Block_Abstract',
            $this->_prepareConstructorArguments());
    }

    protected function tearDown()
    {
        $this->_block = null;
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDataFixture Mage/Catalog/_files/product_with_image.php
     * @magentoDataFixture Mage/Core/_files/frontend_default_theme.php
     */
    public function testImage()
    {
        Mage::getDesign()->setArea(Mage_Core_Model_App_Area::AREA_FRONTEND)->setDefaultDesignTheme();
        $product = Mage::getModel('Mage_Catalog_Model_Product');
        $product->load(1);

        $size = $this->_block->getImageSize();
        $this->assertGreaterThan(1, $size);
        $this->assertContains('/'.$size, $this->_block->getImageUrl($product));
        $this->assertStringEndsWith('magento_image.jpg', $this->_block->getImageUrl($product));
    }

    /**
     * List of block constructor arguments
     *
     * @return array
     */
    protected function _prepareConstructorArguments()
    {
        $arguments = array();
        foreach ($this->_blockInjections as $injectionClass) {
            $arguments[] = Mage::getObjectManager()->get($injectionClass);
        }
        return $arguments;
    }
}

