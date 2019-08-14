<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Block_Adminhtml_Feedmanager_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public $_formdata;
	public $_websaites;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_objectId = 'id';
		$this->_blockGroup = 'feedmanager';
		$this->_controller = 'adminhtml_feedmanager';
		
		$this->_formdata = new Varien_Object();
		if($this->getRequest()->getParam("id"))
			$this->_formdata = Mage::getModel("feedmanager/feedmanager")->load($this->getRequest()->getParam("id"));

		$this->_websites = Mage::getModel('core/website')->getResourceCollection();			
		
		$this->_removeButton("save");
		$this->_removeButton("back");
		$this->_removeButton("reset");
		$this->_removeButton("delete");
		$this->setTemplate('feedmanager/edit.phtml');
	}
	
	public function getHeaderText()
	{
		if( Mage::registry('feedmanager_data') && Mage::registry('feedmanager_data')->getId() ) {
			return Mage::helper('feedmanager')->__("Edit Primary Detail"). Mage::helper('feedmanager')->__(" '".$this->htmlEscape(Mage::registry('feedmanager_data')->getSiteName())."'");
		} else {
			return Mage::helper('feedmanager')->__('Add Primary Detail');
		}
	}
	
	public function getStores($group)
    {
        if (!$group instanceof Mage_Core_Model_Store_Group) {
            $group = Mage::app()->getGroup($group);
        }
        $stores = $group->getStores();
        if ($storeIds = $this->getStoreIds()) {
            foreach ($stores as $storeId => $store) {
                if (!in_array($storeId, $storeIds)) {
                    unset($stores[$storeId]);
                }
            }
        }
        return $stores;
    }
	
	public function getBackButtonHtml()
	{
		return $this->getChildHtml('back_button');
	}
	
	public function getResetButtonHtml()
	{
		return $this->getChildHtml('reset_button');
	}
	
	public function getSaveButtonHtml()
	{
		return $this->getChildHtml('save_button');
	}
	
	public function getDeleteButtonHtml()
	{
		return $this->getChildHtml('delete_button');
	}
}