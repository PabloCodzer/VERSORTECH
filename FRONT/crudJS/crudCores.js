//----------------------------------------------------------------
$('#DatatablesCor').on('click', '.excluiCor', function () {
    var idCor = $(this).data('id');
    deletaCor(idCor);
    console.log("Excluir Cor - ID: ", idCor);
});
$('#DatatablesCor').on('click', '.editaCor', function () 
{
    var idCor = $(this).data('id');
    buscaCorId(idCor);
    console.log(nomeCor);
});


async function buscaCorId(idCor)
{
    const axiosConfig = {
        method: 'POST',
        data: {  idCor: idCor},
        headers: { 'Content-Type': 'application/json'},
    };
    const cor = await axios('http://localhost:7070/usuarios_x_cores', axiosConfig)
            .then(response => {
                const id = response.data[0]['id'];
                const nome = response.data[0]['name'];
                abreModalCor(id,nome);
                return response;
            })
            .catch(error => {
                console.error('Erro na solicitação:', error);
            });
            return cor;
}

function abreModalCor(corId = '', corNome='') 
{
    var id_modalCadastracor = document.getElementById('cadastra_cor');
    var ModalCor = new bootstrap.Modal(id_modalCadastracor);
    var setTitulo = document.getElementById('cadastra_edita_cor');
    var BotaoTexto = document.getElementById('BcorEditaC');
    var nomeCor = document.getElementById('nomeCor');
    var idcor = document.getElementById('idCor');
    var aviso_erro = document.getElementById('aviso_erro');
    var LabelCorErro =  document.getElementById('LabelCorErro');

    nomeCor.classList.remove('error');
    aviso_erro.innerHTML = '';
    LabelCorErro.classList.remove('text-danger');

    if(corId === '' || corNome === '')
    {
        setTitulo.innerHTML = '<b> Cadastra Nova Cor !!</b>';
        BotaoTexto.innerHTML = 'CADASTRAR';
        nomeCor.value = '';
        idcor.value = '';
    }
    else
    {
        setTitulo.innerHTML = '<b> Edita Cor !!</b>';
        BotaoTexto.innerHTML = 'EDITAR';
        nomeCor.value = corNome;
        idcor.value = corId;
    }
    ModalCor.show();
}

function CadastraOuEdit()
{
    var nomeCor = document.getElementById('nomeCor');
    var idcor = document.getElementById('idCor');
    var aviso_erro = document.getElementById('aviso_erro');
    var LabelCorErro =  document.getElementById('LabelCorErro');
 
    if (nomeCor.value == '')
    {
        nomeCor.classList.add('error');
        LabelCorErro.classList.add('text-danger');
        aviso_erro.innerHTML = "<span class='text-danger'> campo necessario !!</span>"
    }
    else
    {
        aviso_erro.innerHTML = '';
        nomeCor.classList.remove('error');
        LabelCorErro.classList.remove('text-danger');
        CadastraCor(idcor.value, nomeCor.value);
    }
}

async function CadastraCor(idCor, nomeCor)
{
    if(idCor === "" )
    {
        const axiosConfig = {
            method: 'POST',
            data: {  idCor: idCor, nomeCor: nomeCor},
            headers: { 'Content-Type': 'application/json'},
        };
        await axios('http://localhost:7070/cadastroCor', axiosConfig)
        .then(response => {
            alertColor(response.data)
        })
        .catch(error => {
            console.error('Erro na solicitação:', error);
        });
    }
    else
    {
        console.log("edita a cor: "+nomeCor);
        const axiosConfig = {
            method: 'PATCH',
            data: {  idCor: idCor, nomeCor: nomeCor},
            headers: { 'Content-Type': 'application/json'},
        };
        await axios('http://localhost:7070/editaCor', axiosConfig)
        .then(response => {
            alertColor(response.data)
        })
        .catch(error => {
            console.error('Erro na solicitação:', error);
        });
    }
}


function alertColor(data)
{
    console.log(data);
    eStatos = data;
    var nomeCor = document.getElementById('nomeCor');
    var aviso_erro = document.getElementById('aviso_erro');
    var LabelCorErro =  document.getElementById('LabelCorErro');

    nomeCor.classList.remove('error');
    aviso_erro.innerHTML = '';
    LabelCorErro.classList.remove('text-danger');

    if(!eStatos['erro'])
    {
        alertCadastroColor(eStatos);
    }
    else
    {
        nomeCor.classList.add('error');
        LabelCorErro.classList.add('text-danger');
        aviso_erro.innerHTML = "<span class='text-danger'> "+eStatos['erro']+" !!</span>";
        alert(erro);
    }   
}

function alertCadastroColor(data)
{
    status_castroCor = data;
    eStatos =  data;
    console.log("alertCadastroColor :"+eStatos['sucesso']);

    console.log(eStatos);
    erro = status_castroCor['erro'];
    var nomeCor = document.getElementById('nomeCor');
    var aviso_erro = document.getElementById('aviso_erro');
    var LabelCorErro =  document.getElementById('LabelCorErro');

    nomeCor.classList.remove('error');
    aviso_erro.innerHTML = '';
    LabelCorErro.classList.remove('text-danger');

    if(eStatos)
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
        nomeCor.classList.add('error');
        LabelCorErro.classList.add('text-danger');
        aviso_erro.innerHTML = "<span class='text-danger'> "+erro+" !!</span>";
    }   
}


function deletaCor(idCor)
{
    Swal.fire({
        title: "Deleta Cor",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
        cancelButtonText: 'CANCELA',
      }).then((result) => {
        if (result.isConfirmed) 
        {
            DelCor(idCor);
        }
      });
}


async function DelCor(idCor)
{
    const axiosConfig = {
        method: 'DELETE',
        data: {  idCor: idCor},
        headers: { 'Content-Type': 'application/json'},
    };

    await axios('http://localhost:7070/ExcluiCor', axiosConfig)
        .then(response => {
            console.log(response.data);
            alertCadastroColor(response.data)
        })
        .catch(error => {
            console.error('Erro na solicitação: DELETE COR', error);
        });
}
