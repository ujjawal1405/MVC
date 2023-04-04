<?php

class Controller_Product extends Controller_Core_Action
{
	public function gridAction()
	{
		$sql = "SELECT * FROM `product`";
		$row = Ccc::getModel('Product_Row');
		$products = $row->fetchAll($sql);
		if(!$products){
			throw new Exception("Product not found.", 1);
		}
		
		$this->getView()
			->setTemplate('product/grid.phtml')
			->setData(['products'=>$products]);
		$this->render();
	}
	public function addAction()
	{
		try {
			$product = Ccc::getModel('Product_Row');
			if(!$product){
				throw new Exception("Invalid request.", 1);
			}

			$this->getView()
				->setTemplate('product/edit.phtml')
				->setData(['product'=>$product]);
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

			$product = Ccc::getModel('Product_Row')->load($id);
			if(!$product){
				throw new Exception("Invalid Id.", 1);
			}

			$this->getView()
				->setTemplate('product/edit.phtml')
				->setData(['product'=>$product]);
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

			$postData = $this->getRequest()->getPost('product');
			if(!$postData){
				throw new Exception("Invalid data posted.", 1);
			}

			date_default_timezone_set('Asia/Kolkata');
			if($id = (int) $this->getRequest()->getParams('id')){
				$product = Ccc::getModel('Product_Row')->load($id);
				if(!$product){
					throw new Exception("Invalid Id.", 1);
				}
				$product->updated_at = date("Y-m-d h:i:s");
			}
			else
			{
				$product = Ccc::getModel('Product_Row');
				$product->created_at = date("Y-m-d h:i:s");
			}

			$product->setData($postData);
			if(!$product->save()){
				throw new Exception("Unable to save product.", 1);
			}
			$this->getMessageObject()->addMessage("Product saved successfully.");
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

			$productResult = Ccc::getModel('Product_Row')->load($id)->delete();
			if(!$productResult){
				throw new Exception("Unable to delete product.", 1);
			}

			$messageObject = $this->getMessageObject()->addMessage("Product deleted successfully.");
		}
		catch (Exception $e) {
			$messageObject = $this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}

		$this->redirect('grid',null,null,true);
	}
}

?>