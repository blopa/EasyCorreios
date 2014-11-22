<?php

$installer = $this;
$installer->startSetup(); //inicia a instalacao

$installer->run(" 
	-- DROP TABLE IF EXISTS {$this->getTable('wr_easycorreios')};
	CREATE TABLE {$this->getTable('wr_easycorreios')} (
	  `easycorreios_id` int(11) unsigned NOT NULL auto_increment,
	  `order_num` varchar(20) NOT NULL default '',
	  `ordem` int(3) NOT NULL default '',
	  `situacao` varchar(20) NOT NULL default '',
	  `tracking_num` varchar(13) NOT NULL default '',
	  `tipo` varchar(10) NOT NULL default '',
	  `servico` varchar(100) NOT NULL default '',
	  `local_evento` varchar(100) NOT NULL default '',
	  `local_destino` varchar(100) NOT NULL default '',
	  `descricao` varchar(500) NOT NULL default '',
	  `status` smallint(6) NOT NULL default '0',
	  `atualizado_em` datetime NULL,
	  PRIMARY KEY (`easycorreios_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ")

$installer->endSetup();
