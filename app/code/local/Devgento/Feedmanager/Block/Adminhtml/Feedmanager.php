<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Block_Adminhtml_Feedmanager extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_feedmanager';
    $this->_blockGroup = 'feedmanager';
    $this_currentversion = Mage::getModel("feedmanager/feedmanagerversion")->getVersion();
    $this->_headerText = Mage::helper('feedmanager')->__('Feed Manager ').$this_currentversion;
    $this->_addButtonLabel = Mage::helper('feedmanager')->__('Add New Site');
    if($this_currentversion != Mage::getConfig()->getNode('feedmanager/version'))
    {
	    $this->_addButton('feedsettigns', array(
				'label'     => Mage::helper('feedmanager')->__('Upgrade Module'),
				'onclick'   => "if(confirm('are you sure to upgrade version ".$this_currentversion." to ".Mage::getConfig()->getNode('feedmanager/version')." ?')){location.href= '".$this->getUrl("*/*/reconfigmod")."';}",
				'class'     => 'delete',
			), -100);
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('feedmanager')->__("You updated the version, please click on 'Upgrade Module' button to make the relavent changes to database."));
	 }
    parent::__construct();

	 $_tableprefix = (string)Mage::getConfig()->getTablePrefix();
	 $write = Mage::getSingleton('core/resource')->getConnection('core_write');

    $CurretnFeed = Mage::getSingleton("core/session")->getCurrentFeed();
    if(!empty($CurretnFeed))
    {
    	foreach($CurretnFeed as $_key=>$_value)
    	{
    		$Data = $_value->getData();
    		unset($Data['feedmanager_id']);
    		$FeedRollback = Mage::getModel("feedmanager/feedmanager");
    		$FeedRollback->setData($Data);
    		$FeedRollback->save();
    		unset($Data); 
    		unset($FeedRollback); 
    	}
    	Mage::getSingleton("core/session")->setCurrentFeed("");
    	
    	$CurretnFeedSettings = Mage::getSingleton("core/session")->getCurrentFeedSettings();
    	if(!empty($CurretnFeedSettings))
    	{
    		foreach($CurretnFeedSettings as $_key=>$_value)
    		{
    			$Data = $_value->getData();
    			unset($Data['feedmanagersettings_id']);
    			$FeedSettingsRollback = Mage::getModel("feedmanager/feedmanagersettings");
    			$FeedSettingsRollback->setData($Data);
    			$FeedSettingsRollback->save();
    			unset($Data);
    			unset($FeedSettingsRollback);
    		}
    		Mage::getSingleton("core/session")->setCurrentFeedSettings("");
    	}
    	$CurretnFeedMapping = Mage::getSingleton("core/session")->getCurrentMapping();
    	if(!empty($CurretnFeedMapping))
    	{
    		foreach($CurretnFeedMapping as $_key=>$_value)
    		{
    			$Data = $_value->getData();
    			unset($Data['feedmanagermapping_id']);
    			$FeedMappingRollback = Mage::getModel("feedmanager/feedmanagermapping");
    			$FeedMappingRollback->setData($Data);
    			$FeedMappingRollback->save();
    			unset($Data);
    			unset($FeedMappingRollback);
    		}
    		Mage::getSingleton("core/session")->setCurrentMapping("");
    	}
    	$CurretnFeedFTP = Mage::getSingleton("core/session")->getCurrentFeedFTP();
    	if(!empty($CurretnFeedFTP))
    	{
    		foreach($CurretnFeedFTP as $_key=>$_value)
    		{
    			$Data = $_value->getData();
    			unset($Data['feedmanagerftpdetail_id']);
    			$FeedFTPRollback = Mage::getModel("feedmanager/feedmanagerftpdetail");
    			$FeedFTPRollback->setData($Data);
    			$FeedFTPRollback->save();
    			unset($Data);
    			unset($FeedFTPRollback);
    		}
    		Mage::getSingleton("core/session")->setCurrentFeedFTP("");
    	}
    	
    	$CurretnFeedSku = Mage::getSingleton("core/session")->getCurrentFeedSKUs();
    	if(!empty($CurretnFeedSku))
    	{
    		$feedcounter = 1;
    		foreach($CurretnFeedSku as $_key=>$_value)
    		{
    			foreach($_value as $_k=>$_v)
    			{
    				if($_v != "")
    				{
    					$sql = "insert into `".$_tableprefix."feedmanagersku`(`feed_id`,`sku`) values('".$feedcounter."','".$_v."') ";
	    				$FeedSku = $write->query($sql);
	    			}
    			}
    			$feedcounter++;
    		}
    		Mage::getSingleton("core/session")->setCurrentFeedSKUs("");
    	}
    }
    $this->setTemplate('feedmanager/feed.phtml');
  }
}