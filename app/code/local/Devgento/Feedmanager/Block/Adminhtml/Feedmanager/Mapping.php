<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Block_Adminhtml_Feedmanager_Mapping extends Mage_Adminhtml_Block_Widget
{
	public $FeedData;
	public $FeedId;
	public $MappingData;
	public $StoreFields;
	public $MappedStoreFields = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('feedmanager/mapping.phtml');
		$this->setId('mapping');
		$this->FeedId = $this->getRequest()->getParam('id');
		$this->FeedData = Mage::getModel("feedmanager/feedmanager")->load($this->FeedId)->getData();
		$this->MappingData = Mage::getModel("feedmanager/feedmanagermapping")->getCollection()
			->addFieldToFilter('feed_id', array('eq'=>$this->FeedId));
		$this->MappingData->setOrder('order_by','ASC');
		foreach($this->MappingData->getItems() as $_value)
		{
			$Fields = $_value->getdata();
			$this->MappedStoreFields['data'][$Fields['data']] = $Fields['data'];
			$this->MappedStoreFields['data1'][$Fields['data1']] = $Fields['data1'];
		}
		$this->StoreFields = Mage::getModel('feedmanager/storefields')->getStorefieldsArray();
	}
	
	protected function _prepareLayout()
	{
		$this->setChild('back_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Back'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/settings',array("id"=>$this->FeedId))."')",
					'class' => 'back'
			))
		);
		
		$this->setChild('save_mapping_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Save Mapping'),
					'onclick'   => 'mappingForm.submit()',
					'class' => 'save'
			))
		);
		
		$this->setChild('delete_mapping_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Delete Selected Row'),
					'onclick'   => 'delete_row()',
					'class' => 'delete'
			))
		);
		
		$this->setChild('delete_mapping_button_icon',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Delete'),
					'id'=>"delete_selected_row_button",
					'class' => 'delete delete-option'
			))
		);
		
		$this->setChild('create_row_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Add Row'),
					'id'=>"create_new_row_button",
					'class' => 'add'
			))
		);
		
		$this->setChild('ftp_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Edit FTP Detail'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/ftpdetail',array("id"=>$this->getRequest()->getParam('id')))."')",
					'class' => 'save'
			))
		);
		
		$this->setChild('import_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Import Mapping'),
					'onclick'   => 'mappingimportexportForm.submit()',
					'class' => 'save'
			))
		);
		
		$this->setChild('export_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Export Mapping'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/exportmapping',array("id"=>$this->getRequest()->getParam('id')))."')",
					'class' => 'save'
			))
		);
		return parent::_prepareLayout();
	}
	
	public function addCss($name, $params="")
	{
		$layout = Mage::getSingleton('core/layout');
		$block = $layout->createBlock('page/html_head');
		$A = $block->addItem('skin_css', $name, $params);
		return $this;
	}
	
	public function addItem($type, $name, $params=null, $if=null, $cond=null)
	{
		if ($type==='skin_css' && empty($params)) {
			$params = 'media="all"';
		}
		
		$this->_data['items'][$type.'/'.$name] = array(
			'type'   => $type,
			'name'   => $name,
			'params' => $params,
			'if'     => $if,
			'cond'   => $cond,
		);
		return $this;
	}
	
	public function getBackButtonHtml()
	{
		return $this->getChildHtml('back_button');
	}
	
	public function getHeader()
	{
		$header = Mage::helper('feedmanager')->__('Feed Manager Mapping - ').$this->FeedData['site_name']."'";
		return $header;
	}
	
	public function getSaveMappingButtonHtml()
	{
		return $this->getChildHtml('save_mapping_button');
	}
	
	public function getSaveMappingUrl()
	{
		return $this->getUrl('*/*/savemapping', array("id"=>$this->FeedId));
	}
	
	public function getDeleteButtonHtml()
	{
		return $this->getChildHtml('delete_mapping_button');
	}
	
	public function getDeleteButtonHtmlIcon()
	{
		return $this->getChildHtml('delete_mapping_button_icon');
	}
	
	public function getCreateButtonHtml()
	{
		return $this->getChildHtml('create_row_button');
	}
	
	public function getFTPMappingButtonHtml()
	{
		return $this->getChildHtml('ftp_button');
	}
	
	public function getImportMappingUrl()
	{
		return $this->getUrl("*/*/importmapping", array("id"=>$this->FeedId));
	}
	
	public function getMappingImportButtonHtml()
	{
		return $this->getChildHtml('import_button');
	}
	
	public function getMappingExportButtonHtml()
	{
		return $this->getChildHtml('export_button');
	}
}