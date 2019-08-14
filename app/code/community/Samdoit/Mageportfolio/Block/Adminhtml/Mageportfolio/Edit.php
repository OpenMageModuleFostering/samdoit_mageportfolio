<?php

class Samdoit_Mageportfolio_Block_Adminhtml_Mageportfolio_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'mageportfolio';
        $this->_controller = 'adminhtml_mageportfolio';
        
        $this->_updateButton('save', 'label', Mage::helper('mageportfolio')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('mageportfolio')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('mageportfolio_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'mageportfolio_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'mageportfolio_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('mageportfolio_data') && Mage::registry('mageportfolio_data')->getId() ) {
            return Mage::helper('mageportfolio')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('mageportfolio_data')->getTitle()));
        } else {
            return Mage::helper('mageportfolio')->__('Add Item');
        }
    }
}
