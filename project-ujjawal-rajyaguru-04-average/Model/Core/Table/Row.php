<?php 

class Model_Core_Table_Row
{
	protected $tableClass = Null;
	protected $data = [];
	protected $tableModel = Null;

	public function __set($key, $value)
	{	
		$this->data[$key] = $value;
		return $this;
	}

	public function __get($key)
	{
		if(!array_key_exists($key, $this->data)){
			return Null;
		}
		return $this->data[$key];
	}

	public function __unset($key)
	{
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
		}
		return $this;
	}

	public function getStatus()
	{
		if($this->status){
			return $this->status;
		}
		return Model_Core_Table::STATUS_DEFAULT;
	}

	public function getStatusText()
	{
		$statuses = $this->getTable()->getStatusOptions();
		if(array_key_exists($this->status, $statuses)){
			return $statuses[$this->status];
		}
		return $statuses[Model_Core_Table::STATUS_DEFAULT];
	}

	public function setId($id)
	{
		$this->data[$this->getTable()->getPrimaryKey()] = (int) $id;
		return $this;
	}

	public function getId()
	{
		$primaryKey = $this->getTable()->getPrimaryKey();
		return $this->$primaryKey;
	}

	public function setTableName($tableName)
	{
		$this->getTable()->setTableName($tableName);
		return $this;
	}

	public function getTableName()
	{
		return $this->getTable()->getTableName();
	}

	public function setPrimaryKey($primaryKey)
	{
		$this->getTable()->setPrimaryKey($primaryKey);
		return $this;
	}

	public function getPrimaryKey()
	{
		return $this->getTable()->getPrimaryKey();
	}

	public function setTable($tableModel){
		$this->tableModel = $tableModel;
		return $this;
	}

	public function getTable()
	{
		if($this->tableModel){
			return $this->tableModel;
		}

		$model = $this->tableClass;
		$tableModel = new $model();
		$this->setTable($tableModel);
		return $tableModel;
	}

	public function fetchAll($sql)
	{
		$arrayData = $this->getTable()->fetchAll($sql);
		if(!$arrayData){
			return $this;
		}

		foreach ($arrayData as &$row) {
			$row = (new $this)->setData($row);
		}
		return $arrayData;
	}

	public function fetchRow($sql)
	{
		$row = $this->getTable()->fetchRow($sql);
		if(!$row){
			return false;
		}
		$this->data = $row;
		return $this;
	}

	public function delete()
	{
		$id = $this->getData($this->getPrimaryKey());
		if(!$id){
			return false;
		}

		$result = $this->getTable()->delete($id);
		if(!$result){
			return false;
		}
		return $this;
	}

	public function save()
	{
		if($id = $this->getId()){
			$this->removeData($this->getPrimaryKey());
			$result = $this->getTable()->update($this->data, $id);
			if(is_array($id)){
				return $this;
			}
			if(!$result){
				return false;
			}			
			return $this->load($id);			
		}
		else{
			$result = $this->getTable()->insert($this->data);
			if(!$result){
				return false;
			}
			return $this->load($result);
		}
	}

	public function load($value, $columnName = Null)
	{
		$columnName = (!$columnName) ? $this->getPrimaryKey() : $columnName;
		$sql = "SELECT * FROM `{$this->getTableName()}` WHERE `$columnName` = {$value}";
		$result = $this->getTable()->fetchRow($sql);
		if(!$result){
			return false;
		}
		$this->data = $result;
		return $this;
	}

	public function setData(array $data)
	{
		$this->data = array_merge($this->data,$data);
		return $this;
	}

	public function getData($key = Null)
	{
		if(!$key){
			return $this->data;
		}

		if(!array_key_exists($key, $this->data)){
			return Null;
		}
		return $this->data[$key];
	}

	public function addData($key, $value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function removeData($key = Null)
	{
		if(!$key){
			$this->data = [];
		}
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
		}
		return $this;
	}
}