@extends('base')
@section('content')



<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-2 col-12">
                <h2>HISTORICOS</h2>
            </div>
        </div>
        <div class="row ">
            <div class="col-xl-4 my-1 d-flex">
                <div class="mx-1 formulariocita" style="min-width: 100px" >
                    <p class="m-0">Desde</p>
                    <input class="form-control  mx-1" id="CfechaDesde" type="date"  >
                </div>
                <div class="mx-1 formulariocita" style="min-width: 100px" >
                    <p class="m-0">Hasta</p>
                    <input class="form-control  mx-1" id="CfechaHasta" type="date"  >
                </div>
            </div>
        </div>
    </div>

    <div class="py-2 my-2" id="pags">
       
    </div>

    <div class="table-responsive mxh" >
        <table class="table table-hover scroll" id="tablaAdminhistorics">
            <thead>
                <tr>

                    <th style="min-width: 50px">REF</th>
                    <th style="min-width: 100px">FECHA</th>
                    <th style="min-width: 200px">INFORMACION</th>

                </tr>
            </thead>
            <tbody id="body_table"   >


                @foreach($adminhistorics as $key => $c)
                <tr id="tr-{{$c->id}}" class="trhistorics">

                    <td style='width: 50px'>
                        <div id='Eid-{{$c->id}}'>{{$c->id}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Efecha-{{$c->id}}'>{{$c->fecha}}</div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Edata-{{$c->id}}'>{{$c->data}}</div>
                    </td>

                    <div class="dnone" hidden>
                        
                        <div id='Emodel-{{$c->id}}'>
                            {{json_encode($c)}}
                        </div>
                    </div>

                </tr>

                @endforeach
            </tbody>
            <tfoot>
                <tr>

                    <th style="min-width: 50px">REF</th>
                    <th style="min-width: 100px">FECHA</th>
                    <th style="min-width: 200px">INFORMACION</th>
                    
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row mx-auto">   
        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination" id="pagination-container">
                    </ul>
            </nav>
        </div>
    </div>

    <div class="dnone">

        <div id="lista_adminhistorics" data-adminhistorics="{{ json_encode($adminhistorics) }}">
        </div>

    </div>

</div>


<script>

let listaadminhistorics= $('#lista_adminhistorics').data('adminhistorics') || [];

$('.menu').removeClass('activ');
$("#linkadminhistorics").addClass('activ');

/// pagination

const tablaAdminvisitasBody = document.getElementById('body_table');
const paginationContainer = document.getElementById('pagination-container');
const citasPorPagina = 10;
let currentPage = 1;
let listaFiltradaParaPaginacion = [...listaadminhistorics]; 
setTable();

function mostrarPagina(pagina) {
    const startIndex = (pagina - 1) * citasPorPagina;
    const endIndex = startIndex + citasPorPagina;

    tablaAdminvisitasBody.querySelectorAll('tr').forEach((row, index) => {
        row.style.display = 'none';
    });

    for (let i = startIndex; i < endIndex && i < listaFiltradaParaPaginacion.length; i++) {
        const citaId = listaFiltradaParaPaginacion[i].id;
        const row = document.getElementById(`tr-${citaId}`);
        if (row) {
            row.style.display = '';
        }
    }

    generarBotonesPaginacion();
}

function getIndiceCita(citaId) {
    return listaFiltradaParaPaginacion.findIndex(cita => cita.id === citaId);
}

function generarBotonesPaginacion() {
    paginationContainer.innerHTML = '';
    const totalPaginas = Math.ceil(listaFiltradaParaPaginacion.length / citasPorPagina);

    for (let i = 1; i <= totalPaginas; i++) {
        const li = document.createElement('li');
        li.className = 'page-item ' + (i === currentPage ? 'active' : '');
        const button = document.createElement('button');
        button.className = 'page-link';
        button.textContent = i;
        button.addEventListener('click', () => {
            currentPage = i;
            mostrarPagina(currentPage);
        });
        li.appendChild(button);
        paginationContainer.appendChild(li);
    }
}

//functions




$("#btfiltrar").on('click', function() {
    setTable();

});



///////////////////////////////////////////////////////calls ajax



$(function () {
    $(document).on('change', '#CfechaDesde', function () {
        setTable();
    });
    $(document).on('change', '#CfechaHasta', function () {
        setTable();
    });
});


function setTable(){

    let fechaDesdeFiltrar = $('#CfechaDesde').val();
    let fechaHastaFiltrar = $('#CfechaHasta').val();
    let filtAdminHistoricsTable = [] ;
    filtAdminHistoricsTable = listaadminhistorics ?? [] ;

    if( fechaDesdeFiltrar != "" && fechaDesdeFiltrar != null){
        filtAdminHistoricsTable = filtAdminHistoricsTable.filter(res => {
        const fechaRes = new Date(res.fecha);
        const anio = fechaRes.getFullYear();
        const mes = (fechaRes.getMonth() + 1).toString().padStart(2, '0');
        const dia = fechaRes.getDate().toString().padStart(2, '0');
        const fechaResDesdeFormateada = `${anio}-${mes}-${dia}`;
        return fechaResDesdeFormateada >= fechaDesdeFiltrar;
        }) ?? [];
    }
    if( fechaHastaFiltrar != "" && fechaHastaFiltrar != null){
        filtAdminHistoricsTable = filtAdminHistoricsTable.filter(res => {
        const fechaRes = new Date(res.fecha);
        const anio = fechaRes.getFullYear();
        const mes = (fechaRes.getMonth() + 1).toString().padStart(2, '0');
        const dia = fechaRes.getDate().toString().padStart(2, '0');
        const fechaResHastaFormateada = `${anio}-${mes}-${dia}`;
        return fechaResHastaFormateada <= fechaHastaFiltrar;
        }) ?? [];
    }

    $('.trhistorics').removeClass('dnone');
    listaadminhistorics.forEach( c => { 
        if(!filtAdminHistoricsTable.includes(c))
        {
            $('#tr-'+c.id).addClass('dnone');
        }
    });

    listaFiltradaParaPaginacion = [...filtAdminHistoricsTable]
    currentPage = 1;
    mostrarPagina(currentPage);
    generarBotonesPaginacion();

}



</script>





@stop