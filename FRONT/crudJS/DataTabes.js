
$(document).ready(function(){
    CorDataTables();
    UsuDatatable();
    UsuCorTables();
});

function UsuCorTables()
{
    axios.get('http://localhost:7070/usuarios_x_cores')
    .then(response => {
        const usuCor =  response.data;
        const tableUsuCor = $('#DatatablesUsuXCor').DataTable({
        data: usuCor,
        columns: [
            { data: 'id' },
            { data: 'username' },
            { data: 'email' },
            { data: 'colorname' },
            {
                data: null,
                render: function (data, type, row) {
                        
                    return  '<div class="d-flex justify-content-center">'+
                            '<a class="btn btn-dark btn-sm editaCore mx-1 editaUsuCor" data-id="'+row.id+'">Editar</a>'+
                            '<a class="btn btn-danger btn-sm mx-1 excluiUsuCor" data-id="'+row.id+'">Excluir</a></div>';
                },     
                targets: -1
            },
            ]
        });
    });
}



function UsuDatatable()
{
    axios.get('http://localhost:7070/usuarios_todos')
    .then(response => {
        const usuarios =  response.data;
        const tableUsu = $('#DatatablesUsu').DataTable({
        data: usuarios,
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            {
                data: null,
                render: function (data, type, row) {
                        
                    return  '<div class="d-flex justify-content-center">'+
                            '<a class="btn btn-dark btn-sm editaCore mx-1 editaUsu" data-id="'+row.id+'">Editar</a>'+
                            '<a class="btn btn-danger btn-sm mx-1 excluiUsu" data-id="'+row.id+'">Excluir</a></div>';
                },
                targets: -1
            },
            ]
        });

    });

    
}

function CorDataTables()
{
    axios.get('http://localhost:7070/cores_todos')
    .then(response => {
        const cores = response.data;
        const tableCor = $('#DatatablesCor').DataTable({
            data: cores,
            columns: [
                { data: 'id' },
                { data: 'name' },
                {
                    data: null,
                    render: function (data, type, row) {
                        
                        return  '<div class="d-flex justify-content-center">'+
                                '<a class="btn btn-dark btn-sm editaCore mx-1 editaCor" data-id="'+row.id+'">Editar</a>'+
                                '<a class="btn btn-danger btn-sm mx-1 excluiCor" data-id="'+row.id+'">Excluir</a></div>';
                    },
                    targets: -1
                },
            ]
        });    
    })
  
}