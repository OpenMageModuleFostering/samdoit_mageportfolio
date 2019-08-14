<?php

class Samdoit_Mageportfolio_Block_Adminhtml_Mageportfolio_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('mageportfolio_form', array('legend'=>Mage::helper('mageportfolio')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('mageportfolio')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('mageportfolio')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('mageportfolio')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('mageportfolio')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('mageportfolio')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('mageportfolio')->__('Content'),
          'title'     => Mage::helper('mageportfolio')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getMageportfolioData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMageportfolioData());
          Mage::getSingleton('adminhtml/session')->setMageportfolioData(null);
      } elseif ( Mage::registry('mageportfolio_data') ) {
          $form->setValues(Mage::registry('mageportfolio_data')->getData());
      }
      return parent::_prepareForm();
  }
}
