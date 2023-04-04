<?php 

class Model_Core_View
{
	protected $template = Null;
	protected $data = [];

	public function __set($key, $value)
	{	
		if(is_array($value)){
			$this->data = $value;
		}
		else{
			$this->data[$key] = $value;
		}
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

	public function setTemplate($path)
	{
		$this->template = $path;
		return $this;
	}

	public function getTemplate()
	{
		if(!$this->template){
			return false;
		}
		return $this->template;
	}

	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}

	public function getData()
	{
		if(!$this->data){
			return false;
		}
		return $this->data;
	}

	public function render()
	{
		$url = Ccc::getModel('Core_Url');
		require_once 'View'.DS.$this->getTemplate();
	}
}