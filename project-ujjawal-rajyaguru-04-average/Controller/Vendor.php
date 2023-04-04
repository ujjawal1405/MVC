<?php 

class Controller_Vendor extends Controller_Core_Action
{	
	public function gridAction()
	{
		$sql = "SELECT * FROM `vendor` c INNER JOIN `vendor_address` d ON c.`vendor_id` = d.`vendor_id`;";
		$vendors = Ccc::getModel('Vendor_Row')->fetchAll($sql);
		if(!$vendors){
			throw new Exception("Vendors not found.", 1);
		}

		$this->getView()
			->setTemplate('vendor/grid.phtml')
			->setData(['vendors'=>$vendors]);
		$this->render();
	}

	public function addAction()
	{
		try {
			$vendor = Ccc::getModel('Vendor_Row');
			if(!$vendor){
				throw new Exception("Vendor not found.", 1);
			}

			$this->getView()
				->setTemplate('vendor/edit.phtml')
				->setData(['vendor'=>$vendor]);
			$this->render();
		} 
		catch (Exception $e) 
		{
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function editAction()
	{
		try {
			if(!$id = (int) $this->getRequest()->getParams('id')){
	    		throw new Exception("Invalid ID.", 1);
			}

			$sql = "SELECT * FROM `vendor` c INNER JOIN `vendor_address` d ON c.`vendor_id` = d.`vendor_id` WHERE c.`vendor_id` = '{$id}';";
			$vendor = Ccc::getModel('Vendor_Row')->fetchRow($sql);
			if(!$vendor){
				throw new Exception("Vendor not found.", 1);
			}

			$this->getView()
				->setTemplate('vendor/edit.phtml')
				->setData(['vendor'=>$vendor]);
			$this->render();
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid',Null,Null,true);
		}
	}

	public function saveAction()
	{
		try {
			if(!$this->getRequest()->isPost()){
				throw new Exception("Invalid request.", 1);
			}

			$postData = $this->getRequest()->getPost('vendor');
			if(!$postData){
				throw new Exception("Invalid data posted.", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if($id = (int) $this->getRequest()->getParams('id')){
				$vendor = Ccc::getModel('Vendor_Row')->load($id);
				if(!$vendor){
					throw new Exception("Invalid Id.", 1);
				}
				$vendor->updated_at = date("Y-m-d h:i:s");
			}
			else
			{
				$vendor = Ccc::getModel('Vendor_Row');
				$vendor->created_at = date("Y-m-d h:i:s");
			}

			$vendor->setData($postData);
			if(!$vendorId = $vendor->save()){
				throw new Exception("Unable to save customer.", 1);
			}

			$postData = $this->getRequest()->getPost('address');
			if(!$postData){
				throw new Exception("Invalid address posted.", 1);
			}

			if($id = (int) $this->getRequest()->getParams('id')){
				$address = Ccc::getModel('Vendor_Row')->setTableName('vendor_address')->load($id);
				if(!$address){
					throw new Exception("Invalid Id.", 1);
				}
			}
			else{
				$address = Ccc::getModel('Vendor_Row')
							->setTableName('vendor_address')
							->setPrimaryKey('address_id');
				$vendorId = $vendorId->vendor_id;
				$address->vendor_id = $vendorId;
			}

			$address->setData($postData);
			if(!$address->save()){
				throw new Exception("Unable to save vendor address.", 1);
			}
			$this->getMessageObject()->addMessage("Vendor saved successfully.");
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',null,null,true);
	}

	public function deleteAction()
	{
		try {
			if(!$id = (int) $this->getRequest()->getParams('id')){
	    		throw new Exception("Invalid request.", 1);
			}
			
			$vendorResult = Ccc::getModel('Vendor_Row')->load($id)->delete();
			if(!$vendorResult){
				throw new Exception("Unable to delete vendor.", 1);
			}

			$this->getMessageObject()->addMessage('Vendor deleted successfully.');
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',null,null,true);
	}
}

?>