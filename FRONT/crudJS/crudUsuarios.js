//----------------------------------------------------------------
$('#DatatablesUsu').on('click', '.excluiUsu', function () {
    var idUsu = $(this).data('id');
    deletaUsuarioAlert(idUsu);
});
$('#DatatablesUsu').on('click', '.editaUsu', function () 
{
    var idUsu = $(this).data('id');
    buscaUsuID(idUsu);
});

async function buscaUsuID(idUsu)
{
    configAxios = {
        method: "POST",
        headers: { 'Content-Type': 'application/json'},
        data: {idUsu: idUsu} 
    }
    await axios('http://localhost:7070/consultaUsu', configAxios)
    .then( res => {
        const id = res.data[0]['id'];
        const email = res.data[0]['email'];
        const nome = res.data[0]['name'];
        abreModalUsuarios(id, nome, email);
    });
}

function abreModalUsuarios(id = '', nome = '', email ='')
{
    var id_modalUsuarios = document.getElementById('ModalCarastroUsuario');
    var ModalUsuarios = new bootstrap.Modal(id_modalUsuarios);
    var setTitulo = document.getElementById('ModalCarastroUsuarioLabel');
    var BotaoTexto = document.getElementById('BcorEditaU');
    var usuario_id = document.getElementById('idUsuario');
    var usuario_nome = document.getElementById('nome_usuario');
    var usuario_email = document.getElementById('email_suario');
    var aviso_erro_email = document.getElementById('aviso_erro_email');
    var aviso_erro_nome = document.getElementById('aviso_erro_nome');
    var label_nome_usuario = document.getElementById('label_nome_usuario');
    var label_email_usuario = document.getElementById('label_email_usuario');
    
    
    aviso_erro_nome.innerHTML = "";
    aviso_erro_email.innerHTML = "";
 
    label_nome_usuario.classList.remove('text-danger');
    label_email_usuario.classList.remove('text-danger');

    usuario_nome.classList.remove('error');
    usuario_email.classList.remove('error');


    if(id === '' || nome === '')
    {
        setTitulo.innerHTML = '<b> Cadastra Usuario !!</b>';
        BotaoTexto.innerHTML = 'CADASTRAR';
        usuario_id.value = '';
        usuario_nome.value = '';
        usuario_email.value = '';
    }
    else
    {
        setTitulo.innerHTML = '<b> Edita Usuario !!</b>';
        BotaoTexto.innerHTML = 'EDITAR';
        usuario_id.value = id;
        usuario_nome.value = nome;
        usuario_email.value = email;
    }
    ModalUsuarios.show();
}


function cadastraEditaUsu()
{
    var nameUsu = document.getElementById('nome_usuario');
    var emailUsu = document.getElementById('email_suario');
    var idUsu = document.getElementById('idUsuario');
    var aviso_erro_email = document.getElementById('aviso_erro_email');
    var aviso_erro_nome = document.getElementById('aviso_erro_nome');

    var label_nome_usuario  = document.getElementById('label_nome_usuario');
    var label_email_usuario = document.getElementById('label_email_usuario');

    if( emailUsu.value == "" )
    {
        label_email_usuario.classList.add('text-danger');
        emailUsu.classList.add('error');
        aviso_erro_email.innerHTML = "<p class='text-danger'> Insira um email ! </p>";
    }
    else
    {
        label_email_usuario.classList.remove('text-danger');
        emailUsu.classList.remove('error');
        aviso_erro_email.innerHTML = "";
    }

    if (nameUsu.value ==  '')
    {
        label_nome_usuario.classList.add('text-danger');
        nameUsu.classList.add('error');
        aviso_erro_nome.innerHTML = "<p class='text-danger'> Insira um Nome ! </p>";
    }
    else
    {
        label_nome_usuario.classList.remove('text-danger');
        nameUsu.classList.remove('error');
        aviso_erro_nome.innerHTML = "";
    }
    
    if( emailUsu.value != "" && nameUsu.value != "")
    {
        insereCadastro(idUsu.value, nameUsu.value, emailUsu.value);
    }
}

async function insereCadastro(idUsu, nomeUsu, emailUsu)
{
    if( idUsu === "" )
    {
        const axiosConfig = {
            method: 'POST',
            data: { nomeUsu: nomeUsu, emailUsu: emailUsu},
            headers: { 'Content-Type': 'application/json'},
        };
    
        await axios('http://localhost:7070/cadastroUsu', axiosConfig)
            .then(response => {
                alertCadastroUusuario(response.data)
            })
            .catch(error => {
                console.error('Erro na solicitação: Cadastro Usuario', error);
            });
    }
    else
    {
        const axiosConfig = {
            method: 'PATCH',
            data: { idUsu:idUsu, nomeUsu: nomeUsu, emailUsu: emailUsu },
            headers: { 'Content-Type': 'application/json'},
        };
    
        await axios('http://localhost:7070/editaUsu', axiosConfig)
            .then(response => {
                alertCadastroUusuario(response.data);
            })
            .catch(error => {
                console.error('Erro na solicitação: Edita Usuario', error);
            });
    }
}


function alertCadastroUusuario(data)
{
    eStatos =  data;
    erro = data['erro'];
    var usuario_nome = document.getElementById('nome_usuario');
    var usuario_email = document.getElementById('email_suario');
    var aviso_erro_email = document.getElementById('aviso_erro_email');
    var aviso_erro_nome = document.getElementById('aviso_erro_nome');
    var label_nome_usuario = document.getElementById('label_nome_usuario');
    var label_email_usuario = document.getElementById('label_email_usuario');
    
    aviso_erro_nome.innerHTML = "";
    aviso_erro_email.innerHTML = "";
 
    label_nome_usuario.classList.remove('text-danger');
    label_email_usuario.classList.remove('text-danger');

    usuario_nome.classList.remove('error');
    usuario_email.classList.remove('error');

    if(!eStatos['erro'])
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
        if(erro === "usuario ja existe")
        {
            aviso_erro_nome.innerHTML = "<p class='text-danger'> "+erro+"! </p>";
            usuario_nome.classList.add('error');
            label_nome_usuario.classList.add('text-danger');
        }
        if(erro === 'email ja existe')
        {
            aviso_erro_email.innerHTML = "<p class='text-danger'> "+erro+"! </p>";
            usuario_email.classList.add('error');
            label_email_usuario.classList.add('text-danger');
        }
        if(erro === 'formato email invalido!')
        {
            aviso_erro_email.innerHTML = "<p class='text-danger'> "+erro+"! </p>";
            usuario_email.classList.add('error');
            label_email_usuario.classList.add('text-danger');
        }
    }   
}


function deletaUsuarioAlert(idUsu)
{
    Swal.fire({
        title: "Deletar Usuario ?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
        cancelButtonText: 'CANCELA',
      }).then((result) => {
        if (result.isConfirmed) 
        {
            DelUsu(idUsu);
        }
      });
}


async function DelUsu(idUsu)
{
    const axiosConfig = {
        method: 'DELETE',
        data: {  idUsu: idUsu},
        headers: { 'Content-Type': 'application/json'},
    };

    await axios('http://localhost:7070/ExcluiUsuario', axiosConfig)
        .then(response => {
            alertCadastroUusuario(response.data)
        })
        .catch(error => {
            console.error('Erro na solicitação: DELETE COR', error);
        });
}
