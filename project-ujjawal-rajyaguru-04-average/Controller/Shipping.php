<?php 

class Controller_Shipping extends Controller_Core_Action
{
	public function gridAction()
	{
		$sql = "SELECT * FROM `shipping`";
		$shippings = Ccc::getModel('Shipping_Row')->fetchAll($sql);
		if(!$shippings){
			throw new Exception("Shipping methods not found.", 1);
		}

		$this->getView()
			->setTemplate('shipping_method/grid.phtml')
			->setData(['shippings'=>$shippings]);
		$this->render();
	}

	public function addAction()
	{
		try {
			$shipping = Ccc::getModel('Shipping_Row');
			if(!$shipping){
				throw new Exception("Shipping Method not found.", 1);
			}

			$this->getView()
				->setTemplate('shipping_method/edit.phtml')
				->setData(['shipping'=>$shipping]);
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

			$shipping = Ccc::getModel('Shipping_Row')->load($id);
			if(!$shipping){
				throw new Exception("Shipping Method not found.", 1);
			}

			$this->getView()
				->setTemplate('shipping_method/edit.phtml')
				->setData(['shipping'=>$shipping]);
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

			$postData = $this->getRequest()->getPost('shipping');
			if(!$postData){
				throw new Exception("Invalid data posted.", 1);
			}

			if($id = (int) $this->getRequest()->getParams('id')){
				$shipping = Ccc::getModel('Shipping_Row')->load($id);
				if(!$shipping){
					throw new Exception("Invalid Id.", 1);
				}
				$shipping->updated_at = date("Y-m-d h:i:s");
			}
			else
			{
				$shipping = Ccc::getModel('Shipping_Row');
				$shipping->created_at = date("Y-m-d h:i:s");
			}

			$shipping->setData($postData);
			if(!$shipping->save()){
				throw new Exception("Unable to save shipping method.", 1);
			}
			$this->getMessageObject()->addMessage("Shipping method saved successfully.");
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',null,null,true);
	}

	public function deleteAction()
	{
		try {
			if(!$id = $this->getRequest()->getParams('id')){
	    		throw new Exception("Invalid Request", 1);
			}

			$shippingResult = Ccc::getModel('Shipping_Row')->load($id)->delete();
			if(!$shippingResult){
				throw new Exception("Unable to delete shipping method.", 1);
			}

			$this->getMessageObject()->addMessage('Shipping Method deleted successfully.');
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',null,null,true);
	}
}

?>