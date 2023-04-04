<?php 

class Controller_Salesman extends Controller_Core_Action
{
	public function gridAction()
	{
		$sql = "SELECT * FROM `salesman` c INNER JOIN `salesman_address` d ON c.`salesman_id` = d.`salesman_id`";
		$salesmen = Ccc::getModel('Salesman_Row')->fetchAll($sql);
		if(!$salesmen){
			throw new Exception("Salesmen not found.", 1);
		}

		$this->getView()
			->setTemplate('salesman/grid.phtml')
			->setData(['salesmen'=>$salesmen]);
		$this->render();
	}

	public function addAction()
	{
		try {
			$salesman = Ccc::getModel('Salesman_Row');
			if(!$salesman){
				throw new Exception("Salesman not found.", 1);
			}

			$this->getView()
				->setTemplate('salesman/edit.phtml')
				->setData(['salesman'=>$salesman]);
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

			$sql = "SELECT * FROM `salesman` c INNER JOIN `salesman_address` d ON c.`salesman_id` = d.`salesman_id` WHERE c.`salesman_id` = '{$id}'";
			$salesman = Ccc::getModel('Salesman_Row')->fetchRow($sql);
			if(!$salesman){
				throw new Exception("Salesman not found.", 1);
			}

			$this->getView()
				->setTemplate('salesman/edit.phtml')
				->setData(['salesman'=>$salesman]);
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

			$postData = $this->getRequest()->getPost('salesman');
			if(!$postData){
				throw new Exception("Invalid data posted.", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if($id = (int) $this->getRequest()->getParams('id')){
				$salesman = Ccc::getModel('Salesman_Row')->load($id);
				if(!$salesman){
					throw new Exception("Invalid Id.", 1);
				}
				$salesman->updated_at = date("Y-m-d h:i:s");
			}
			else
			{
				$salesman = Ccc::getModel('Salesman_Row');
				$salesman->created_at = date("Y-m-d h:i:s");
			}

			$salesman->setData($postData);
			if(!$salesmanId = $salesman->save()){
				throw new Exception("Unable to save salesman.", 1);
			}

			$postData = $this->getRequest()->getPost('address');
			if(!$postData){
				throw new Exception("Invalid address posted.", 1);
			}

			if($id = (int) $this->getRequest()->getParams('id')){
				$address = Ccc::getModel('Salesman_Row')->setTableName('salesman_address')->load($id);
				if(!$address){
					throw new Exception("Invalid Id.", 1);
				}
			}
			else
			{
				$address = Ccc::getModel('Salesman_Row')
							->setTableName('salesman_address')
							->setPrimaryKey('address_id');
				$salesmanId = $salesmanId->salesman_id;
				$address->salesman_id = $salesmanId;
			}

			$address->setData($postData);
			if(!$address->save()){
				throw new Exception("Unable to save salesman address.", 1);
			}
			$this->getMessageObject()->addMessage("Salesman saved successfully.");
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

			$salesmanResult = Ccc::getModel('Salesman_Row')->load($id)->delete();
			if(!$salesmanResult){
				throw new Exception("Unable to delete salesman.", 1);
			}

			$this->getMessageObject()->addMessage('Salesman deleted successfully.');
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',null,null,true);
	}
}

?>