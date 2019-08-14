<?php

$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('mageportfolio')} 
	ADD COLUMN `category` varchar(255) AFTER `content`;
    ");

$installer->endSetup(); 
