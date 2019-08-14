<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class  Devgento_Feedmanager_Model_Feedmanagerversion extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('feedmanager/feedmanagerversion');
    }
    
    public function getVersion()
    {
    	$this->load(1);
    	return $this->getVer();
    }
}