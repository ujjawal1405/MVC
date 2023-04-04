<?php 

class Controller_Payment extends Controller_Core_Action
{
	public function gridAction()
	{
        $sql = "SELECT * FROM `payment`";
        $payments = Ccc::getModel('Payment_Row')->fetchAll($sql);
		if(!$payments){
			throw new Exception("Payments not found.", 1);
		}

		$this->getView()
			->setTemplate('payment_method/grid.phtml')
			->setData(['payments'=>$payments]);
		$this->render();
	}

	public function addAction()
	{
		try {
			$payment = Ccc::getModel('Payment_Row');
			if(!$payment){
				throw new Exception("Invalid Id.", 1);
			}

			$this->getView()
				->setTemplate('payment_method/edit.phtml')
				->setData(['payment'=>$payment]);
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

			$payment = Ccc::getModel('Payment_Row')->load($id);
			if(!$payment){
				throw new Exception("Invalid Id.", 1);
			}

			$this->getView()
				->setTemplate('payment_method/edit.phtml')
				->setData(['payment'=>$payment]);
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

			$postData = $this->getRequest()->getPost('payment');
			if(!$postData){
				throw new Exception("Invalid data posted.", 1);
			}

			if($id = (int) $this->getRequest()->getParams('id')){
				$payment = Ccc::getModel('Payment_Row')->load($id);
				if(!$payment){
					throw new Exception("Invalid Id.", 1);
				}
				$payment->updated_at = date("Y-m-d h:i:s");
			}
			else
			{
				$payment = Ccc::getModel('Payment_Row');
				$payment->created_at = date("Y-m-d h:i:s");
			}

			$payment->setData($postData);
			if(!$payment->save()){
				throw new Exception("Unable to save payment method.", 1);
			}
			$this->getMessageObject()->addMessage("Payment method saved successfully.");
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

			$paymentResult = Ccc::getModel('Payment_Row')->load($id)->delete();
			if(!$paymentResult){
				throw new Exception("Unable to delete payment method.", 1);
			}

			$this->getMessageObject()->addMessage('Payment Method deleted successfully.');
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',null,null,true);
	}
}

?>