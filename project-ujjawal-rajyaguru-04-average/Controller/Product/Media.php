<?php 

class Controller_Product_Media extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			if(!$id = (int) $this->getRequest()->getParams('id')){
	    		throw new Exception("o bhai.", 1);
			}

			$sql = "SELECT * FROM `product_media` WHERE `product_id` = '{$id}'";
			$medias = Ccc::getModel('Product_Media_Row')->fetchAll($sql);
			if(!$medias){
				throw new Exception("Product media not found.", 1);
			}

			$this->getView()
				->setTemplate('productMedia/grid.phtml')
				->setData(['medias'=>$medias]);
			$this->render();
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid','product');
		}
	}

	public function addAction()
	{
		$this->getView()
			->setTemplate('productMedia/add.phtml');
		$this->render();
	}

	public function saveAction()
	{
		try {
			if(!$id = (int) $this->getRequest()->getParams('id')){
	    		throw new Exception("Invalid request Id.", 1);
			}

			if(!$this->getRequest()->isPost()){
				throw new Exception("Invalid Request.", 1);
			}

			$row = Ccc::getModel('Product_Media_Row');
			date_default_timezone_set('Asia/Kolkata');
			$row->setData([
				'product_id' => $id,
				'name' => $this->getRequest()->getPost('name'),
				'created_at' => date("Y-m-d h:i:s")
			]);
			if(!$row->save()){
				throw new Exception("Unable to upload media.", 1);
			}

			$imageId = $row->image_id;
			$row->removeData();
			$name = $_FILES['image']['name'];
			$ext = explode('.', $name);
			$fileName = $imageId.".".$ext[1];
			$fileLoc = $_FILES['image']['tmp_name'];
			$dest = "View/productMedia/media/".$fileName;
			if(!move_uploaded_file($fileLoc, $dest)){
				throw new Exception("Image is not uploaded.", 1);	
			}

			$row->setData([
				'image' => $fileName,
				'image_id' => $imageId
			]);
			if(!$row->save()){
				throw new Exception("Unable to upload media.", 1);
			}

			$this->getMessageObject()->addMessage("Media added successfully.");	
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid');
	}

	public function updateAction()
	{
		try {
			$request = $this->getRequest();
			if(!$id = (int) $request->getParams('id')){
	    		throw new Exception("Invalid request.", 1);
			}

			if(!$request->isPost()){
				throw new Exception("Invalid request", 1);
			}

			if($request->getPost('delete')){
				$del = $request->getPost('del');
				foreach($del as $key=>$value){
					$result = Ccc::getModel('Product_Media_Row')->load($key)->delete();
					if(!$result){
						throw new Exception("Unable to delete media.", 1);
					}
				}
				$this->getMessageObject()->addMessage('Media deleted successfully.');
			}
			else{
				$thumb = $request->getPost('thumbnail');
				$small = $request->getPost('small');
				$base = $request->getPost('base');
				$gallery = $request->getPost('gallery');

				$row = Ccc::getModel('Product_Media_Row');
				$row->setData([
					'thumbnail' => 0,
					'small' => 0,
					'base' => 0,
					'gallery' => 0,
					'product_id'=>$id
				]);
				$row->setPrimaryKey('product_id')->save();
				$row->removeData();
				$row->setData([
					'thumbnail' => 1,
					'image_id'=>$thumb]
				);
				$row->setPrimaryKey('image_id')->save();
				$row->removeData();

				$row->setData([
					'small' => 1,
					'image_id'=>$small
				]);
				$row->setPrimaryKey('image_id')->save();
				$row->removeData();

				$row->setData([
					'base' => 1,
					'image_id'=>$base
				]);
				$row->setPrimaryKey('image_id')->save();
				$row->removeData();

				date_default_timezone_set('Asia/Kolkata');
				$row->setData([
					'created_at' => date("Y-m-d h:i:s"),
					'image_id'=>[$thumb,$small,$base]
				]);
				$row->save();
				$row->removeData();

				$row->setData([
					'gallery' => 1,
					'image_id'=>[$thumb,$small,$base]
				]);
				if(!$row->save()){
					throw new Exception("Unable to update media", 1);
				}

				$this->getMessageObject()->addMessage('Media updated successfully.');
			}
		} 
		catch (Exception $e) {
			$this->getMessageObject()->addMessage($e->getMessage(),Model_Core_Message::FAILURE);
		}
		$this->redirect('grid');
	}
}

?>