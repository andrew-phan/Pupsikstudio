<?php
/**
 * Admihtml Profiler Controller
 *
 * @author Fabrizio Branca
 * @since 2014-08-15
 */
class Aoe_Profiler_Adminhtml_ProfilerController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Load layout, set active menu and breadcrumbs
     *
     * @return $this
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('system/aoe_profiler')
            ->_addBreadcrumb(Mage::helper('aoe_profiler')->__('System'),
                Mage::helper('aoe_profiler')->__('System'))
            ->_addBreadcrumb(Mage::helper('aoe_profiler')->__('AOE Profiler'),
                Mage::helper('aoe_profiler')->__('AOE Profiler'));
        return $this;
    }

    /**
     * Init stack instance object and set it to registry
     *
     * @return Aoe_Profiler_Model_Run|false
     */
    protected function _initStackInstance()
    {
        $this->_title($this->__('System'))->_title($this->__('AOE Profiler'));

        $stackId = $this->getRequest()->getParam('stack_id', null);

        if ($stackId) {
            $stackInstance = Mage::getModel('aoe_profiler/run'); /* @var $stackInstance Aoe_Profiler_Model_Run */
            $stackInstance->load($stackId);
            if (!$stackInstance->getId()) {
                $this->_getSession()->addError(Mage::helper('aoe_profiler')->__('No data found with this id.'));
                return false;
            }
            Mage::register('current_stack_instance', $stackInstance);
            return $stackInstance;
        }
        return false;
    }

    /**
     * Layout Grid
     */
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('AOE Profiler'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Layout Grid
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Edit layout instance action
     *
     */
    public function viewAction()
    {
        $stack = $this->_initStackInstance();
        if (!$stack) {
            $this->_redirect('*/*/');
            return;
        }
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Check is allowed access to action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/aoe_profiler');
    }

}