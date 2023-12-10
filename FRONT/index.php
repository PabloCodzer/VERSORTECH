<?php
require 'modal_cadastro_usuario.php';
require 'modal_cadastro_cor.php';
require 'modal_usuarioXcor.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <title>FrontCRUD</title>
</head>

<body>

    <div class="row">
        <div class="col-sm-12 mt-1 mb-5">
            <div class="container card ">
                <br>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Usuarios x Cores</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Usuarios</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Cores</button>
                    </li>
                </ul>

                <div class="tab-content hc" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="row">
                            <div class="col-6 col-sm-12 mt-5 mb-5">
                                <div class="container card  mt-3 mb-3">
                                    <h1 class="text-center">Usu x Cores</h1>
                                    <table id="DatatablesUsuXCor" class="table display" style="width: 100%;">
                                        <thead>
                                            <tr scope="row">
                                                <th  scope="col-sm-1">ID</th>
                                                <th  scope="col-sm-3">Nome</th>
                                                <th  scope="col-sm-3">Email</th>
                                                <th  scope="col-sm-2">Color</th>
                                                <th class="col-sm-3 d-flex justify-content-center">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div class="row">
                            <div class="col-sm-12 mt-5 mb-5">
                                <div class="container card bordered mb-10">
                                    <h1 class="text-center">Usuarios Cadastrados</h1>
                                    <table id="DatatablesUsu" class="table display">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-3 text-init">ID</th>
                                                <th class="col-sm-3 text-init">Nome</th>
                                                <th class="col-sm-3 text-init">Email</th>
                                                <th class="col-sm-3 text-center" colspan="2">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                    <div class="row">
                        <div class="col-sm-12 mt-5 mb-5">
                            <div class="container card bordered mb-10">
                                <h1 class="text-center">Cores Cadastradas</h1>
                                <table class="table display" id="DatatablesCor">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-2 text-init">ID</th>
                                            <th class="col-sm-6 text-init">Nome</th>
                                            <th class="col-sm-4 text-center" colspan="2">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<footer>

    <div class="container border mt-5 menu_tipo_mobile">
        <div class="row d-flex " style="height: 30px;"></div>
        <div class="row d-flex ">

            <div class="col-4 d-flex justify-content-center">
                <a class="link-hover" onclick="abreModalUsuarios();">
                    <div class="b-block">
                        <div class="d-flex justify-content-center"><ion-icon name="person-outline" size="large"></ion-icon></div>
                        <div class="justify-content-center"> <span class="text"> USUARIO </span></div>
                    </div>
                </a>
            </div>

            <div class="col-4 d-flex justify-content-center">
                <a class="link-hover" href="#" onclick="abreModalCor(); ">
                    <div class="b-block">
                        <div class="d-flex justify-content-center"><ion-icon name="star-half-outline" size="large"></ion-icon></div>
                        <div class="justify-content-center"> <span class="text"> COR </span> </div>
                    </div>
                </a>
            </div>

            <div class="col-4 d-flex justify-content-center ">
                <a class="link-hover" onclick="abreModalUsuarioXcor();">
                    <div class="b-block">
                        <div class="d-flex justify-content-center"><ion-icon name="settings-outline" size="large"></ion-icon></div>
                        <div class="justify-content-center"> <span class="text"> US/COR </span> </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</footer>

</html>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    
    <script src="crudJS/crudUsuariosXcor.js"></script>
    <script src="crudJS/crudCores.js"></script>
    <script src="crudJS/crudUsuarios.js"></script>
    <script src="crudJS/DataTabes.js"></script>