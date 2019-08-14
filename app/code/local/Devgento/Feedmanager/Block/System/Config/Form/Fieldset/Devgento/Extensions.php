<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Block_System_Config_Form_Fieldset_Devgento_Extensions extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
	protected $_dummyElement;
	protected $_fieldRenderer;
	protected $_values;
	
	public function render(Varien_Data_Form_Element_Abstract $element)
	{
		$html = $this->_getHeaderHtml($element);
		$modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());
		sort($modules);
		
		foreach ($modules as $moduleName) {
			if (strstr($moduleName,'Devgento_') === false) {
				continue;
			}
			
			if($moduleName == 'Devgento_Adminhtml'){
				continue;
			}
			
			$html.= $this->_getFieldHtml($element, $moduleName);
		}
		$html .= $this->_getFooterHtml($element);
		return $html;
	}
	
	protected function _getDummyElement()
	{
		if (empty($this->_dummyElement)) {
			$this->_dummyElement = new Varien_Object(array('show_in_default'=>1, 'show_in_website'=>1));
		}
		return $this->_dummyElement;
	}
	
	protected function _getFieldRenderer()
	{
		if (empty($this->_fieldRenderer)) {
			$this->_fieldRenderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');
		}
		return $this->_fieldRenderer;
	}
	
	protected function _getFieldHtml($fieldset, $moduleName)
	{
		$configData = $this->getConfigData();
		$path = 'advanced/modules_disable_output/'.$moduleName; //TODO: move as property of form
		$data = isset($configData[$path]) ? $configData[$path] : array();
		
		$e = $this->_getDummyElement();
		
		$moduleKey = substr($moduleName, strpos($moduleName,'_')+1);
		
		$ver = (Mage::getConfig()->getModuleConfig($moduleName)->version);
		$url = Mage::getConfig()->getModuleConfig($moduleName)->url;
		$id = $moduleName;
		$moduleName = Mage::getConfig()->getModuleConfig($moduleName)->modulename;
		
		$hasUpdate = false;
		
		$moduleName = '<a href="'.$url.'" target="_blank" title="'.$moduleName.'">'.$moduleName."</a>";
		$update = "";
		$moduleName ="$update $moduleName";
		if($ver) {
			$field = $fieldset->addField($id, 'label',
				array(
					'name'          => 'devgento',
					'label'         => $moduleName,
					'value'         => 'Current Version '.$ver
			))->setRenderer($this->_getFieldRenderer());
			return $field->toHtml();
		}
		return '';
	}
}