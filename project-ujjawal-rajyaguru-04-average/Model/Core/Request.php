<?php 

class Model_Core_Request
{
	public function getPost($key = Null, $value = Null)
	{
		if(array_key_exists($key, $_POST)){
			return $_POST[$key];
		}
		
		if($key == Null){
			return $_POST;
		}

		return $value;
	}

	public function getParams($key = Null, $value = Null)
	{
		if(array_key_exists($key, $_GET)){
			return $_GET[$key];
		}

		if($key == Null){
			return $_GET;
		}

		return $value;
	}

	public function isPost()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			return true;
		}

		return False;
	}

	public function getActionName()
	{
		return $this->getParams('a','index');
	}

	public function getControllerName()
	{
		return $this->getParams('c','index');
	}
}