<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

class POSTController 
{
    public readonly string $requestUri;
    public function __construct(string $requestUri) 
    {
        $this->requestUri = $requestUri;
        $this->subrota_post( $this->requestUri);
    }

    public function subrota_post($requestUri)
    {
        switch( $requestUri )
        {
            case '/cadastroCor':
                $this->cadastraCor();
                break;
            
            case '/consultaCor':
                $this->consultaCorId();
                break;

            case '/cadastroUsu':
                $this->cadastraUsuario();
                break;

            case '/consultaUsu':
                $this->consultaUsuByID();
                break;

            case '/insUsuXCor':
                $this->cadastraUsuarioXCor();
                break;
    

            case '/consultaUsuXCor':
                $this->consultaUsuXCorID();
                break;    

            default:
                $this->sendJsonResponse(['error'=> "Rota POST Inesistente !!"], 401);
        }  
    }

    function sendJsonResponse($data, $statusCode = 200) 
    {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    protected function cadastraCor()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);
        if(isset($req->nomeCor))
        {
            $nomeCor = $req->nomeCor === "" ? "N/A":  $req->nomeCor;
            $status_CadastraCor = $db->insertCor($nomeCor );
            $this->sendJsonResponse($status_CadastraCor);
        }
        else
        {
            $this->sendJsonResponse(['error'=> "nomeCor nao preenchido !!"], 401);
        }
    }

    protected function consultaCorId()
    {
        $db = new SQLite();
    
        $json = file_get_contents('php://input');
        $req = json_decode($json);

        if(isset($req->idCor))
        {
            $idCor = $req->idCor === "" ? "N/A":  $req->idCor;
            $ConsultaCor = $db->getCorId($idCor);
            $this->sendJsonResponse($ConsultaCor);
        }
        elseif(isset($req->idUsu))
        {
            $this->sendJsonResponse(["idUsu"=> "consulta de Usuario"]);
        }
        elseif(isset($req->idUsuCor))
        {
            $this->sendJsonResponse(["idUsuCor"=> "consulta de Usuario x Cor"]);
        }
        else
        {
            $this->sendJsonResponse(['error'=> "Id errado !!"], 404);
        }
    }

    protected function cadastraUsuario()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);
 
        if(isset($req->nomeUsu) && isset($req->emailUsu))
        {
            $nomeUsu = $req->nomeUsu === "" ? "N/A":  $req->nomeUsu;
            $emailUsu = $req->emailUsu === "" ? "N/A":  $req->emailUsu;
            $cadastro = [                            
                            'name'  => $nomeUsu, 
                            'email' => $emailUsu 
                        ]; 
            $status_CadastraUsuario = $db->criaUsuario($cadastro);
            $this->sendJsonResponse($status_CadastraUsuario);
        }
        else
        {
            $this->sendJsonResponse(['error'=> $req ], 401);
        }
    }

    protected function consultaUsuByID()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);

        if(isset($req->idUsu))
        {
            $idUsu = $req->idUsu === "" ? "N/A":  $req->idUsu;
            $status_consulta = $db->getUsuarioId($idUsu);
            $this->sendJsonResponse($status_consulta);
        }
        else
        {
            $this->sendJsonResponse(['error'=> $req ], 401);
        }
    }

    protected function cadastraUsuarioXCor()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);


        if(isset($req->idCor) && isset($req->idUsu))
        {
            $id_UxC = isset($req->id_UxC) ? $req->id_UxC : '';
            $id_Cor = $req->idCor === "" ? "N/A":  $req->idCor;
            $id_Usu = $req->idUsu === "" ? "N/A":  $req->idUsu;
            $statusUsuXCor =  $db->cadastraUsuxCor($id_UxC, $id_Cor, $id_Usu);
            $this->sendJsonResponse($statusUsuXCor );
        }
        else
        {
            $this->sendJsonResponse(['error'=> $req ], 401);
        }
    }

    protected function consultaUsuXCorID()
    {
        $db = new SQLite();

        $json = file_get_contents('php://input');
        $req = json_decode($json);

        if(isset($req->idUsuCor))
        {
            $idUsuCor = $db->getUserCorById($req->idUsuCor);
            $this->sendJsonResponse($idUsuCor);
        }
        else
        {
            $this->sendJsonResponse(['error'=> $req ], 401);
        }
    }
}