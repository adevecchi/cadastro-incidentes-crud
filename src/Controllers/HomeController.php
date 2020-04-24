<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class HomeController
{
	private $view;
	
	public function __construct($container)
	{
		$this->view = $container->get('view');
    }

    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'index.html');
    }
}