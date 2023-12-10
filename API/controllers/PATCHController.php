<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

class PATHController 
{
    public readonly string $requestUri;
    public function __construct(string $requestUri) 
    {
        $this->requestUri = $requestUri;
        $this->subrota_path( $this->requestUri);
    }

    public function subrota_path($requestUri)
    {
        switch( $requestUri )
        {
            case '/editaCor':
                $this->eitaCor();
                break;
            
            case '/editaUsu':
                $this->editaUsu();
                break;
    
            case '/EditUsuXCor':
                $this->editaUsuXCor();
                break;
    
            default:
                $this->sendJsonResponse(['error'=> "Rota PATCH Inesistente !!"], 401);
        }  
    }

    function sendJsonResponse($data, $statusCode = 200) 
    {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    protected function eitaCor()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);
        if( isset($req->idCor) )
        {
            $nomeCorUpdt = $req->nomeCor === "" ? "N/A":  $req->nomeCor;
            $name_original = $db->getCorId($req->idCor);
            $color_name = $name_original[0]['name'];
            $statusCorUpdt = $db->updateCor( $color_name, $nomeCorUpdt );
            $this->sendJsonResponse($statusCorUpdt);
        }
        else
        {
            $this->sendJsonResponse(['error'=> "nomeCor ou idCor !!"], 401);
        }
    }   

    protected function editaUsu()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);
 
        if(isset($req->idUsu) && isset($req->nomeUsu) && isset($req->emailUsu))
        {
            $idUsu   = $req->idUsu === "" ? "N/A":  $req->idUsu;
            $nomeUsu = $req->nomeUsu === "" ? "N/A":  $req->nomeUsu;
            $emailUsu = $req->emailUsu === "" ? "N/A":  $req->emailUsu;
            $cadastro = [   
                            'id'    => $idUsu,                         
                            'name'  => $nomeUsu, 
                            'email' => $emailUsu 
                        ]; 
            $status_CadastraUsuario = $db->updateUsuario($cadastro);
            $this->sendJsonResponse($status_CadastraUsuario);
        }
        else
        {
            $this->sendJsonResponse(['error'=> $req ], 401);
        }
    }

    protected function editaUsuXCor()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);

        if(isset($req->idUsu) && isset($req->idCor) && isset($req->idUxC))
        {
            $idUsu = $req->idUsu=== "" ? "N/A" : $req->idUsu;
            $idCor = $req->idCor === "" ? "N/A": $req->idCor;
            $idUxC = $req->idUxC === "" ? "N/A": $req->idUxC;

            $statusUsuXCor =  $db->cadastraUsuxCor($idUxC, $idCor, $idUsu);
            $this->sendJsonResponse($statusUsuXCor );
        }
        else
        {
            $this->sendJsonResponse(['error'=> $req ], 401);
        }
    }
}