<?php 

class Controller_Category extends Controller_Core_Action
{
	public function gridAction()
	{
		$sql = "SELECT * FROM `category` WHERE `category_id` > 1 ORDER BY `path` ASC";
		$row = Ccc::getModel('Category_Row');
		$categorys = $row->fetchAll($sql);
		if(!$categorys){
			throw new Exception("Category not found.", 1);
		}

		$this->getView()
			->setTemplate('category/grid.phtml')
			->setData(['category'=>$categorys]);
		$this->render();
	}

	public function addAction()
	{
		try 
		{
			$sql = "SELECT * FROM `category`;";
			$category = Ccc::getModel('Category_Row');
			if(!$category){
				throw new Exception("Category not found.", 1);
			}

			$this->getView()
				->setTemplate('category/edit.phtml')
				->setData(['category'=>$category]);
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
	    		throw new Exception("Invalid ID.", 1);
			}

			$sql = "SELECT * FROM `category` WHERE `category_id` = '{$id}'";
			$category = Ccc::getModel('Category_Row')->fetchRow($sql);
			if(!$category){
				throw new Exception("Category not found.", 1);
			}

			$this->getView()
				->setData(['category'=>$category])
				->setTemplate('category/edit.phtml');
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

			$postData = $this->getRequest()->getPost('category');
			if(!$postData){
				throw new Exception("Invalid data posted.", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if($id = (int) $this->getRequest()->getParams('id')){
				$category = Ccc::getModel('Category_Row')->load($id);
				if(!$category){
					throw new Exception("Invalid Id.", 1);
				}
				$category->updated_at = date("Y-m-d h:i:s");
			}
			else
			{
				$category = Ccc::getModel('Category_Row');
				$category->created_at = date("Y-m-d h:i:s");
			}

			$category->setData($postData);
			if(!$category->save()){
				throw new Exception("Unable to save category.", 1);
			}

			$category->updatePath();
			$this->getMessageObject()->addMessage("Category saved successfully.");
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

			$result = Ccc::getModel('Category_Row')->load($id);
			if(!$result->delete()){
				throw new Exception("Unable to delete category", 1);
			}

			$result->deleteChild();
			$this->getMessageObject()->addMessage('Category deleted successfully.');
		} 
		catch (Exception $e) 
		{
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}

		$this->redirect('grid',Null,Null,true);
	}
}

?>