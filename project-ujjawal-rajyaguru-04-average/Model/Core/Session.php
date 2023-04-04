<?php 

class Model_Core_Session
{
	public function start()
	{
		session_start();
		return $this;
	}

	public function destroy()
	{
		session_destroy();
		return $this;
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
		return $this;
	}

	public function get($key = Null)
	{
		if(!$key){
			return $_SESSION;
		}

		if(!$this->has($key)){
			return Null;
		}
		return $_SESSION[$key];
	}

	public function unset($key)
	{
		if($this->has($key)){
			unset($_SESSION[$key]);
		}
		return $this;
	}

	public function has($key)
	{
		if(array_key_exists($key, $_SESSION)){
			return true;
		}
		return false;
	}
}