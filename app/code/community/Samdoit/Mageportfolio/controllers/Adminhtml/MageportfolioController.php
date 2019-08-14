<?php

class Samdoit_Mageportfolio_Adminhtml_MageportfolioController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('admin')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('mageportfolio/mageportfolio')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('mageportfolio_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('mageportfolio/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('mageportfolio/adminhtml_mageportfolio_edit'))
				->_addLeft($this->getLayout()->createBlock('mageportfolio/adminhtml_mageportfolio_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mageportfolio')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {

		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$pathinfo = pathinfo($_FILES["filename"]["name"]);
					$filename_final = $this->clean($pathinfo['filename']).'.'.$pathinfo['extension'];
					$path = Mage::getBaseDir('media') . DS .'Mageportfolio' . DS ;
					$uploader->save($path, $filename_final );
					
				} catch (Exception $e) {
					echo $e->getMessage();
					Mage::log($e->getMessage(), null, 'Mageportfolio.log');
		        }
	        	
		        //this way the name is saved in DB
		        $data['filename'] = 'Mageportfolio' . DS . $filename_final;
		    }
		    else {
		    	if(isset($data['filename']['delete']) && $data['filename']['delete'] == 1)
		    		$data['filename'] = '';
		    	else
		    		unset($data['filename']);  
		    }


			$model = Mage::getModel('mageportfolio/mageportfolio');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mageportfolio')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mageportfolio')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('mageportfolio/mageportfolio');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $mageportfolioIds = $this->getRequest()->getParam('mageportfolio');
        if(!is_array($mageportfolioIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($mageportfolioIds as $mageportfolioId) {
                    $mageportfolio = Mage::getModel('mageportfolio/mageportfolio')->load($mageportfolioId);
                    $mageportfolio->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($mageportfolioIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $mageportfolioIds = $this->getRequest()->getParam('mageportfolio');
        if(!is_array($mageportfolioIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($mageportfolioIds as $mageportfolioId) {
                    $mageportfolio = Mage::getSingleton('mageportfolio/mageportfolio')
                        ->load($mageportfolioId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($mageportfolioIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	public function exportCsvAction() {
		$fileName = 'portfolio.csv';
		$content = $this->getLayout ()
			->createBlock('mageportfolio/adminhtml_mageportfolio_grid')
			->getCsvFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
        public function exportXmlAction() {
                $fileName = 'portfolio.xml';
                $content = $this->getLayout ()
                        ->createBlock('mageportfolio/adminhtml_mageportfolio_grid')
                        ->getExcelFile();
                $this->_prepareDownloadResponse($fileName, $content);
        }
        public function clean($string) {
                $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
                return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }
}
