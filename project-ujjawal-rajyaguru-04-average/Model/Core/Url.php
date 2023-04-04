<?php 

class Model_Core_Url
{
	public function getCurrentUrl()
	{
		$url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $url;
	}

	public function getUrl($action = null, $controller = null, $params = [], $resetParams = false) 
	{
	    $url = $this->getCurrentUrl();
	    $queryString = $_SERVER['QUERY_STRING'];
	    $request = Ccc::getModel('Core_Request');
	    $final = $request->getParams();
	    if ($resetParams) {
	    	$final = [];
	    }

	    if ($controller) {
	        $final['c'] = $controller;
	    }
	    else{
	    	$final['c'] = $request->getControllerName();
	    }

	    if ($action) {
	        $final['a'] = $action;
	    }
	    else{
	    	$final['a'] = $request->getActionName();
	    }

	    if ($params) {
	        $final = array_merge($final, $params);
	    }

	    $newQueryString = http_build_query($final);
	    $newUrl = str_replace($queryString, $newQueryString, $url);
	    return $newUrl;
	}
}