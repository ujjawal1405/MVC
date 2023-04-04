<?php 

class Model_Core_Table
{
	protected $tableName = Null;
	protected $primaryKey = Null;
	protected $adapter = Null;
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	const STATUS_ACTIVE_lBl = 'Active';
	const STATUS_INACTIVE_lBl = 'Inactive';
	const STATUS_DEFAULT = 2;

	public function __construct()
	{
		// code...
	}

	public function getStatusOptions()
	{
		return [
			self::STATUS_ACTIVE => self::STATUS_ACTIVE_lBl,
			self::STATUS_INACTIVE => self::STATUS_INACTIVE_lBl
		];
	}

	public function setAdapter(Model_Core_Adapter $adapter)
	{
		$this->adapter = $adapter;
		return $this;
	}

	public function getAdapter()
	{
		if($this->adapter){
			return $this->adapter;
		}

		$adapter = new Model_Core_Adapter();
		$this->setAdapter($adapter);
		return $adapter;
	}

	public function setTableName($tableName)
	{
		$this->tableName = $tableName;
		return $this;
	}

	public function getTableName()
	{
		return $this->tableName;
	}

	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;
		return $this;
	}

	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	public function fetchAll($query)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->fetchAll($query);
		if(!$result){
			return false;
		}
		return $result;
	}

	public function fetchRow($query)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->fetchRow($query);
		if(!$result){
			return false;
		}
		return $result;
	}

	public function insert($arrayData)
	{
		$keyString = '`'.implode('`,`', array_keys($arrayData)).'`';
		$valueString = "'".implode("','", array_values($arrayData))."'";
		$sql = "INSERT INTO `{$this->getTableName()}` ({$keyString}) VALUES ({$valueString})";
		$result = $this->getAdapter()->insert($sql);
		if(!$result){
			return false;
		}
		return $result;
	}

	public function update($arrayData, $condition)
	{
		$data = [];
		foreach ($arrayData as $key => $value) {
			$data[] = "`{$key}` = '{$value}'";
		}

		$dataString = implode(',', $data);
		if(is_array($condition))
		{
			$where = [];
			foreach ($condition as $key => $value) {
				$where[] = "`{$key}` = '{$value}'";
			}

			$whereString = implode(" AND ", $where);
		}
		else
		{
			$whereString = "`{$this->getPrimaryKey()}` = '{$condition}'";
		}

		$sql = "UPDATE `{$this->getTableName()}` SET {$dataString} WHERE {$whereString}";
		$result = $this->getAdapter()->update($sql);
		if(!$result){
			return false;
		}
		return true;
	}

	public function delete($condition)
	{
		if(is_array($condition))
		{
			$where = [];
			foreach ($arrayData as $key => $value) {
				$where = "`{$key}` = '{$value}'";
			}

			$whereString = implode(" AND ", $where);
		}
		else
		{
			$whereString = "`{$this->getPrimaryKey()}` = {$condition}";
		}

		$sql = "DELETE FROM `{$this->getTableName()}` WHERE {$whereString}";
		$result = $this->getAdapter()->delete($sql);
		if(!$result){
			return false;
		}
		return true;
	}
}