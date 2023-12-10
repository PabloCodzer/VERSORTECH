$('#DatatablesUsuXCor').on('click', '.excluiUsuCor', function () {
    var idUsuCor = $(this).data('id');
    excluirUsuarioxCor(idUsuCor);
});

$('#DatatablesUsuXCor').on('click', '.editaUsuCor', function () 
{
    var idUsuCor = $(this).data('id');
    consultaIdUsuario(idUsuCor);
});

async function consultaIdUsuario(idUsuCor)
{
    axios_confi= {
        method: "POST",
        headers: { 'Content-Type': 'application/json'},
        data: {idUsuCor: idUsuCor} 
    }

    await axios('http://localhost:7070/consultaUsuXCor', axios_confi)
    .then(res => {
        console.log(res.data);
        const id = res.data[0]['id'];
        const idUsu = res.data[0]['user_id'];
        const idCor = res.data[0]['color_id'];
        abreModalUsuarioXcor(id, idUsu, idCor);
    });
}


function abreModalUsuarioXcor(id = '', id_usu = '', id_color='')
{
    var id_modalUsuarios = document.getElementById('usuarioXcor');
    var ModalUsuariosxCores = new bootstrap.Modal(id_modalUsuarios);
    var setTitulo = document.getElementById('usuarioXcor_edita');
    var BotaoTexto = document.getElementById('BcorEditaUXC');
    
    var id_uxc = document.getElementById('id_uxc');
    var id_Use = document.getElementById('id_Use');
    var id_Cor = document.getElementById('id_Cor');


    var coresC = document.getElementById('cores');
    var colors_diponiveis = document.getElementById('colors_diponiveis');
    var aviso_erro_usescores = document.getElementById('aviso_erro_usescores');

    coresC.classList.remove('text-danger');
    colors_diponiveis.classList.remove('error');
    aviso_erro_usescores.innerHTML = "";

    var usuas = document.getElementById('usuas');
    var usu_disponiveis = document.getElementById('usu_disponiveis');
    var aviso_erro_usuas = document.getElementById('aviso_erro_usuas');

    usuas.classList.remove('text-danger');
    usu_disponiveis.classList.remove('error');
    aviso_erro_usuas.innerHTML = "";

    if(id === '' || id_usu === '' || id_color ==='')
    {
        setTitulo.innerHTML = '<b> Cadastra Usuario x Cor !!</b>';
        BotaoTexto.innerHTML = 'CADASTRAR';

        id_Cor.value = id_color;
        id_Use.value = id_usu;
        id_uxc.value = id;
     
        inflaSelectCores();
        inflaSelectUsuarios();
    }
    else
    {
        setTitulo.innerHTML = '<b> Edita Usuario x Cor !!</b>';
        BotaoTexto.innerHTML = 'EDITAR';
     
        id_Cor.value = id_color;
        id_Use.value = id_usu;
        id_uxc.value = id;

        inflaSelectCores(id_color);
        inflaSelectUsuarios(id_usu);
    }
    ModalUsuariosxCores.show();
    
}


function inflaSelectCores(cor_id="")
{
    var cores_drop = document.getElementById('colors_diponiveis');
    cores_drop.innerHTML = '';
    cores_drop.innerHTML += '<option value="">Selecione uma Cor</option>';
    var cor_selecionada = "";

    axios.get('http://localhost:7070/cores_todos')
    .then(response => {
        var corSelect = [];
        var coresDrop = response.data;
        for (i = 0; i < coresDrop.length; i = i + 1) {
            corSelect[i] = coresDrop[i];
        }
        corSelect.forEach(cores => {
           cores_drop.innerHTML += '<option value="'+cores.id+'">'+cores.name+'</option>';
           if ( cor_id == cores.id)
           {
                cor_selecionada = cores.id
           }
        });
        cores_drop.value = cor_selecionada;
    });
}

function inflaSelectUsuarios(usuario_id="")
{
    var usuarios_drop = document.getElementById('usu_disponiveis');
    usuarios_drop.innerHTML = '<option value="">Selecione um Usuario</option>';
    var usuario_selecionada = "";

    axios.get('http://localhost:7070/usuarios_todos')
    .then(response => {
        var usuSelect = [];
        var userDrop = response.data;
        for (i = 0; i < userDrop.length; i = i + 1) 
        {
            usuSelect[i] = userDrop[i];
        }
        usuSelect.forEach(usu => {
            usuarios_drop.innerHTML += '<option value="'+usu.id+'">'+usu.name+'</option>';
            if ( usuario_id == usu.id)
            {
                usuario_selecionada = usu.id
            }
        });
        usuarios_drop.value = usuario_selecionada;
    });
}


function inseEditUsuxCor()
{
    var idUsu = document.getElementById('usu_disponiveis');
    var idCor = document.getElementById('colors_diponiveis');
    var idUxC = document.getElementById('id_uxc');
 
  
    if( idCor.value =="" || idUsu.value == "")
    {
        validacao( idCor, idUsu );
    }
    else 
    {
        inserecadastroUsuxCor(idUsu.value, idCor.value, idUxC.value);
    }
}

async function inserecadastroUsuxCor(idUsu, idCor, idUxC)
{
    if( idUxC === "" )
    {
        const axios_confi= {
            method: "POST",
            headers: { 'Content-Type': 'application/json'},
            data: {
                idUsu    : idUsu, 
                idCor    : idCor,
                idUxC    : idUxC
            }
        };
        await axios('http://localhost:7070/insUsuXCor', axios_confi)
            .then(response => {
                alertaToat(response.data)
            })
            .catch(error => {
                console.error('Erro na solicitação: Cadastro Usuario Cor', error);
            }); 
    }        
    else
    {
        const axios_confi= {
            method: "PATCH",
            headers: { 'Content-Type': 'application/json'},
            data: {
                idUsu    : idUsu, 
                idCor    : idCor,
                idUxC    : idUxC
            }
        };
        await axios('http://localhost:7070/EditUsuXCor', axios_confi)
            .then(response => {
                alertaToat(response.data);
            })
            .catch(error => {
                console.error('Erro na solicitação: Cadastro Usuario Cor', error);
            }); 
    }

}

function alertaToat(data)
{
    eStatos = data;
    erro = data;

    if(eStatos['sucesso'])
    {
        Swal.fire({
            title: eStatos['sucesso'],
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) 
            {
                window.location.reload();
            }
          });
    }
    else
    {
        Swal.fire({
            title: erro['erro'],
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) 
            {
                window.location.reload();
            }
          });
    }   
}


function validacao( idCor, idUsu )
{
    var usuas = document.getElementById('usuas');
    var usu_disponiveis = document.getElementById('usu_disponiveis');
    var aviso_erro_usuas = document.getElementById('aviso_erro_usuas');

    var coresC = document.getElementById('cores');
    var colors_diponiveis = document.getElementById('colors_diponiveis');
    var aviso_erro_usescores = document.getElementById('aviso_erro_usescores');

    coresC.classList.remove('text-danger');
    colors_diponiveis.classList.remove('error');
    aviso_erro_usescores.innerHTML = "";

    usuas.classList.remove('text-danger');
    usu_disponiveis.classList.remove('error');
    aviso_erro_usuas.innerHTML = "";

    if(idCor.value == "")
    {
        coresC.classList.add('text-danger');
        colors_diponiveis.classList.add('error');
        aviso_erro_usescores.innerHTML =  "<span class='text-danger'> campo cor não pode ficar em branco !!</span>";
    }

    if(idUsu.value == "")
    {
        usuas.classList.add('text-danger');
        usu_disponiveis.classList.add('error');
        aviso_erro_usuas.innerHTML = "<span class='text-danger'> campo Usuario não pode ficar em branco !!</span>";
    }
}

function excluirUsuarioxCor(id)
{
    Swal.fire({
        title: "Deleta Usu X Cor",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
        cancelButtonText: 'CANCELA',
      }).then((result) => {
        if (result.isConfirmed) 
        {
            delUsuXCor(id);
        }
    });
}


async function delUsuXCor(idUxC)
{
    config_axios = {
        method: "DELETE",
        headers: { 'Content-Type': 'application/json'},
        data: {
            idUxC    : idUxC
        }
    };

    await axios('http://localhost:7070/excluiUsuxCor', config_axios)
    .then(res =>{
        alertaToat(res.data);
    });
}