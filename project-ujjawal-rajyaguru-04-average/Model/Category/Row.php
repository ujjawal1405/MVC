<?php 

class Model_Category_Row extends Model_Core_Table_Row
{
	protected $tableClass = 'Model_Category';

	public function getParentCategories()
	{
		$request = Ccc::getModel('Core_Request');
		if($id = (int) $request->getParams('id')){
			$sql = "SELECT * FROM `category` WHERE `category_id` = '{$id}'";
			$except = Ccc::getModel('Category_Row')->fetchRow($sql);
			$sql = "SELECT `category_id`,`path` FROM `category` WHERE `path` NOT LIKE '{$except->path}=%' AND `path` NOT LIKE '{$except->path}' ORDER BY `path` ASC";
		}
		else{
			$sql = "SELECT `category_id`,`path` FROM `category` ORDER BY `path` ASC";
		}
		return $this->getTable()->getAdapter()->fetchPairs($sql);
	}

	public function updatePath()
	{
		if(!$this->getId()){
			return false;
		}

		$parent = Ccc::getModel('Category_Row')->load($this->parent_id);
		$oldPath = $this->path;
		if(!$parent){
			$this->path = $this->getId();
		}
		else{
			$this->path = $parent->path.'='.$this->getId();
		}

		$this->save();
		$sql = "UPDATE `category` SET `path` = REPLACE(`path`,'{$oldPath}','{$this->path}') WHERE `path` LIKE '{$oldPath}=%'";
		$this->getTable()->getAdapter()->update($sql);
		return $this;
	}

	public function getPathText($path = Null)
	{
		$path = ($path) ? $path : $this->path;
		$categoryId = explode('=', $path);
		$final = [];
		foreach ($categoryId as $id) {
			if($id > 1){
				$sql = "SELECT `name` FROM `category` WHERE `category_id` = '{$id}'";
				$except = Ccc::getModel('Category_Row')->fetchRow($sql);
				$final[] = $except->name;
			}
		}

		if(!$final){
			return 'Root';
		}
		return implode('=>', $final);
	}

	public function deleteChild()
	{
		if(!$this->getId()){
			return false;
		}

		$sql = "DELETE FROM `category` WHERE `path` LIKE '{$this->path}=%'";
		$this->getTable()->getAdapter()->delete($sql);
		return $this;
	}

	public function selectPath()
	{
		return str_replace('='.$this->category_id, '', $this->path);
	}
}