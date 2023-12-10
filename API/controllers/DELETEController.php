<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

class DELETEontroller 
{
    public readonly string $requestUri;
    public function __construct(string $requestUri) 
    {
        $this->requestUri = $requestUri;
        $this->subrota_delete( $this->requestUri);
    }

    public function subrota_delete($requestUri)
    {
        switch( $requestUri )
        {
            case '/ExcluiCor':
                $this->excluiCor();
                break;
            
            case '/ExcluiUsuario':
                $this->excluiUsu();
                break;
    
            case '/excluiUsuxCor':
                $this->excluiUsuxCor();
                break;
    
            default:
                $this->sendJsonResponse(['error'=> "Rota DELETE Inesistente !!"], 401);
        }  
    }

    function sendJsonResponse($data, $statusCode = 200) 
    {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    protected function excluiCor()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);

        if( isset($req->idCor) )
        {
            $idCor = $req->idCor ==="" ? "N/A" :  $req->idCor;
            $status_excluicor = $db->deleteCor( $idCor ); 
            $this->sendJsonResponse($status_excluicor);
        }
        else
        {
            $this->sendJsonResponse(['error'=> "nomeCor ou idCor !!"], 401);
        }
    }

    protected function excluiUsu()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);

        if( isset($req->idUsu) )
        {
            $idUsu = $req->idUsu ==="" ? "N/A" :  $req->idUsu;
            $statusexcluiUsu = $db->DeletaUsuario( $idUsu ); 
            $this->sendJsonResponse($statusexcluiUsu);
        }
        else
        {
            $this->sendJsonResponse(['error'=> "idUsu !!"], 401);
        }
    }

    protected function excluiUsuxCor()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);

        if(isset($req->idUxC))
        {
            $id_UxC = $req->idUxC=== "" ? "N/A" : $req->idUxC;
            $statusDeleteUsuXCor =  $db->DeletaUsuxCor($id_UxC);
            $this->sendJsonResponse($statusDeleteUsuXCor);
        }
        else
        {
            $this->sendJsonResponse(['error'=> $req ], 401);
        }
    }
}