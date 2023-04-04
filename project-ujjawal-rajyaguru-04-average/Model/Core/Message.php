<?php 

class Model_Core_Message
{
	protected $session = Null;
	const SUCCESS = 'success';
	const FAILURE = 'failure';
	const NOTICE = 'notice';

	public function __construct(){
		return $this->getSession();
	}

	public function setSession(Model_Core_Session $session)
	{
		$this->session = $session;
		return $this;
	}

	public function getSession()
	{
		if($this->session){
			return $this->session;
		}

		$session = new Model_Core_Session();
		$this->setSession($session);
		return $session;
	}

	public function addMessage($message, $type = Null)
	{
		if(!$type){
			$type = self::SUCCESS;
		}
		
		if (!$this->getSession()->has('message')) 
		{
			$this->getSession()->set('message',[]);
		}

		$messageArray = $this->getMessage();
		$messageArray[$type] = $message;
		$this->getSession()->set('message',$messageArray);
		return $this;
	}

	public function getMessage()
	{
		if (!$this->getSession()->has('message')) {
			return null;
		}
		return $this->getSession()->get('message');
	}

	public function clearMessage()
	{
		if (!$this->getSession()->has('message')) 
		{
			return Null;
		}

		$this->getSession()->unset('message');
		return $this;
	}
}