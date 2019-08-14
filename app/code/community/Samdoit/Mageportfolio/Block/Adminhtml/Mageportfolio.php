<?php
class Samdoit_Mageportfolio_Block_Adminhtml_Mageportfolio extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_mageportfolio';
    $this->_blockGroup = 'mageportfolio';
    $this->_headerText = Mage::helper('mageportfolio')->__('Manage Portfolio');
    $this->_addButtonLabel = Mage::helper('mageportfolio')->__('Add New Portfolio');
    parent::__construct();
  }
}
