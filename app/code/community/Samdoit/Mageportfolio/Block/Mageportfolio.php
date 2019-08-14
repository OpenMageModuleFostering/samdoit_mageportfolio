<?php
class Samdoit_Mageportfolio_Block_Mageportfolio extends Mage_Core_Block_Template
{
	protected $_pageCollection;
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}

	public function getMageportfolio()     
	{
                $resource = Mage::getSingleton('core/resource');
                $readConnection = $resource->getConnection('core_read');
                $query = "SELECT *FROM mageportfolio WHERE status=1";
                $pageCollection = $readConnection->fetchAll($query);
		return $pageCollection;
	}
}
