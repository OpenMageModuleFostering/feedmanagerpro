<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Model_Mysql4_Feedmanager extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('feedmanager/feedmanager', 'feedmanager_id');
    }
}