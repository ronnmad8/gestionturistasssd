@extends('base')
@section('content')



<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-6">
                <h2>VISITAS</h2>
            </div>
            <div class="col-xl-6">
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-xl-4 text-left my-1" style="min-width: 140px;">
            <button id="buscar" type="button" class="btn btn-dark cupo mb-2" title="buscar">
                <i class="fa fa-plus mr-2"></i> <small> NUEVA VISITA</small>
            </button>
        </div>
        <a id="aniffilt" href="#" hidden></a>
    </div>

    <div class="py-2 my-2" id="pags">
       
    </div>
    <div class="table-responsive mxh">
        <table class="table table-hover scroll" id="tablaAdminvisitas">
            <thead>
                <tr>

                    <th style="max-width: 200px">EDITAR</th>
                    <th style="max-width: 200px">NOMBRE</th>
                    <th style="max-width: 100px">PRECIO</th>
                    <th style="min-width: 100px"><div><i class="mr-1 fa fa-user"></i> MIN</div></th>
                    <th style="min-width: 100px"><i class="mr-1 fa fa-user"></i> MAX</th>
                    <th style="min-width: 50px">DURACION</th>
                    <th style="min-width: 50px">CANCELACION</th>
                    <th style="min-width: 50px">TEMPORADA</th>
                    <th style="min-width: 50px">MASCOTAS</th>
                    <th style="min-width: 50px">ACCESIBILIDAD</th>
                    <th style="min-width: 50px">RECOMENDADO</th>
                    <th style="min-width: 200px">PUNTO ENCUENTRO</th>
                    <th style="min-width: 300px">PUNTO </th>


                </tr>
            </thead>
            <tbody id="body_table">


                @foreach($adminvisits as $key => $c)

                <tr id="tr-{{$c->id}}" class="trclientes">

                    <td style="max-width: 200px;">
                        <button type='button' id='a-{{$c->id}}' class='editar btn btn-warning py-0'>
                            <i class='fa fa-cog'></i>
                        </button>
                    </td>


                    <td style='width: 200px'>
                        <div id='Ename-{{$c->id}}'>{{$c->name}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Eprecio-{{$c->id}}'>{{$c->precio}} €</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Enummin-{{$c->id}}'>{{$c->nummin}} </div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Enummax-{{$c->id}}'>{{$c->nummax}} </div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Eduracionmin-{{$c->id}}'>{{$c->duracionmin}} min</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Ecancelacion-{{$c->id}}'>{{$c->cancelacion == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Ecancelacion-{{$c->id}}'>{{$c->temporada == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Ecancelacion-{{$c->id}}'>{{$c->mascotas == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Ecancelacion-{{$c->id}}'>{{$c->accesibilidad == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Ecancelacion-{{$c->id}}'>{{$c->recomendado == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Epuntoencuentro-{{$c->id}}'>{{$c->puntoencuentro}}</div>
                    </td>
                    <td style='width: 300px'>
                        <div id='Epuntoencuentrotext-{{$c->id}}'>{{$c->puntoencuentrotext}}</div>
                    </td>
                    <div class="dnone" hidden>
                        <div id='Euuid-{{$c->id}}'>{{$c->uuid}}</div>
                        <div id='Ecuandomin-{{$c->id}}'>{{$c->cuandomin}}</div>
                        <div id='Epreciohoramin-{{$c->id}}'>{{$c->preciohoramin}}</div>
                        <div id='Epuntoencuentrotext-{{$c->id}}'>{{$c->puntoencuentrotext}}</div>
                    </div>

                </tr>

                @endforeach
            </tbody>
            <tfoot>
                <tr>

                    <th style="max-width: 50px">EDITAR</th>
                    <th style="max-width: 200px">NOMBRE</th>
                    <th style="max-width: 100px">PRECIO</th>
                    <th style="min-width: 100px"><div><i class="mr-1 fa fa-user"></i> MIN</div></th>
                    <th style="min-width: 100px"><i class="mr-1 fa fa-user"></i> MAX</th>
                    <th style="min-width: 50px">DURACION</th>
                    <th style="min-width: 50px">CANCELACION</th>
                    <th style="min-width: 50px">TEMPORADA</th>
                    <th style="min-width: 50px">MASCOTAS</th>
                    <th style="min-width: 50px">ACCESIBILIDAD</th>
                    <th style="min-width: 50px">RECOMENDADO</th>
                    <th style="min-width: 200px">PUNTO ENCUENTRO</th>
                    <th style="min-width: 300px">PUNTO </th>


                </tr>
            </tfoot>
        </table>
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
                        <span> DATOS VISITA </span>
                    </h4>
                    <button id="btcloseeditar" type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='w100 '>

                        <div class="dnone">
                            <input id="Cid" name='id'>
                        </div>

                        <div class="my-2 mx-auto">
                            <p class="m-0">Nombre</p>
                            <input type="text" id="Cnombre" name="nombre" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Precio</p>
                            <input type="number" id="Cprecio" name="precio" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Máximo</p>
                            <input type="number" id="Cnummax" name="nummax" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Minimo</p>
                            <input type="number" id="Cnummin" name="nummin" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Cancelación</p>
                            <select class="form-control" id="Ccancelacion" name="Ccancelacion">
                                <option value="0" selected>NO</option>
                                <option value="1" selected>SI</option>
                            </select>
                        </div>


                        

                        <!-- <div class="my-2 mx-auto">
                            <p class="m-0">campo</p>
                            <input type="text" id="Ccentro" name="centro" class='form-control'>
                        </div> -->

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


$('.menu').removeClass('activ');
$("#linkadminvisits").addClass('activ');

$(".editar").on('click', function() {

    let id = $(this).attr('id').split('-')[1];

    let name = jQuery('#Ename-' + id).text();
    let precio = jQuery('#Eprecio-' + id).text();
    let nummin = jQuery('#Enummin-' + id).text();
    let nummax = jQuery('#Enummax-' + id).text();
    let duracion = jQuery('#Eduracion-' + id).text();
    let cancelacion = jQuery('#Ecancelacion-' + id).text();
    let temporada = jQuery('#Etemporada-' + id).text();
    let mascotas = jQuery('#Emascotas-' + id).text();
    let accesibilidad = jQuery('#Eaccesibilidad-' + id).text();
    let recomendado = jQuery('#Erecomendado-' + id).text();
    let puntoencuentro = jQuery('#Epuntoencuentro-' + id).text();
    let puntoencuentrotext = jQuery('#Epuntoencuentrotext-' + id).text();


    $('#Cid').val(id);
    $('#Cname').val(name);
    $('#Cprecio').val(precio);
    $('#Cnummin').val(nummin);
    $('#Cnummax').val(nummax);
    $('#Ccancelacion').val(cancelacion);
    $('#Ctemporada').val(temporada);
    $('#Cmascotas').val(mascotas);
    $('#Caccesibilidad').val(accesibilidad);
    $('#Crecomendado').val(recomendado);
    $('#Cpuntoencuentro').val(puntoencuentro);
    $('#Cpuntoencuentrotext').val(puntoencuentrotext);

    $('#abrirModalX').click();

});



//bteditarX
$("#bteditarX").on('click', function() {
debugger
    let urlaccion = "{{ route('adminvisits/updatevisit')}}";
    let idaccion = $('#Cid').val();
    if(idaccion != null){
        urlaccion = "{{ route('adminvisits/createvisit')}}";
    } 

    let formData = {

        id: $('#Cid').val(),
        name: $('#Cname').val(),
        precio: $('#Cprecio').val(),
        nummin: $('#Cnummin').val(),
        nummax: $('#Cnummax').val(),
        duracionmin: $('#Cduracionmin').val(),
        cancelacion: $('#Ccancelacion').val(),
        temporada: $('#Ctemporada').val(),
        mascotas: $('#Cmascotas').val(),
        accesibilidad: $('#Caccesibilidad').val(),
        recomendado: $('#Crecomendado').val(),
        puntoencuentro: $('#Cpuntoencuentro').val(),
        puntoencuentrotext: $('#Cpuntoencuentrotext').val()

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
                let id = result["id"];
                $("#Ename-" + id).text(result["name"]);
                $("#Eprecio-" + id).text(result["precio"]);
                $("#Enummin-" + id).text(result["nummax"]);
                $("#Ecancelacion-" + id).text(result["cancelacion"]);
                $("#Etemporada-" + id).text(result["temporada"]);
                $("#Emascotas-" + id).text(result["mascotas"]);
                $("#Eaccesibilidad-" + id).text(result["accesibilidad"]);
                $("#Erecomendado-" + id).text(result["recomendado"]);
                $("#Epuntoencuentro-" + id).text(result["puntoencuentro"]);
                $("#Epuntoencuentrotext-" + id).text(result["puntoencuentrotext"]);

                $('.toast').toast('show');
            },
            fail: function() {
                alert("fail");
            },
            beforeSend: function() {
                $('#btcloseeditar').click();
            }
        });

    } catch (error) {
        console.err(error);
    }


});




</script>


@stop