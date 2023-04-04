<?php 

class Controller_Salesman_Price extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			if(!$salesmanId = (int) $this->getRequest()->getParams('id')){
				throw new Exception("Invalid request.", 1);
			}
			
			$sql = "SELECT * FROM `salesman`";
			$row = Ccc::getModel('Salesman_Price_Row');
			$salesmen = $row->fetchAll($sql);
			if(!$salesmen){
				throw new Exception("Salesman price not found.", 1);
			}
	
			$sql = "SELECT p.* , sp.`entity_id`, sp.`salesman_price` FROM `product` p LEFT JOIN `salesman_price` sp ON p.`product_id` = sp.`product_id` AND sp.`salesman_id` = '{$salesmanId}'";

			$products = $row->fetchAll($sql);
			if(!$products){
				throw new Exception("Products not found.", 1);
			}

			$this->getView()
				->setData(['products'=>$products,'salesmen'=>$salesmen])
				->setTemplate('salesman/price.phtml');
			$this->render();
		} 
		catch (Exception $e) {
			$this->getMessageObject->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid','salesman',null,true);
		}
			
	}

	public function updateAction()
	{
		try {
			$request = $this->getRequest();
			if(!$id = (int) $request->getParams('id')){
				throw new Exception("Invalid request.", 1);
			}

			if(!$request->isPost()){
				throw new Exception("Invalid Request.", 1);
			}

			$sPrice = $request->getPost('sPrice');
			$row = Ccc::getModel('Salesman_Price_Row');
			foreach ($sPrice as $key => $value) {
				$sql = "SELECT * FROM `salesman_price` WHERE `product_id` = $key AND `salesman_id` = {$id}";
				$check = $row->getTable()->fetchAll($sql);

				if(!$check){
					$row->setData([
						'product_id' => $key, 
						'salesman_id' => $id, 
						'salesman_price' => $value
					]);
				}
				else{
					echo "<pre>";
					$row->load($check[0]['entity_id']);
					$row->setData([
						'salesman_price' => $value,
						'entity_id'=>[
							'product_id' => $key, 
							'salesman_id' => $id
						]
					]);
				}

				$result = $row->save();
				$row->removeData();
				if(!$result){
					throw new Exception("Unable to update salesman price.", 1);
				}
			}


			$del = $request->getPost('del');
			foreach ($del as $key => $value) {
				$priceResult = $row->load($key)->delete();
				if(!$priceResult){
					throw new Exception("Unable to delete salesman price.", 1);
				}
			}

			$this->getMessageObject()->addMessage('Salesman price updated successfully.');			
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
			
		$this->redirect('grid',Null,['id'=>$id]);
	}
}

?>