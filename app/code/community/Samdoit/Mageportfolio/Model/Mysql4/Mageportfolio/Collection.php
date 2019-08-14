<?php

class Samdoit_Mageportfolio_Model_Mysql4_Mageportfolio_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mageportfolio/mageportfolio');
    }
}
