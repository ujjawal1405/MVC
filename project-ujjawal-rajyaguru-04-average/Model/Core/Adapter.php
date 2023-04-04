<?php 

class Model_Core_Adapter
{
	protected $config = [
		'servername' => 'localhost',
		'username' => 'root',
		'password' => '',
		'dbname' => 'project-ujjawal-rajyaguru-04-average'
	];
	protected $conn = Null;

	public function connect()
	{
		if($this->conn){
			return $this->conn;
		}

		$this->conn = mysqli_connect($this->config['servername'],$this->config['username'],$this->config['password'],$this->config['dbname']);
		return $this->conn;
	}

	public function query($sql)
	{
		$connect = $this->connect();
		return $connect->query($sql);
	}
	
	public function fetchAll($sql)
	{
		$result = $this->query($sql);
		if(!$result){
			return false;
		}
		return $result->fetch_all(MYSQLI_ASSOC);
	}

	public function fetchRow($sql)
	{
		$result = $this->query($sql);
		if(!$result){
			return false;
		}
		return $result->fetch_assoc();
	}

	public function fetchPairs($sql)
	{	
		$result = $this->query($sql);
		if(!$result){
			return false;
		}

		$data = $result->fetch_all();
		$column1 = array_column($data, '0');
		$column2 = array_column($data, '1');
		if(!$column2){
			$column2 = array_fill(0, count($column1), Null);
		}
		return array_combine($column1, $column2);
	}

	public function fetchOne($sql)
	{
		$result = $this->query($sql);
		if(!$result){
			return false;
		}

		$oneRow = $result->fetch_array();
		return (array_key_exists(0, $oneRow)) ? $oneRow[0] : null;
	}
	public function insert($sql)
	{
		$connect = $this->connect();
		$result = $connect->query($sql);
		if(!$result){
			return false;
		}
		return $connect->insert_id;
	}

	public function update($sql)
	{
		$result = $this->query($sql);
		if(!$result){
			return false;
		}
		return true;
	}
	
	public function delete($sql)
	{
		$result = $this->query($sql);
		if(!$result){
			return false;
		}
		return true;
	}
}