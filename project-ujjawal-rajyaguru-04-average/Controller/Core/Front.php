<?php 

class Controller_Core_Front
{
	protected $request = Null;

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

	public function init()
	{
		$controllerName = $this->getRequest()->getControllerName();
		$controllerClassName = 'Controller_'.ucwords($controllerName,'_');
		$controller = new $controllerClassName();
		$actionName = $this->getRequest()->getActionName()."Action";
		if(!method_exists($controller, $actionName)){
			$controller->errorAction($actionName);
		}
		else{
			$controller->$actionName();
		}
	}
}