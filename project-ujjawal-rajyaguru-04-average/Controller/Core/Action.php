<?php 

class Controller_Core_Action
{
	protected $request = Null;
	protected $url = Null;
	protected $messageObject = Null;
	protected $view = Null;

	protected function setRequest(Model_Core_Request $request)
	{
		$this->request = $request;
		return $this;
	}

	public function getRequest()
	{

		if($this->request){
			return $this->request;
		}

		$request = new Model_Core_Request();
		$this->setRequest($request);
		return $request;
	}

	protected function setUrl(Model_Core_Url $url)
	{
		$this->url = $url;
		return $this;
	}

	public function getUrl()
	{

		if($this->url){
			return $this->url;
		}

		$url = new Model_Core_Url();
		$this->setUrl($url);
		return $url;
	}

	protected function setMessageObject(Model_Core_Message $message)
	{
		$this->messageObject = $message;
		return $this;
	}

	public function getMessageObject()
	{
		if($this->messageObject){
			return $this->messageObject;
		}

		$message = new Model_Core_Message();
		$this->setMessageObject($message);
		return $message;
	}

	public function setView($view)
	{
		$this->view = $view;
		return $this;
	}

	public function getView()
	{
		if($this->view){
			return $this->view;
		}

		$view = new Model_Core_View();
		$this->setView($view);
		return $view;
	}

	public function render()
	{
		$this->getView()->render();
	}

	public function redirect($a, $c = Null, $params = [], $resetParams = false)
	{
		$url = $this->getUrl();
		header("Location: {$url->getUrl($a,$c,$parmas,$resetParams)}");
		exit();
	}

	public function errorAction($action)
	{
		throw new Exception("Method: {$action} does not exist", 1);
	}
}