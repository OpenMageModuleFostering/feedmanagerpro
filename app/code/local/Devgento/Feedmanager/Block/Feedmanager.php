<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Block_Feedmanager extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getFeedmanager()     
     { 
        if (!$this->hasData('feedmanager')) {
            $this->setData('feedmanager', Mage::registry('feedmanager'));
        }
        return $this->getData('feedmanager');
        
    }
}