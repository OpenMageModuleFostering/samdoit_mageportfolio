<?php
class Samdoit_Mageportfolio_Block_Mageportfolio extends Mage_Core_Block_Template
{
	protected $_pageCollection;
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}

	public function getMageportfolio($id='',$group='',$category='')
	{
                $resource = Mage::getSingleton('core/resource');
                $readConnection = $resource->getConnection('core_read');
		if($id)
			$query = "SELECT *FROM ".$resource->getTableName('mageportfolio/mageportfolio')." WHERE status=1 AND mageportfolio_id=$id";
		else if($group)
                        $query = "SELECT category FROM ".$resource->getTableName('mageportfolio/mageportfolio')." WHERE status=1 GROUP BY category";
		else if($category)
	                $query = "SELECT *FROM ".$resource->getTableName('mageportfolio/mageportfolio')." WHERE status=1 AND category='$category'";

	            if ($query) {
                $pageCollection = $readConnection->fetchAll($query);
	            }
	            else
	            {
	            	$pageCollection = '';
	            }
		return $pageCollection;
	}
}
