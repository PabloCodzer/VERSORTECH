<?php
// sua_classe.php
class SQLite {

    /**
    * Função retorna objeto de conexão PDO
    */
    public function conecta_sqlite()
    {

        try {
            $pdo = new PDO('sqlite:C:\Users\Cozer\Documents\Html_REVISAO\TEST_API\db\db.sqlite', '', '', array(
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ));
            return $pdo;
        } 
        catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    }

    /**
    * Pega todas as cores cadastrados
    */
    public function getAllcores()
    {
        $querygetAll = "select * from colors";
        $conexao = $this->conecta_sqlite();
        $cores = $conexao->query($querygetAll)->fetchAll();
        return $cores;
    }

    /**
    * Pega cores por nome
    */
    public function getCorByNome($color_name)
    {
        $sql_corByid = "SELECT id FROM colors WHERE name = '$color_name'";
        $sqliteConecta = $this->conecta_sqlite();
        $color_id = $sqliteConecta->query($sql_corByid)->fetch();
        return $color_id['id'];
    }

    /**
    * Insere nova cor
    */
    public function insertCor($color )
    {
        $queryInsert = "INSERT INTO colors (name) VALUES (?)";
        $conexao_PG = $this->conecta_sqlite();

        if ($this->verificaDuplicidade( $color )) 
        {
            return  [ "erro"    => "Cor ja existe" ];
        }
        else 
        {
            $cursor = $conexao_PG->prepare($queryInsert);
            $cursor->execute(array( $color ));

            return  [ "sucesso" => "Cor Cadastrada" ];
        }
    }

    /**
    * Verifica Duplicidade
    */
    public function verificaDuplicidade( $color )
    {
        $sql_verifica = "SELECT name FROM colors WHERE name = '$color'";
        $sqliteConecta = $this->conecta_sqlite();
        $verificaSeexiste = $sqliteConecta->query($sql_verifica)->fetchAll();
        return $verificaSeexiste ?  1 : 0;
    }

    /**
    *  Atualiza cor existente
    */
    public function updateCor( $color_name, $color_update )
    {
        $queryUpdateCor = "UPDATE colors SET  name = :name WHERE id = :id";

        $sqliteConecta = $this->conecta_sqlite();
        $cor_update = $sqliteConecta->prepare($queryUpdateCor);
        if ($this->verificaDuplicidade( $color_name  )) 
        {
            $id_cor = $this->getCorByNome($color_name);
            $cor_update->execute([':id' => $id_cor , ':name' => $color_update ]);
            
            return  [ "sucesso" => " Cor atualizada" ];
        }
        else 
        {
            return  [ "erro"    => "Cor nao existe" ];
        }
    }

    /**
    *  Deleta cor existente
    */    
    public function deleteCor( $color_id )
    {
        $cor = $this->getCorId( $color_id );
        $cor =  isset($cor[0]['name']) ? $cor[0]['name']: '' ;
       
        if ($this->verificaDuplicidade( $cor )) 
        {
            $query_delCor = "DELETE FROM colors WHERE name = :cor";
            $this->conecta_sqlite()->prepare($query_delCor)->execute([':cor' => $cor ]);
            
            return[ "sucesso" => " Cor deletada"  ];
        }
        else 
        {
            return  [ "erro" => "Cor nao existe" ];
        }
    }

    /**
    *  Pega a relação de Usuarios x Cor, monta a tabela
    */
    public function getAllUserColors()
    {
        $querygetAll = "
                        SELECT uc.id,
                        COALESCE( (SELECT u.name  FROM users u WHERE u.id = uc.user_id ), 'N/A' ) as  username,
                        COALESCE( (SELECT ccr.name  FROM colors ccr WHERE ccr.id = uc.color_id), 'N/A' ) as  colorname,
                        COALESCE( (SELECT u.email  FROM users u  WHERE  u.id = uc.user_id), 'N/A' ) as  email
                        FROM user_colors_id uc 
                        GROUP BY uc.id, username, email, colorname
                        ORDER BY  uc.id ASC  
                       ";
        $conexao = $this->conecta_sqlite();
        $produtos = $conexao->query($querygetAll)->fetchAll();
        return $produtos;
    }

    /**
    *  Pega todos os usuarios
    */
    public function getAllUsers()
    {
        $querygetAll = "select * from users ";
        $conexao = $this->conecta_sqlite();
        $usuarios = $conexao->query($querygetAll)->fetchAll();
        return $usuarios;
    }

    /**
    *  Pega usuario por id
    */
    public function getUsuarioId($id)
    {
        $querygetusu = "select * from users where id= $id";
        $conexao = $this->conecta_sqlite();
        $usuarios = $conexao->query($querygetusu)->fetchAll();
        return $usuarios;
    }

    /**
    *  Pega cor por id
    */
    public function getCorId($id)
    {
        $querySelectCor = " select * from colors where id=$id";
        $conexao = $this->conecta_sqlite();
        $cor =  $conexao->query($querySelectCor)->fetchAll();
        return $cor;
    }

    /**
    *  Pega cadastro relacionado CorxId
    */
    public function getUserCorById($id)
    {
        $queryUserCor = "select * from  user_colors_id uc where id = $id";
        $conexao = $this->conecta_sqlite();
        $UserCorId =  $conexao->query($queryUserCor)->fetchAll();
        return  $UserCorId;
    }

    /**
    *  Unsere novo usuario
    */
    public function criaUsuario( $cadastro )
    {

        $nome_usuario = isset($cadastro['name']) ? $cadastro['name'] : '';
        $email = isset($cadastro['email']) ? $cadastro['email'] : '';

        $check_email_dispo = $this->testEmJaExiste($email);
        $check_usu_dispo = $this->testUsuExiste($nome_usuario);
        if( $check_usu_dispo != false )
        {
            return [ "erro" => 'usuario ja existe' ];
        }
        elseif($check_email_dispo != false )
        {
            return [ "erro" => 'email ja existe' ];
        }
        elseif(!$this->validarEmail($email)) 
        {
            return ['erro' => "formato email invalido!"];
        } 
        else
        {
            $insere = [ $cadastro['name'],  $cadastro['email'] ];
            $query_cadastra_usuario = "INSERT INTO users(name, email) VALUES (?,?)";
            $cadastra = $this->conecta_sqlite()->prepare($query_cadastra_usuario);
            $cadastra->execute( $insere );
            return [ "sucesso" => 'Usuario Cadastrado'  ];
        }
    }

    /**
    *  Atualiza usuario por id
    */
    public function updateUsuario($update)
    {
        $id = $update["id"];
        $nome = $update['name'];
        $email = $update['email'];
        
        $check_nome_disponivel = $this->testNomeExiste($nome, $id);
        $check_email_disponivel = $this->testEmailExiste($email, $id);


        if($check_nome_disponivel != false)
        {
            return ['erro' => "usuario ja existe" ];
        }
        if($check_email_disponivel != false)
        {
            return ['erro' => "email ja existe" ];
        }
        if (!$this->validarEmail($email)) 
        {
            return ['erro' => "formato email invalido!"];
        } 

        $query_update ="UPDATE users SET name = '$nome', email = '$email' WHERE id = '$id'";
        $update = $this->conecta_sqlite()->exec($query_update);

        return [ "sucesso" => 'Usuario Editado' ];
    }

    function validarEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
    *  Deleta Usuario
    */
    public function DeletaUsuario($id_usuario)
    {
        $query_deleUsuario = "DELETE FROM users WHERE id = $id_usuario";
        $delete = $this->conecta_sqlite();
        $delete->exec($query_deleUsuario);
        return [ "sucesso" => 'Usuario Excluido'];
    }

    public function testUsuExiste($nome_usuario)
    {
        $query_verifica_existe_usu = "SELECT name FROM  users where name = '$nome_usuario'";
        $usu_result = $this->conecta_sqlite()->query($query_verifica_existe_usu)->fetch();
        return $usu_result;
    }

    public function testEmJaExiste($email)
    {
        $query_verifica_existe_email = "SELECT email FROM  users where email = '$email'";
        $usu_result = $this->conecta_sqlite()->query($query_verifica_existe_email)->fetch();
        return $usu_result;
    }

    public function testUsuUpdate($id)
    {
        $query_verifica_usu = "SELECT * FROM  users where id = '$id'";
        $usu_result = $this->conecta_sqlite()->query($query_verifica_usu)->fetch();
        return $usu_result;
    }

    public function testEmailExiste($email_usuario, $id)
    {
        $query_verifica_existe_email = "SELECT email FROM  users where email = '$email_usuario' and id != '$id'";
        $email_result = $this->conecta_sqlite()->query($query_verifica_existe_email)->fetch();
        return $email_result;
    }

    public function testNomeExiste($nome_usuario, $id)
    {
        $query_verifica_existe_nome = "SELECT name FROM  users where name = '$nome_usuario' and id != '$id'";
        $email_result = $this->conecta_sqlite()->query($query_verifica_existe_nome)->fetch();
        $cout = 0;
        // if(!empty($email_result))
        // {
        //     foreach ($email_result as $i)
        //     {
        //         $cout += 1;
        //     }
        // }
        return  $email_result ;
    }

    /**
    *  Cadstra UsuxCor
    */
    public function cadastraUsuxCor($id_UxC, $id_cor, $id_Usu)
    {
        if($this->getUsuarioId($id_Usu) && $id_UxC != '')
        {
            $query_update_usuXcor = "UPDATE user_colors_id SET color_id = '$id_cor', user_id = '$id_Usu' WHERE id = '$id_UxC'";
            $update = $this->conecta_sqlite()->exec($query_update_usuXcor);
            return ['sucesso' => "Usuario atualizado!"]; 
        }
        else 
        {
            $query_insere_usuXcor = "INSERT INTO user_colors_id( user_id, color_id) VALUES( $id_Usu, $id_cor)";
            $insere = $this->conecta_sqlite()->exec($query_insere_usuXcor);
            return ['sucesso' => "Usuario Cadastrado!"];
        }
    }

    /**
    *  Deleta Usu x Cor( apenas associaçao)
    */
    public function DeletaUsuxCor($id_UxC)
    {
        $query_deleta_UxC = "DELETE FROM user_colors_id WHERE id = $id_UxC";
        $this->conecta_sqlite()->exec($query_deleta_UxC);
        return ['sucesso' => "Usuario Excluido!"];
    }
}