<?php
/*************************************************************
*                          feed_v2.7              			    *
*************************************************************/

$installer = $this;

$installer->startSetup();

$installer->run("

 DROP TABLE IF EXISTS {$this->getTable('feedmanager')};
CREATE TABLE {$this->getTable('feedmanager')} (
  `feedmanager_id` int(11) unsigned NOT NULL auto_increment,
  `site_name` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `format` varchar(255) NOT NULL default '',
  `websites` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `generated_date` varchar(255) NOT NULL default '',
  `schedule_date` date NOT NULL,
  `schedule_flag` tinyint(4) NOT NULL,
  `schedule_time` int(11) NOT NULL,
  `generated_time` int(11) NOT NULL,
  `store_url` int(11) NOT NULL,
  PRIMARY KEY (`feedmanager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 DROP TABLE IF EXISTS {$this->getTable('feedmanagersettings')};
CREATE TABLE {$this->getTable('feedmanagersettings')} (
  `feedmanagersettings_id` int(11) unsigned NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL default '0',
  `export_disabled_products` char(1) default NULL,
  `export_out_stock_products` char(1) default NULL,
  `export_zero_price_products` char(1) default NULL,
  `flag` tinyint(4) NOT NULL default '0' COMMENT '0 - All Products, 1 Consider Only Uploaded SKU, 2 Ignore Uploaded SKU',
  PRIMARY KEY (`feedmanagersettings_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;      



 DROP TABLE IF EXISTS {$this->getTable('feedmanagersku')};
CREATE TABLE {$this->getTable('feedmanagersku')} (
  `feedmanagersku_id` int(11) NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  PRIMARY KEY  (`feedmanagersku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 DROP TABLE IF EXISTS {$this->getTable('feedmanagermapping')};
CREATE TABLE {$this->getTable('feedmanagermapping')} (  
`feedmanagermapping_id` int(11) NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `data` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `type1` tinyint(4) NOT NULL,
  `data1` varchar(255) NOT NULL,
  `suffix1` varchar(255) NOT NULL,
  `order_by` int(11) NOT NULL,
  PRIMARY KEY  (`feedmanagermapping_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
 DROP TABLE IF EXISTS {$this->getTable('feedmanagerftpdetail')};
CREATE TABLE {$this->getTable('feedmanagerftpdetail')} (  
`feedmanagerftpdetail_id` int(11) NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `directory` varchar(255) NOT NULL,
  PRIMARY KEY  (`feedmanagerftpdetail_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 DROP TABLE IF EXISTS {$this->getTable('feedmanagerversion')};
CREATE TABLE {$this->getTable('feedmanagerversion')} (  
`id` int(11) NOT NULL auto_increment,
  `ver` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

delete from {$this->getTable('feedmanagerversion')};
Insert into {$this->getTable('feedmanagerversion')} (`id`,`ver`) values (1,'2.7');
	");


$installer->endSetup(); 