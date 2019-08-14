<?php
class Samdoit_Mageportfolio_Model_Mageportfolio extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('mageportfolio/mageportfolio');
	}
/*	public getDetail()
	{
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$query = "SELECT *FROM mageportfolio";
		echo $query;
		$wppageCollection = $readConnection->fetchAll($query);
		foreach($wppageCollection as $key=>$value)
		{
			print_r($value);
		}
	}*/
}
