<?php

namespace classes;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Base controller class (to rule them all?)
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 */
abstract class Controller
{
    protected $request;
    protected $response;
    protected $args;
    protected $app;
    
    /**
     */
    public function __construct(Request $request, Response $response, array $args)
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
    }

    /**
     */
    public function __destruct()
    {}
    
    public function init($app)
    {
        $this->app = $app;
    }
    
}

