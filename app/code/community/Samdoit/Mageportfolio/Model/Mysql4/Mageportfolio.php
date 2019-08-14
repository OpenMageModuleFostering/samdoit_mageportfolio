<?php

class Samdoit_Mageportfolio_Model_Mysql4_Mageportfolio extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the mageportfolio_id refers to the key field in your database table.
        $this->_init('mageportfolio/mageportfolio', 'mageportfolio_id');
    }
}
