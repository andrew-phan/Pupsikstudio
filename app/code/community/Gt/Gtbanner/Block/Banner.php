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
 * @category    Gt
 * @package     Gt_Gtbanner
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Base Banner Block
 *
 * @category   Gt
 * @package    Gt_Gtbanner
 * @author     Gentotech <http://www.gentotech.com/>
 */
class Gt_Gtbanner_Block_Banner extends Mage_Core_Block_Template {
    protected $_position = null;
    protected $_isActive = 1;
    protected $_collection;

    protected function _getCollection($position = null) {
        if ($this->_collection) {
            return $this->_collection;
        }

        $storeId = Mage::app()->getStore()->getId();
        $this->_collection = Mage::getModel('gtbanner/banner')->getCollection()
                ->addEnableFilter($this->_isActive);
        if (!Mage::app()->isSingleStoreMode()) {
            $this->_collection->addStoreFilter($storeId);
        }

        if (Mage::registry('current_category')) {
            $_categoryId = Mage::registry('current_category')->getId();
            $this->_collection->addCategoryFilter($_categoryId);
        } elseif (Mage::app()->getFrontController()->getRequest()->getRouteName() == 'cms') {
            $_pageId = Mage::getBlockSingleton('cms/page')->getPage()->getPageId();
            $this->_collection->addPageFilter($_pageId);
        }

        if ($position) {
            $this->_collection->addPositionFilter($position);
        } elseif ($this->_position) {
            $this->_collection->addPositionFilter($this->_position);
        }
        return $this->_collection;
    }
}