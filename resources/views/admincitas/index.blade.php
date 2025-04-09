@extends('base')
@section('content')



<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-2 col-12">
                <h2>SERVICIOS</h2>
            </div>
        </div>

        <div class="row ">
                <div class="col-xl-6 my-1 d-flex">
                    <div class="mx-1 formulariocita" style="min-width: 100px" >
                        <p class="m-0">Fecha</p>
                        <input class="form-control  mx-1" id="Cfecha" type="date"  >
                    </div>
                    <div class="mx-1 formulariocita" style="min-width: 150px">
                        <p class="m-0">Visitas</p>
                        <select class="form-control  mx-1" id="Cvisitas" >
                            <option value="">-</option>
                            @foreach($visits as $visit)
                            <option value="{{$visit['id']}}">
                                {{$visit['name']}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mx-1 formulariocita" style="min-width: 100px">
                        <p class="m-0">Franjas Horarias</p>
                        <select class="form-control mx-1" id="Cfranjas" value="">
                            <option value="">-</option>
                            @foreach($franjashorarias as $franja)
                            <option value="{{$franja['init_hours_id']}}-{{$franja['end_hours_id']}}">
                                {{$franja['hourinit']}} - {{$franja['hourend']}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mx-1 formulariocita" style="min-width: 100px">
                        <p class="m-0">Idiomas</p>
                        <select class="form-control mx-1" id="Cidiomas" value="">
                            <option value="">-</option>
                            @foreach($idiomas as $idioma)
                            <option value="{{$idioma['id']}}">
                                {{$idioma['name']}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    </div>

    <div class="table-responsive mxh" >
        <table class="table table-hover scroll" id="tablaAdminvisitas">
            <thead>
                <tr>

                    <th style="min-width: 150px">ACCIONES</th>
                    <th style="min-width: 50px">REF</th>
                    <th style="min-width: 300px">GUÍA</th>
                    <th style="min-width: 300px">VISITA</th>
                    <th style="min-width: 50px">ESTADO</th>
                    <th style="min-width: 50px">IDIOMA</th>
                    <th style="min-width: 50px">HORA</th>
                    <th style="min-width: 100px">FECHA</th>
                    <th style="min-width: 50px">MINIMO</th>
                    <th style="min-width: 50px">MÁXIMO</th>
                    <th style="min-width: 50px"><div><i class="mr-1 fa fa-users"></i>CLIENTES</div></th>

                </tr>
            </thead>
            <tbody id="body_table" >

                @foreach($admincitas as $key => $cita)
                <tr id="tr-{{$cita->id}}" class="trcitas">

                    <td style="min-width: 150px;">

                        <button type='button' id='asignarguia-{{$cita->id}}' class='asignarguia btn btn-success py-0'>
                            <i class='fa fa-user' style="color: #fff"></i>
                        </button>
                        <button type='button' id='setstatus-{{$cita->id}}' class='btsetstatus btn btn-warning py-0'>
                            <i class='fa fa-cog' style="color: #fff"></i>
                        </button>
                    </td>
                    <td style='width: 50px'>
                        <div id='Eid-{{$cita->id}}'>{{$cita->id}}</div>
                    </td>
                    <td style='width: 300px'>
                        <div id='Eguia-{{$cita->id}}'>{{$cita->guia ?? ""}}</div>
                    </td>
                    <td style='width: 300px'>
                        <div id='Evisit-{{$cita->id}}'>{{$cita->titulo ?? ""}}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Estatus-{{$cita->id}}'>
                            @forEach($statuscitas as $key => $status)
                                @if($cita->status == $status->id)
                                    {{ $status->name }}
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Elanguage-{{$cita->id}}'>{{$cita->language ?? ""}}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Ehora-{{$cita->id}}'>{{$cita->hour ?? ""}}</div>
                    </td>
                    <td style='width: 150px'>
                        <div id='Efecha-{{$cita->id}}'>{{\Carbon\Carbon::parse($cita->fecha)->format('d/m/y') }}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Emin-{{$cita->id}}'>{{$cita->min ?? 0}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Emax-{{$cita->id}}'>{{$cita->max ?? 0}}</div>
                    </td>
                    <td style='width: 150px'>
                        <div id='Eclients-{{$cita->id}}'>{{$cita->clients}}</div>
                    </td>


                    <div class="dnone" hidden>
                        <div id='Eguia_id-{{$cita->id}}'>{{$cita->guia_id}}</div>
                        <div id='Evisit_id-{{$cita->id}}'>{{$cita->visit_id}}</div>
                        <div id='Elanguage_id-{{$cita->id}}'>{{$cita->language_id}}</div>
                        <div id='Ehours_id-{{$cita->id}}'>{{$cita->hours_id}}</div>
                        <div id='Estatus_id-{{$cita->id}}'>{{$cita->status}}</div>
                        
                        <div id='Emodel-{{$cita->id}}'>
                            {{json_encode($cita)}}
                        </div>
                    </div>

                </tr>

                @endforeach

            </tbody>
            <tfoot>
                <tr>

                    <th style="min-width: 150px">ACCIONES</th>
                    <th style="min-width: 50px">REF</th>
                    <th style="min-width: 300px">GUÍA</th>
                    <th style="min-width: 300px">VISITA</th>
                    <th style="min-width: 50px">ESTADO</th>
                    <th style="min-width: 50px">IDIOMA</th>
                    <th style="min-width: 50px">HORA</th>
                    <th style="min-width: 100px">FECHA</th>
                    <th style="min-width: 50px">MINIMO</th>
                    <th style="min-width: 50px">MÁXIMO</th>
                    <th style="min-width: 50px"><div><i class="mr-1 fa fa-users"></i>CLIENTES</div></th>

                </tr>
            </tfoot>
        </table>
    </div>

    <div class="dnone">
        <div id="admincitas" data-visits="{{ json_encode($admincitas) }}">
        </div>
    </div>

</div>

<div>
    <button type='button' class="dnone" id='abrirModalXasignarguia' data-toggle='modal' data-target='#modalXasignarguias'
        data-backdrop='static' data-keyboard='false'>
    </button>
    <div class='modal fade' id='modalXasignarguias'>

        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title text-center'>
                        <span> ASIGNAR GUIA </span>
                    </h4>
                    <button id="btcloseasignarguias" type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='w100 formulariomodal'>

                        <div class="dnone">
                            <input id="Cg_id" name='Cg_id'>
                        </div>

                        <div class="my-2 mx-auto">
                            <p class="m-0">Guía</p>
                            <select class="form-control" id="Cg_guia" name="Cg_guia" >
                            @foreach ($guias as $key => $guia)
                                <option value="{{ $guia->id }}">{{ $guia->name }} - {{ $guia->email }} </option>
                            @endforeach
                            </select>
                        </div>
                        
                        <div class="m10 mxauto text-center">
                            <button type="button" id="btasignarguia" class='m-2 btn btn-info'>ASIGNAR</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div>
    <button type='button' class="dnone" id='abrirModalXsetstatus' data-toggle='modal' data-target='#modalXsetstatus'
        data-backdrop='static' data-keyboard='false'>
    </button>
    <div class='modal fade' id='modalXsetstatus'>

        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title text-center'>
                        <span> CAMBIAR ESTADO DE CITA </span>
                    </h4>
                    <button id="btclosesetstatus" type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='w100 formulariomodal'>

                        <div class="dnone">
                            <input id="Sg_id" name='Sg_id'>
                        </div>

                        <div class="my-2 mx-auto">
                            <p class="m-0">Estado</p>
                            <select class="form-control" id="Sg_status" name="Sg_status" >
                                <option value=""> - </option>
                            @foreach ($statuscitas as $key => $status)
                                <option value="{{ $status->id }}">{{ $status->name }}  </option>
                            @endforeach
                            </select>
                        </div>
                        
                        <div class="m10 mxauto text-center">
                            <button type="button" id="btregistrarstatus" class='m-2 btn btn-info'>REGISTRAR</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

let listaadmincitas = $('#admincitas').data('visits') || [];
console.log("listaadmincitas ", listaadmincitas);

$('.menu').removeClass('activ');
$("#linkadmincitas").addClass('activ');

///////////////////////////////////////////////////////calls ajax


$(".asignarguia").on('click', function() {
    let id = $(this).attr('id').split('-')[1];
    let guia_id = $('#Eguia_id-' + id).text();
    $('#Cg_id').val(id);
    $('#Cg_guia').val(guia_id);

    $('#abrirModalXasignarguia').click();
});

$(".btsetstatus").on('click', function() {
    let id = $(this).attr('id').split('-')[1];
    let statusid = $('#Estatus_id-'+ id).text();
    console.log("btsetstatus", id, statusid);
    $('#Sg_id').val(id);
    $('#Sg_status').val(statusid);
    
    $('#abrirModalXsetstatus').click();
});


$("#btasignarguia").on('click', function() {
let id = parseInt($('#Cg_id').val());
let formData = {
    id: id,
    guia_id: $('#Cg_guia').val()
}

try {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/adminreservas/setguiacita',
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
  }
  catch (error) {
    console.err(error);
  }
});



$("#btregistrarstatus").on('click', function() {
let id = parseInt($('#Sg_id').val());
let statusid = $('#Sg_status').val();
let formData = {
    id: id,
    status: statusid
}

try {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/admincitas/setstatus',
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
  }
  catch (error) {
    console.err(error);
  }
});



$(function () {
    $(document).on('change', '#Cvisitas', function () {
        setTableCita();
    });
    $(document).on('change', '#Cfecha', function () {
        setTableCita();
    });

    $(document).on('change', '#Cfranjas', function () {
        setTableCita();
    });
    $(document).on('change', '#Cidiomas', function () {
        setTableCita();
    });
});



function setTableCita(){
    let idiomasFiltrar = $('#Cidiomas').val();
    let fechaFiltrar = $('#Cfecha').val();
    let visitaFiltrar = $('#Cvisitas').val();
    let franjasFiltrar = $('#Cfranjas').val();
    let filtAdminCitasTable = [] ;
    filtAdminCitasTable = listaadmincitas ?? [] ;

    if( fechaFiltrar != "" && fechaFiltrar != null){
        debugger
        filtAdminCitasTable = filtAdminCitasTable.filter(res => {
        const fechaRes = new Date(res.fecha);
        const anio = fechaRes.getFullYear();
        const mes = (fechaRes.getMonth() + 1).toString().padStart(2, '0');
        const dia = fechaRes.getDate().toString().padStart(2, '0');
        const fechaResFormateada = `${anio}-${mes}-${dia}`;
        return fechaResFormateada === fechaFiltrar;
        }) ?? [];
    }
    if( visitaFiltrar != "" && visitaFiltrar != null){
        filtAdminCitasTable = filtAdminCitasTable.filter(res => res.visit_id == parseInt(visitaFiltrar))  ?? [] ;
    }
    if( idiomasFiltrar != "" && idiomasFiltrar != null){
        filtAdminCitasTable = filtAdminCitasTable.filter(res => res.language_id == parseInt(idiomasFiltrar))  ?? [] ;
    }
    if( franjasFiltrar != "" && franjasFiltrar != null){
        let frns = franjasFiltrar.split("-");
        filtAdminCitasTable = filtAdminCitasTable.filter(res => res.hours_id >= parseInt(frns[0]) && res.hours_id < parseInt(frns[1]))  ?? [] ;
    }
    $('.trcitas').removeClass('dnone');

    listaadmincitas.forEach( cita => { 
        if(!filtAdminCitasTable.includes(cita))
        {
            $('#tr-'+cita.id).addClass('dnone');
        }
    });
}


$(".btregistrarstatus").on('click', function() {
    let idtoset = $(this).attr('id').split('-')[1]; 
    let status = $('#Sstatus-'+ idtoset).val();
    var formData = {
        id: idtoset,
        status: status
    }
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admimcitas/setstatus',
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
    
});



</script>







@stop