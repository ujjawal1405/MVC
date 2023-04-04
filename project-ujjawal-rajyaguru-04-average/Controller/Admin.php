<?php

class Controller_Admin extends Controller_Core_Action
{
	public function gridAction()
	{
		$sql = "SELECT * FROM `admin`";
		$row = Ccc::getModel('Admin_Row');
		$admins = $row->fetchAll($sql);
		if(!$admins){
			throw new Exception("Product not found.", 1);
		}

		$this->getView()
			->setTemplate('admin/grid.phtml')
			->setData($admins);
		$this->render();
	}

	public function addAction()
	{
		try 
		{
			$admin = Ccc::getModel('Product_Row');
			if(!$admin){
				throw new Exception("Invalid request.", 1);
			}

			$this->getView()
				->setTemplate('admin/edit.phtml')
				->setData($admin);
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
		try 
		{
			if(!$id = (int) $this->getRequest()->getParams('id')){
	    		throw new Exception("Invalid request.", 1);
			}

			$admin = Ccc::getModel('Admin_Row')->load($id);
			if(!$admin){
				throw new Exception("Invalid Id.", 1);
			}

			$this->getView()
				->setTemplate('admin/edit.phtml')
				->setData($admin);
			$this->render();	
		} 
		catch (Exception $e) 
		{
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

			$postData = $this->getRequest()->getPost('admin');
			if(!$postData){
				throw new Exception("Invalid data posted.", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if($id = (int) $this->getRequest()->getParams('id')){
				$admin = Ccc::getModel('Admin_Row')->load($id);
				if(!$admin){
					throw new Exception("Invalid Id.", 1);
				}
				$admin->updated_at = date("Y-m-d h:i:s");
			}
			else
			{
				$admin = Ccc::getModel('Admin_Row');
				$admin->created_at = date("Y-m-d h:i:s");
			}

			$admin->setData($postData);
			if(!$admin->save()){
				throw new Exception("Unable to save admin.", 1);
			}
			$this->getMessageObject()->addMessage("Admin saved successfully.");
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',Null,Null,true);
	}
	
	public function deleteAction()
	{
		try 
		{
			if(!$id = (int) $this->getRequest()->getParams('id')){
	    		throw new Exception("Invalid ID.", 1);
			}

			$result = Ccc::getModel('Admin_Row')->load($id)->delete();
			if(!$result){
				throw new Exception("Error Admin is not deleted.", 1);
			}

			$messageObject = $this->getMessageObject()->addMessage("Admin deleted successfully.");
		}
		catch (Exception $e) 
		{
			$messageObject = $this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',Null,Null,true);
	}
}