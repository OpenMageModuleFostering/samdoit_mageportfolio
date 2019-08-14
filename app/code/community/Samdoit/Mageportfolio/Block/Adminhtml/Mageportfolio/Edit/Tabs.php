<?php

class Samdoit_Mageportfolio_Block_Adminhtml_Mageportfolio_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('mageportfolio_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('mageportfolio')->__('Portfolio Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('mageportfolio')->__('Portfolio Information'),
          'title'     => Mage::helper('mageportfolio')->__('Portfolio Information'),
          'content'   => $this->getLayout()->createBlock('mageportfolio/adminhtml_mageportfolio_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
