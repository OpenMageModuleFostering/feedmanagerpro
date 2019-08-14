<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Model_Storefields extends Varien_Object
{
    static public function getStorefieldsArray()
    {
    	$Storefield = array();
    	$Storefield["product_id"] = "Product Id"; 
    	$Storefield["is_in_stock"] = "Is In Stock"; 
    	$Storefield["min_qty"] = "Min Qty"; 
    	$Storefield["qty"] = "Qty"; 
    	$Storefield["image"] = "Image"; 
    	$Storefield["url_path"] = "URL Path";

		$EntityTypeId = Mage::getModel('catalog/product')->getResource()->getEntityType()->getId();
		$AttributeSet = Mage::getModel('catalog/product_attribute_set_api')->items();
		
		foreach($AttributeSet as $set)
		{     
			$attributes = Mage::getModel('catalog/product')->getResource()
				->loadAllAttributes()
				->getSortedAttributes($set['set_id']);           
			foreach ($attributes as $attribute)
			{
 				$_code = $attribute->getAttributeCode();
				if($attribute->getFrontendLabel() != "")
 					$Storefield[$_code] = $attribute->getFrontendLabel();
			}
		}
		asort($Storefield);
		unset($Storefield['tier_price']);
		return $Storefield;
    }
}