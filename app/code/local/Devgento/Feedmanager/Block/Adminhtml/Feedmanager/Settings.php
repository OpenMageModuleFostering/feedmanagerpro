<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Block_Adminhtml_Feedmanager_Settings extends Mage_Adminhtml_Block_Widget
{
	public $IsSettings;
	public $FeedData;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('feedmanager/settings.phtml');
		$this->setId('settings');
		
		$SettingsDataCollection = Mage::getModel("feedmanager/feedmanagersettings")->getCollection()
			->addFieldToFilter("feed_id",$this->getRequest()->getParam('id'));
		
		foreach($SettingsDataCollection->getItems() as $_key=>$_settings)
		{
			$this->IsSettings = $_settings;
		}
		$this->FeedData = Mage::getModel("feedmanager/feedmanager")->load($this->getRequest()->getParam('id'))->getData();
	}
	
	protected function _prepareLayout()
	{
		$this->setChild('back_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Back'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/edit',array("id"=>$this->getRequest()->getParam('id')))."')",
					'class' => 'back'
			))
		);
		
		$this->setChild('save_settings_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Save Settings'),
					'onclick'   => 'settingsForm.submit()',
					'class' => 'save'
			))
		);
		
		$this->setChild('mapping_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Edit Mapping'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/mapping',array("id"=>$this->getRequest()->getParam('id')))."')",
					'class' => 'save'
			))
		);
		return parent::_prepareLayout();
	}
	
	public function getBackButtonHtml()
	{
		return $this->getChildHtml('back_button');
	}
	
	public function getHeader()
	{
		$header = Mage::helper('feedmanager')->__('Feed Manager Settings - ').$this->FeedData['site_name']."'";
		return $header;
	}
	
	public function getSaveSettingsUrl()
	{
		return $this->getUrl('*/*/savesettings', array("id"=>$this->getRequest()->getParam('id')));
	}
	
	public function getSaveSettingsButtonHtml()
	{
		return $this->getChildHtml('save_settings_button');
	}
	
	public function getMapingButtonHtml()
	{
		return $this->getChildHtml('mapping_button');
	}
}