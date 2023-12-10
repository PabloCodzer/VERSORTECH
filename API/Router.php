<?php

require 'controllers/GETContoller.php';
require 'controllers/POSTController.php';
require 'controllers/PATCHController.php';
require 'controllers/DELETEController.php';

class Router 
{
    public function endpoint(string  $requestUrl)
    {
        $rota = substr($requestUrl, 1);
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        switch($requestMethod)
        {
            case "GET":
                new GETController($requestUri);
                break;
            
            case "POST":
                new POSTController($requestUri);
                break;

            case "PATCH":
                new PATHController($requestUri);
                break;    

            case "DELETE":
                new DELETEontroller($requestUri);
                break;
        }

    }
}