<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

class Devgento_Feedmanager_Block_Adminhtml_Feedmanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('feedmanagerGrid');
      $this->setDefaultSort('feedmanager_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('feedmanager/feedmanager')->getCollection();
      if($this->getRequest()->getParam("store") != "")
      {
      	$store = $this->getRequest()->getParam("store");
      	$collection->addFieldToFilter("store",$store);
      }
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      
      $this->addColumn('feedmanager_id', array(
          'header'    => Mage::helper('feedmanager')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'feedmanager_id',
      ));

      $this->addColumn('site_name', array(
          'header'    => Mage::helper('feedmanager')->__('Site Name'),
          'align'     =>'left',
          'index'     => 'site_name',
      ));

      $this->addColumn('generated_date', array(
          'header'    => Mage::helper('feedmanager')->__('Feed Generated Date'),
          'align'     =>'left',
          'type'    =>'datetime',
          'width'     => '200px',
          'index'     => 'generated_date',
      ));

		$this->addColumn('download_feed',
      	array(
      		'header'    =>  Mage::helper('feedmanager')->__('Download Feed'),
      		'width'     => '100',
      		'type'      => 'action',
      		'getter'    => 'getId',
      		'actions'   => array(
      			array(
      				'caption'   => Mage::helper('feedmanager')->__('Download Feed'),
      				'url'       => array('base'=> '*/*/exportfeed'),
      				'field'     => 'id'
      			),
      		),
      		'filter'    => false,
      		'sortable'  => false,
      		'index'     => 'stores',
      		'is_system' => true,
      ));
      
      if (!Mage::app()->isSingleStoreMode()) {
      	$this->addColumn('websites',
      		array(
      			'header'=> Mage::helper('feedmanager')->__('Websites'),
      			'width' => '100px',
      			'sortable'  => false,
      			'index'     => 'websites',
      			'type'      => 'options',
      			'options'   => Mage::getModel('core/website')->getCollection()->toOptionHash(),
      		));
      }
        
      $this->addColumn('action',
      	array(
      		'header'    =>  Mage::helper('feedmanager')->__('Action'),
      		'width'     => '100',
      		'type'      => 'action',
      		'getter'    => 'getId',
      		'actions'   => array(
      			array(
      				'caption'   => Mage::helper('feedmanager')->__('Edit'),
      				'url'       => array('base'=> '*/*/edit'),
      				'field'     => 'id'
      			),
      			array(
	      			'caption'   => Mage::helper('feedmanager')->__('Generate Feed'),
   	   			'url'       => array('base'=> '*/*/createfeedindex'),
      				'field'     => 'id'
      			)
      		),
      		'filter'    => false,
      		'sortable'  => false,
      		'index'     => 'stores',
      		'is_system' => true,
      ));
		
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('feedmanager_id');
        $this->getMassactionBlock()->setFormFieldName('feedmanager');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('feedmanager')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('feedmanager')->__('Are you sure?')
        ));

        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}