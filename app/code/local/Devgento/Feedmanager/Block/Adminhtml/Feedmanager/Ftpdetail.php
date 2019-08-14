<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Block_Adminhtml_Feedmanager_Ftpdetail extends Mage_Adminhtml_Block_Widget
{
	public $FeedData;
	public $FeedId;
	public $FtpData;
	public $FtpId = "";
	
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('feedmanager/ftpdetail.phtml');
		$this->setId('ftpdetail');
		$this->FeedId = $this->getRequest()->getParam('id');
		$this->FeedData = Mage::getModel("feedmanager/feedmanager")->load($this->FeedId)->getData();
		$this->FtpData = Mage::getModel("feedmanager/feedmanagerftpdetail")->getCollection()
			->addFieldToFilter('feed_id', array('eq'=>$this->FeedId));
		if($this->FtpData->getItems())
		{
			foreach($this->FtpData->getItems() as $_k=>$_v)
			{
				$this->FtpData = $_v->getData();
				$this->FtpId = $_v->getId();
			}
		}
	}
	
	protected function _prepareLayout()
	{
		$this->setChild('back_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Back'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/mapping',array("id"=>$this->FeedId))."')",
					'class' => 'back'
			))
		);
		
		$this->setChild('save_ftp_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Save Ftp Detail'),
					'onclick'   => 'ftpForm.submit()',
					'class' => 'save'
			))
		);
		
		$this->setChild('create_feed_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Create Feed'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/createfeed',array("id"=>$this->FeedId))."')",
					'class' => 'save'
			))
		);
		
		$this->setChild('create_feed_upload_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Create Feed and Upload'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/createfeed',array("id"=>$this->FeedId,"upload"=>1))."')",
					'class' => 'save'
			))
		);
		
		$this->setChild('delete_ftp_detail',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label'     => Mage::helper('feedmanager')->__('Delete FTP'),
					'onclick'   => "setLocation('".$this->getUrl('*/*/deleteftpdetail',array("id"=>$this->FeedId))."')",
					'class' => 'delete'
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
		$header = Mage::helper('feedmanager')->__('Feed Manager Ftp Detail - ').$this->FeedData['site_name']."'";
		return $header;
	}
	
	public function getSaveFtpUrl()
	{
		return $this->getUrl("*/*/saveftpdetail",array("id"=>$this->FeedId));
	}
	
	public function getSaveFtpButtonHtml()
	{
		return $this->getChildHtml("save_ftp_button");
	}
	
	public function getCreateFeedButtonHtml()
	{
		return $this->getChildHtml("create_feed_button");
	}
	
	public function getCreateFeedUploadButtonHtml()
	{
		return $this->getChildHtml("create_feed_upload_button");
	}
	
	public function getdeleteFtpDetailButtonHtml()
	{
		return $this->getChildHtml("delete_ftp_detail");
	}
}   