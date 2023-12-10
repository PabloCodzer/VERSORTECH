<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require 'db/crud_sqlite.php';

class GETController 
{
    public readonly string $requestUri;
    public function __construct(string $requestUri) 
    {
        $this->requestUri = $requestUri;
        $this->subrota_get( $this->requestUri);
    }

    public function subrota_get($requestUri)
    {
        $db = new SQLite();
        switch( $requestUri )
        {
            case '/usuarios_todos':
                $todos_usuarios = $db->getAllUsers();
                $this->sendJsonResponse($todos_usuarios);
                break;
            
            case '/usuarios_x_cores':
                $todos_usuarios_cores = $db->getAllUserColors();
                $this->sendJsonResponse($todos_usuarios_cores);
                break;
    
            case '/cores_todos':
                $todas_cores = $db->getAllcores();
                $this->sendJsonResponse($todas_cores);
                break;
    
            default:
                $this->sendJsonResponse(['error'=> "Rota Inesistente !!"], 401);
        }  
    }

    function sendJsonResponse($data, $statusCode = 200) 
    {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
?>