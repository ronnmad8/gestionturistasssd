@extends('base')
@section('content')



<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-2 col-12">
                <h2>CLIENTES</h2>
            </div>
            <!-- <div class="col-xl-2 col-12">
                <button id="crear" type="button" class="btn btn-dark cupo mb-2" title="buscar">
                    <i class="fa fa-plus mr-2"></i> <small> NUEVA VISITA</small>
                </button>
            </div> -->
        </div>
    </div>

    <div class="py-2 my-2" id="pags">
       
    </div>

    <div class="table-responsive mxh" >
        <table class="table table-hover scroll" id="tablaAdminvisitas">
            <thead>
                <tr>

                    <th style="min-width: 200px">ACCIONES</th>
                    <th style="min-width: 100px">REF</th>
                    <th style="min-width: 100px">EMAIL</th>
                    <th style="min-width: 200px">NOMBRE</th>
                    <th style="min-width: 200px">APELLIDOS</th>
                    <th style="min-width: 100px">TELEFONO</th>
                    <th style="min-width: 100px">PROVINCIA</th>
                    <th style="min-width: 100px">CIUDAD</th>
                    <th style="min-width: 50px">CP</th>
                    <th style="min-width: 150px">DIRECCIÓN</th>
                    <th style="min-width: 50px">NÚMERO</th>

                </tr>
            </thead>
            <tbody id="body_table"   >


                @foreach($adminclientes as $key => $c)
                <tr id="tr-{{$c->id}}" class="trreservas">

                    <td style="min-width: 200px;">
                        <button type='button' id='edit-{{$c->id}}' class='editar btn btn-warning py-0'>
                            <i class='fa fa-cog' style="color: #fff"></i>
                        </button>
                        <button type='button' id='verpedidos-{{$c->id}}' class='verpedidos btn btn-success py-0 dnone '>
                            <i class='fa fa-calendar' style="color: #fff"></i>
                        </button>
                        <button type='button' id='delete-{{$c->id}}' class='btdelete btn btn-danger py-0'>
                            <i class='fa fa-trash' style="color: #fff"></i>
                        </button>
                    </td>
                    <td style='width: 100px'>
                        <div id='Eid-{{$c->id}}'>{{$c->id}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Eemail-{{$c->id}}'>{{$c->email}}</div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Ename-{{$c->id}}'>{{$c->name}}</div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Esurname-{{$c->id}}'>{{$c->surname}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Etelefono-{{$c->id}}'>{{ $c->telefono }}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Estate-{{$c->id}}'>{{$c->state}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Ecity-{{$c->id}}'>{{$c->city}}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Epostalcode-{{$c->id}}'>{{$c->postalcode}}</div>
                    </td>
                    <td style='width: 150px'>
                        <div id='Eaddress-{{$c->id}}'>{{$c->address}}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Enumber-{{$c->id}}'>{{$c->number}}</div>
                    </td>

                    <div class="dnone" hidden>
                        <div id='Erol_id-{{$c->id}}'>{{$c->rol_id}}</div>
                        <div id='Edocumento-{{$c->id}}'>{{$c->documento}}</div>
                        <div id='Eprefijo-{{$c->id}}'>{{$c->prefijo}}</div>
                        <div id='Eafiliado-{{$c->id}}'>{{$c->afiliado}}</div>
                        <div id='Edisponibilities-{{$c->id}}'>{{json_encode($c->disponibilities)}}</div>

                        
                        <div id='Emodel-{{$c->id}}'>
                            {{json_encode($c)}}
                        </div>
                    </div>

                </tr>

                @endforeach
            </tbody>
            <tfoot>
                <tr>

                    <th style="min-width: 200px">ACCIONES</th>
                    <th style="min-width: 100px">REF</th>
                    <th style="min-width: 100px">EMAIL</th>
                    <th style="min-width: 200px">NOMBRE</th>
                    <th style="min-width: 200px">APELLIDOS</th>
                    <th style="min-width: 100px">TELEFONO</th>
                    <th style="min-width: 100px">PROVINCIA</th>
                    <th style="min-width: 100px">CIUDAD</th>
                    <th style="min-width: 50px">CP</th>
                    <th style="min-width: 150px">DIRECCIÓN</th>
                    <th style="min-width: 50px">NÚMERO</th>
                    

                </tr>
            </tfoot>
        </table>
    </div>

    <div class="dnone">
        <div id="lista_hours" data-hours="{{ json_encode($hours) }}">
        </div>
        <div id="lista_diassemana" data-diassemana="{{ json_encode($diassemana) }}">
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
                        <span> DATOS CLIENTES </span>
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
                            <p class="m-0">Email</p>
                            <input type="text" disabled="true" id="Cemail" name="email" class='form-control'>
                        </div>

                        <div class="my-2 mx-auto">
                            <p class="m-0">Nombre</p>
                            <input type="text" id="Cnombre" name="nombre" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Apellidos</p>
                            <input type="text" id="Capellidos" name="apellidos" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Teléfono</p>
                            <input type="text" id="Ctelefono" name="telefono" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Provincia</p>
                            <input type="text" id="Cprovincia" name="provincia" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Ciudad</p>
                            <input type="text" id="Cciudad" name="ciudad" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">CP</p>
                            <input type="text" id="Cpostalcode" name="cp" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Dirección</p>
                            <input type="text" id="Cdireccion" name="direccion" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Número</p>
                            <input type="text" id="Cnumero" name="numero" class='form-control'>
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


<div>
    <button type='button' class="dnone" id='abrirModalXverpedidos' data-toggle='modal' data-target='#modalXverpedidos'
        data-backdrop='static' data-keyboard='false'>
    </button>
    <div class='modal fade' id='modalXverpedidos'>

        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title text-center'>
                        <span> VER PEDIDOS </span>
                    </h4>
                    <button id="btcloseverpedidos" type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='w100 '>

                        <div class="dnone">
                            <input id="Cg_id" name='Cg_id'>
                        </div>

                        <div id="Cg_pedidos"  class="my-2 mx-auto">
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

let franjasData = $('#lista_franjas').data('franjas') || [];
let languagesData = $('#lista_languages').data('languages') || [];
let hoursData = $('#lista_hours').data('hours') || [];
let diasSemanaData = $('#lista_diassemana').data('diassemana') || [];



$('.menu').removeClass('activ');
$("#linkadminclientes").addClass('activ');

$(".editar").on('click', function() {
    let id = $(this).attr('id').split('-')[1];

    let email = $('#Eemail-' + id).text() || "";
    let name = $('#Ename-' + id).text() || "";
    let surname = $('#Esurname-' + id).text() || "";
    let telefono = $('#Etelefono-' + id).text() || "";
    let state = $('#Estate-' + id).text() || "";
    let city = $('#Ecity-' + id).text() || "";
    let postalcode = $('#Epostalcode-' + id).text() || "";
    let address = $('#Eaddress-' + id).text() || "";
    let number = $('#Enumber-' + id).text() || "";

    let model = $('#Emodel-' + id).text();
    let visitObject = JSON.parse(model);
    
    console.log("model visita ==> ",visitObject);
    console.log("> ",email);

    $('#Cid').val(id);
    $('#Cemail').val(email);
    $('#Cnombre').val(name);
    $('#Capellidos').val(surname);
    $('#Ctelefono').val(telefono);
    $('#Cprovincia').val(state);
    $('#Cciudad').val(city);
    $('#Cpostalcode').val(postalcode);
    $('#Cdireccion').val(address);
    $('#Cnumero').val(number);

    $('#abrirModalX').click();
    $('#form-data-display').removeClass('oculto');
    updateFormData();
    
});


$(".verpedidos").on('click', function() {
    let id = $(this).attr('id').split('-')[1];
    $('#Cg_id').val(id);
    $('#abrirModalXverpedidos').click();
});





///////////////////////////////////////////////////////calls ajax



//bteditarX
$("#bteditarX").on('click', function() {
    var create = false;
    let urlaccion = "{{ route('adminclientes/cliente')}}";
    let idguia = $('#Cid').val();

    let formData = {
        id: idguia,
        name: $('#Cnombre').val(),
        surname: $('#Capellidos').val(),
        telefono: $('#Ctelefono').val(),
        state: $('#Cprovincia').val(),
        city: $('#Cciudad').val(),
        postalcode: $('#Cpostalcode').val(),
        address: $('#Cdireccion').val(),
        number: $('#Cnumero').val()

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
                    $("#Ename-" + id).text(result["name"]);
                    $("#Esurname-" + id).text(result["surname"]);
                    $("#Etelefono-" + id).text(result["telefono"]);
                    $("#Estate-" + id).text(result["state"]);
                    $("#Ecity-" + id).text(result["city"]);
                    $("#Epostalcode-" + id).text(result["postalcode"]);
                    $("#Eaddress-" + id).text(result["address"]);
                    $("#Enumber-" + id).text(result["number"]);

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
            url: '/adminguias/deleteguia',
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


$("#abrirModalXverpedidos").on('click', function() {
    $("#Cg_pedidos").html('');
    let id = parseInt($('#Cg_id').val());
    let disponibilitiesjson = $('#Edisponibilities-'+id).text()|| [];
    const disponibilities = JSON.parse(disponibilitiesjson);
    disponibilities.forEach(disponibilidad => {
        let dia = "";
        let franja = "";
        let horainit ="";
        let horaend ="";
        if(diasSemanaData != null){
            dia = diasSemanaData[disponibilidad.diasemana -1] || "";
        }
        if(franjasData != null){
            franja = franjasData[disponibilidad.fanjahoraria_id - 1] || "";
            if(franja != ""){
                hoursData.forEach(hora => {
                    if(hora.id == franja.init_hours_id){
                        horainit = hora.hora;
                    }
                    if(hora.id == franja.end_hours_id){
                        horaend = hora.hora;
                    }
                })
            }
        }
        const disponibilidadItem = `<p>Día: ${dia}, Franja Horaria: ${horainit} - ${horaend}</p>`;
        $("#Cg_pedidos").append(disponibilidadItem);
      });
    
    
});



function getGuia(id) {
    return guiasData[id - 1].name ;
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

<div id="form-data-display" class="oculto  dnone" >
        <h3>Valores del formulario</h3>
        <span>nombre: </span><span id="displayName"></span><br>
        <span>apellidos: </span><span id="displaySurname"></span><br>
        <span>telefono: </span><span id="displayTelefono"></span><br>
        <span>provinicia:</span><span id="displayState"></span><br>
        <span>ciudad:</span><span id="displayCity"></span><br>
        <span>cp:</span><span id="displayPostalcode"></span><br>
        <span>direccion:</span><span id="displayAddress"></span><br>
        <span>numero:</span><span id="displayNumber"></span><br>

    </div>

    <script>
            // Función para actualizar los valores en el div
            function updateFormData() {
                
                $('#displayName').text('' + $('#Cnombre').val());
                $('#displaySurname').text('' + $('#Capellidos').val());
                $('#displayTelefono').text('' + $('#Ctelefono').val());
                $('#displayState').text('' + $('#Cprovincia').val());
                $('#displayCity').text('' + $('#Cciudad').val());
                $('#displayPostalcode').text('' + $('#Cpostalcode').val());
                $('#displayAddress').text('' + $('#Cdireccion').val());
                $('#displayNumber').text('' + $('#Cnumero').val());

            }
            $('.formulariomodal input, .formulariomodal select').on('input change', function () {
                updateFormData();
            });

            $('#btcloseeditar').on('click', function (){
                $('#form-data-display').addClass('oculto');
            })
    </script>


@stop