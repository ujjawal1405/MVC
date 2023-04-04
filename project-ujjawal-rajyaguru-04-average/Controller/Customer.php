<?php 

class Controller_Customer extends Controller_Core_Action
{
	public function gridAction()
	{
		$sql = "SELECT * FROM `customer` c INNER JOIN `customer_address` d ON c.`customer_id` = d.`customer_id`";
		$customers = Ccc::getModel('Customer_Row')->fetchAll($sql);
		if(!$customers){
			throw new Exception("Customers is not found.", 1);	
		}

		$this->getView()
			->setTemplate('customer/grid.phtml')
			->setData(['customers'=>$customers]);
		$this->render();
	}

	public function addAction()
	{
		try {
			$customer = Ccc::getModel('Customer_Row');
			if(!$customer){
				throw new Exception("Invalid request.", 1);
			}

			$this->getView()
				->setTemplate('customer/edit.phtml')
				->setData(['customer'=>$customer]);
			$this->render();
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function editAction()
	{
		try {
			if(!$id = (int) $this->getRequest()->getParams('id')){
	    		throw new Exception("Invalid request.", 1);
			}

			$sql = "SELECT * FROM `customer` c INNER JOIN `customer_address` d ON c.`customer_id` = d.`customer_id` WHERE c.`customer_id` = '{$id}'";
			$customer = Ccc::getModel('Customer_Row')->fetchRow($sql);
			if(!$customer){
				throw new Exception("Customer not found.", 1);
			}

			$this->getView()
				->setTemplate('customer/edit.phtml')
				->setData(['customer'=>$customer]);
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

			$postData = $this->getRequest()->getPost('customer');
			if(!$postData){
				throw new Exception("Invalid data posted.", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if($id = (int) $this->getRequest()->getParams('id')){
				$customer = Ccc::getModel('Customer_Row')->load($id);
				if(!$customer){
					throw new Exception("Invalid Id.", 1);
				}
				$customer->updated_at = date("Y-m-d h:i:s");
			}
			else
			{
				$customer = Ccc::getModel('Customer_Row');
				$customer->created_at = date("Y-m-d h:i:s");
			}

			$customer->setData($postData);
			if(!$customerId = $customer->save()){
				throw new Exception("Unable to save customer.", 1);
			}

			$postData = $this->getRequest()->getPost('address');
			if(!$postData){
				throw new Exception("Invalid address posted.", 1);
			}

			if($id = (int) $this->getRequest()->getParams('id')){
				$address = Ccc::getModel('Customer_Row')->setTableName('customer_address')->load($id);
				if(!$address){
					throw new Exception("Invalid Id.", 1);
				}
			}
			else
			{
				$address = Ccc::getModel('Customer_Row')
							->setTableName('customer_address')
							->setPrimaryKey('address_id');
				$customerId = $customerId->customer_id;
				$address->customer_id = $customerId;
			}

			$address->setData($postData);
			if(!$address->save()){
				throw new Exception("Unable to save customer address.", 1);
			}
			$this->getMessageObject()->addMessage("Customer saved successfully.");
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
	    		throw new Exception("Invalid ID.", 1);
			}

			$customerDelete = Ccc::getModel('Customer_Row')->load($id)->delete();
			if(!$customerDelete){
				throw new Exception("Unable to delete customer.", 1);
			}

			$this->getMessageObject()->addMessage('Customer deleted successfully.');
		} 
		catch (Exception $e) 
		{
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}

		$this->redirect('grid',null,null,true);
	}
}

?>