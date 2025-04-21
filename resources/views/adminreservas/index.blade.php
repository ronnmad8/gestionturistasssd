@extends('base')
@section('content')



<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-2 col-12">
                <h2>RESERVAS</h2>
            </div>
        </div>

        <div class="row ">
            <div class="mx-1 formulariocita" style="min-width: 100px" >
                <p class="m-0">Fecha</p>
                <input class="form-control  mx-1" id="Cfecha" type="date"  >
            </div>
            <div class="mx-1 formulariocita" style="min-width: 150px">
                <p class="m-0">Visitas</p>
                <select class="form-control  mx-1" id="CVisits" >
                    <option value="">-</option>
                    @foreach($visits as $visit)
                    <option value="{{$visit['id']}}">
                        {{$visit['name']}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mx-1 formulariocita" style="min-width: 100px">
                <p class="m-0">Idiomas</p>
                <select class="form-control mx-1" id="CIdiomas" value="">
                    <option value="">-</option>
                    @foreach($languages as $idioma)
                    <option value="{{$idioma['id']}}">
                        {{$idioma['name']}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mx-1 formulariocita" style="min-width: 100px">
                <p class="m-0">Guias</p>
                <select class="form-control mx-1" id="CGuias" value="">
                    <option value="">-</option>
                    @foreach($guias as $guia)
                    <option value="{{$guia['id']}}">
                        {{$guia['name']}}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>

    </div>

    <div class="py-2 my-2" id="pags">
       
    </div>

    <div class="table-responsive mxh" >
        <table class="table table-hover scroll" id="tablaAdminvisitas">
            <thead>
                <tr>

                    <th style="min-width: 150px">ACCIONES</th>
                    <th style="min-width: 100px">REF</th>
                    <th style="min-width: 200px">GUÍA</th>
                    <th style="min-width: 200px">CLIENTE</th>
                    <th style="min-width: 300px">VISITA</th>
                    <th style="min-width: 100px">IDIOMA</th>
                    <th style="min-width: 150px">FECHA</th>
                    <th style="min-width: 100px"><span> PRECIO €</span></th>
                    <th style="min-width: 100px">HORA</th>
                    <th style="min-width: 150px"><div><i class="mr-1 fa fa-users"></i>PERSONAS</div></th>
                    <th style="min-width: 150px"><i class="mr-1 fa fa-users"></i>ADULTOS</div></th>
                    <th style="min-width: 150px"><i class="mr-1 fa fa-users"></i>NIÑOS</div></th>
                    <th style="min-width: 50px">PRIVADA</th>
                    <th style="min-width: 100px">ESTADO</th>
                    <th style="min-width: 200px">PEDIDO</th>

                </tr>
            </thead>
            <tbody id="body_table"   >


                @foreach($adminreservas as $key => $c)
                <tr id="tr-{{$c->id}}" class="trreservas">

                    <td style="min-width: 150px;">
                        <button type='button' id='edit-{{$c->id}}' class='editar btn btn-warning py-0'>
                            <i class='fa fa-cog' style="color: #fff"></i>
                        </button>
                        <button type='button' id='delete-{{$c->id}}' class='btdelete btn btn-danger py-0'>
                            <i class='fa fa-trash' style="color: #fff"></i>
                        </button>
                    </td>
                    <td style='width: 100px'>
                        <div id='Eid-{{$c->id}}'>{{$c->id}}</div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Eguia-{{$c->id}}'>
                        @foreach($guias as $guia)
                            @if($guia->id == $c->guia_id )
                                {{ $guia->name }} - {{ $guia->email }} <br>
                            @endif
                        @endforeach
                        </div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Euser-{{$c->id}}'>{{$c->user->name ?? ""}}</div>
                    </td>
                    <td style='width: 300px'>
                        <div id='Evisit-{{$c->id}}'>{{$c->visit->name}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Elanguage-{{$c->id}}'>{{$c->language->name}}</div>
                    </td>
                    <td style='width: 150px'>
                        <div id='Efecha-{{$c->id}}'>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Etotal-{{$c->id}}'>{{$c->total}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Ehora-{{$c->id}}'>{{$c->hour->hora}}</div>
                    </td>
                    <td style='width: 150px'>
                        <div id='Epersons-{{$c->id}}'>{{$c->persons}}</div>
                    </td>
                    <td style='width: 150px'>
                        <div id='Eadults-{{$c->id}}'>{{$c->adults}}</div>
                    </td>
                    <td style='width: 150px'>
                        <div id='Echildren-{{$c->id}}'>{{$c->children}}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Eprivada-{{$c->id}}'>{{$c->private == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Eestado-{{$c->id}}'>{{$c->status == 1 ? 'Cerrada' : 'Abierta'  }}</div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Epedido-{{$c->id}}'>ref {{$c->pedido->id }} - total {{$c->pedido->totalfinal}} € </div>
                    </td>

                    <div class="dnone" hidden>
                        <div id='Eguia_id-{{$c->id}}'>{{$c->guia_id}}</div>
                        <div id='Euser_id-{{$c->id}}'>{{$c->user_id}}</div>
                        <div id='Euuid-{{$c->id}}'>{{$c->uuid}}</div>
                        <div id='Evisit_id-{{$c->id}}'>{{$c->visit_id}}</div>
                        <div id='Elanguage_id-{{$c->id}}'>{{$c->language_id}}</div>
                        <div id='Evisit_hours_id-{{$c->id}}'>{{$c->visit_hours_id}}</div>
                        <div id='Estatus-{{$c->id}}'>{{$c->status}}</div>
                        <div id='Eprivate-{{$c->id}}'>{{$c->private}}</div>
                        
                        <div id='Emodel-{{$c->id}}'>
                            {{json_encode($c)}}
                        </div>
                    </div>

                </tr>

                @endforeach
            </tbody>
            <tfoot>
                <tr>

                    <th style="min-width: 150px">ACCIONES</th>
                    <th style="min-width: 100px">REF</th>
                    <th style="min-width: 200px">GUÍA</th>
                    <th style="min-width: 200px">CLIENTE</th>
                    <th style="min-width: 300px">VISITA</th>
                    <th style="min-width: 100px">IDIOMA</th>
                    <th style="min-width: 150px">FECHA</th>
                    <th style="min-width: 100px"><span> PRECIO €</span></th>
                    <th style="min-width: 100px">HORA</th>
                    <th style="min-width: 150px"><div><i class="mr-1 fa fa-users"></i>PERSONAS</div></th>
                    <th style="min-width: 150px"><i class="mr-1 fa fa-users"></i>ADULTOS</div></th>
                    <th style="min-width: 150px"><i class="mr-1 fa fa-users"></i>NIÑOS</div></th>
                    <th style="min-width: 50px">PRIVADA</th>
                    <th style="min-width: 100px">ESTADO</th>
                    <th style="min-width: 200px">PEDIDO</th>

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

        <div id="lista_languages" data-languages="{{ json_encode($languages) }}">
        </div>
        <div id="lista_guias" data-languages="{{ json_encode($guias) }}">
        </div>
        <div id="lista_visits" data-visits="{{ json_encode($visits) }}">
        </div>
        <div id="adminreservas" data-adminreservas="{{ json_encode($adminreservas) }}">
        </div>
    </div>

</div>

<div>
    <button type='button' class="dnone" id='abrirModalX' data-toggle='modal' data-target='#modalX'
        data-backdrop='static' data-keyboard='false'>
    </button>
    <div class='modal fade' id='modalX'>

        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title text-center'>
                        <span> DATOS RESERVA </span>
                    </h4>
                    <button id="btcloseeditar" type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='w100 formulariomodal'>

                        <div class="dnone">
                            <input id="Cid" name='id'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Usuario</p>
                            <select class="form-control" id="Cusuario" name="usuario" >
                            @foreach ($users as $user)
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Idiomas</p>
                            <select class="form-control" id="Clanguage" name="language" >
                            @foreach ($languages as $language)
                              <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="my-2 mx-auto">
                            <p class="m-0">Adultos</p>
                            <input type="number" id="Cadults" name="adults" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Niños</p>
                            <input type="number" id="Cchildren" name="children" class='form-control'>
                        </div>

                        <div class="my-2 mx-auto">
                            <p class="m-0">Privada</p>
                            <select class="form-control" id="Cprivate" name="Cprivate">
                                <option value="0" selected>NO</option>
                                <option value="1" selected>SI</option>
                            </select>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Estado</p>
                            <select class="form-control" id="Cstatus" name="Cstatus">
                                <option value="0" selected>Abierto</option>
                                <option value="1" selected>Cerrado</option>
                            </select>
                        </div>

                        <div class="m10 mxauto text-center">
                            <button type="button" id="bteditarX" class='m-2 btn btn-info'>GUARDAR</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>


let visitsData = $('#lista_visits').data('visits') || [];
let guiasData = $('#lista_guias').data('guias') || [];
let languagesData = $('#lista_languages').data('languages') || [];
let listaadminreservas = $('#adminreservas').data('adminreservas')["data"] || [];

$('.menu').removeClass('activ');
$("#linkadminreservas").addClass('activ');

/// pagination

const tablaAdminvisitasBody = document.getElementById('body_table');
const paginationContainer = document.getElementById('pagination-container');
const citasPorPagina = 8;
let currentPage = 1;
let listaFiltradaParaPaginacion = [...listaadminreservas]; 
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

$(".editar").on('click', function() {
    let id = $(this).attr('id').split('-')[1];
    let user_id = $('#Euser_id-' + id).text();
    let language_id = $('#Elanguage_id-' + id).text() || "";
    let adults = parseInt($('#Eadults-' + id).text());
    let children = parseInt($('#Echildren-' + id).text());
    let private = $('#Eprivate-' + id).text() || "0";
    let status = $('#Estatus-' + id).text() || "0";
    let model = $('#Emodel-' + id).text();
    let visitObject = JSON.parse(model);
    
    console.log("model visita ==> ",visitObject);

    $('#Cid').val(id);
    $('#Cusuario').val(user_id);
    $('#Clanguage').val(language_id);
    $('#Cadults').val(adults);
    $('#Cchildren').val(children);
    $('#Cprivate').val(private);
    $('#Cstatus').val(status);

    $('#abrirModalX').click();
    $('#form-data-display').removeClass('oculto');
    updateFormData();
    
});






///////////////////////////////////////////////////////calls ajax

//bteditarX
$("#bteditarX").on('click', function() {
    var create = false;
    let urlaccion = "{{ route('adminreservas/updatereserva')}}";
    let idreserva = $('#Cid').val();

    let formData = {
        id: idreserva,
        user_id: $('#Cusuario').val(),
        language_id: $('#Clanguage').val(),
        adults: $('#Cadults').val(),
        children: $('#Cchildren').val(),
        private: $('#Cprivate').val(),
        status: $('#Cstatus').val()
    }
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: urlaccion,
            data: formData,
            dataType: "json",
            method: "POST",
            success: function(result) {
                if(result != null){
                    let id = result["id"];
                    $("#Euser-" + id).text(result["user.name"]);
                    $("#Elanguage-" + id).text(result["language.name"]);
                    $("#Eadults-" + id).text(result["adults"]);
                    $("#Epersons-" + id).text(result["persons"]);
                    $("#Echildren-" + id).text(result["children"]);
                    $("#Eprivate-" + id).text(result["private"]);
                    $("#Estatus-" + id).text(result["status"]);
                }
            },
            fail: function() {
                alert("fail");
            },
            beforeSend: function() {
                $('#btcloseeditar').click();
                $("#loading-spinner").show();
            },
            complete: function() {
                $("#loading-spinner").hide();
            }
        });

    } catch (error) {
        console.err(error);
    }

});


$(".btdelete").on('click', function() {
    let idtodelete = $(this).attr('id').split('-')[1]; 
    var formData = {
        id: idtodelete
    }
    if (confirm('¿Estás seguro de que quieres eliminar este registro?')) {
      try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/adminreservas/deletereserva',
            data: formData,
            dataType: "json",
            method: "POST",
            success: function(result) {
                if(result != null){
                    location.reload();
                }
            },
            fail: function() {
                alert("fail");
            },
            beforeSend: function() {
                $("#loading-spinner").show();
            },
            complete: function() {
                $("#loading-spinner").hide();
            }
        })
      }catch (error) {
        console.err(error);
      }
    }
});


$(function () {

    $(document).on('change', '#CIdiomas', function () {
        setTable();
    });
    $(document).on('change', '#CGuias', function () {
        setTable();
    });
    $(document).on('change', '#CVisits', function () {
        setTable();
    });
    $(document).on('change', '#CFecha', function () {
        setTable();
    });


});

function setTable(){
    
    let idiomasFiltrar = $('#CIdiomas').val();
    let fechaFiltrar = $('#CFecha').val();
    let visitaFiltrar = $('#CVisits').val();
    let guiaFiltrar = $('#CGuias').val();
    let filtAdminreservasTable = [] ;
    filtAdminreservasTable = listaadminreservas ?? [] ;
    if( fechaFiltrar != "" && fechaFiltrar != null){
        filtAdminreservasTable = filtAdminreservasTable.filter(res => res.fecha == fechaFiltrar)  ?? [] ;
    }
    if( visitaFiltrar != "" && visitaFiltrar != null){
        filtAdminreservasTable = filtAdminreservasTable.filter(res => res.visit_id == parseInt(visitaFiltrar))  ?? [] ;
    }
    if( idiomasFiltrar != "" && idiomasFiltrar != null){
        filtAdminreservasTable = filtAdminreservasTable.filter(res => res.language_id == parseInt(idiomasFiltrar))  ?? [] ;
    }
    if( guiaFiltrar != "" && guiaFiltrar != null){
        filtAdminreservasTable = filtAdminreservasTable.filter(res => res.guia_id == parseInt(guiaFiltrar))  ?? [] ;
    }

    console.log("filtAdminreservasTable ", filtAdminreservasTable);

    $('.trreservas').removeClass('dnone');
    listaadminreservas.forEach( reserva => { 
        if(!filtAdminreservasTable.includes(reserva))
        {
            $('#tr-'+reserva.id).addClass('dnone');
        }
    });

    console.log("filtAdminreservasTable ", filtAdminreservasTable);

    mostrarPagina(currentPage);
    generarBotonesPaginacion();
}


</script>


<!-----test formulario----->
<style>
        #form-data-display {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            z-index: 99999;
            height: 500px !important;
            overflow-x: auto;
            overflow-y: auto;
        }

        .oculto{
            display: none;
        }
</style>

<div id="form-data-display" style="display: none"  >
        <h3>Valores del formulario</h3>
        <span>Usuario: </span><span id="displayUser"></span><br>
        <span>Idioma: </span><span id="displayLanguage"></span><br>
        <span>Adultos: </span><span id="displayAdults"></span><br>
        <span>Niños:</span><span id="displayChildren"></span><br>
        <span>Privado:</span><span id="displayPrivate"></span><br>
        <span>Estado:</span><span id="displayStatus"></span><br>

    </div>

    <script>
            // Función para actualizar los valores en el div
            function updateFormData() {
                
                $('#displayUser').text('' + $('#Cusuario').val());
                $('#displayLanguage').text('' + $('#Clanguage').val());
                $('#displayAdults').text('' + $('#Cadults').val());
                $('#displayChildren').text('' + $('#Cchildren').val());
                $('#displayPrivate').text('' + $('#Cprivate').val());
                $('#displayStatus').text('' + $('#Cstatus').val());

            }
            $('.formulariomodal input, .formulariomodal select').on('input change', function () {
                updateFormData();
            });

            $('#btcloseeditar').on('click', function (){
                $('#form-data-display').addClass('oculto');
            })


    </script>


@stop