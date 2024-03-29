<?php

class Route
{
	
	static function start()
	{
		$controller_name = 'Banner';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if (!empty($routes[1]))	{	
			$controller_name = $routes[1];
		}	

		if (!empty($routes[2])) {
			$action_name = $routes[2];
		}

		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		$model_file = strtolower($model_name).'.php';
		$model_path = MODELS_DIRECTORY.$model_file;

		if (file_exists($model_path)) {
			include_once MODELS_DIRECTORY.$model_file;
		}

		$controller_file = strtolower($controller_name).'.php';
		$controller_path = CONTROLLERS_DIRECTORY.$controller_file;

		if (file_exists($controller_path)) {
			include_once CONTROLLERS_DIRECTORY.$controller_file;
		}
		else {
			Route::ErrorPage404();
		}

		$controller = new $controller_name;
		$action = $action_name;
		$action_and_param = explode("?", $action);
		$action = $action_and_param[0];


		if (method_exists($controller, $action)) {
			$controller->$action();
		}
		else {
			Route::ErrorPage404();
		}	
	}
	
	function ErrorPage404()
	{
        header('HTTP/1.1 404 Not Found');
		header('Location:'.VIEWS_DIRECTORY.PAGE_404);
    }
}

