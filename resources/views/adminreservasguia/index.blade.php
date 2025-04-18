@extends('base')
@section('content')



<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-2 col-12">
                <h2>MIS SERVICIOS</h2>
            </div>
            <div class="col-xl-6 my-1 d-flex">
                <div class="mx-1 formulariocita" style="min-width: 100px" >
                    <p class="m-0">Fecha inicial</p>
                    <input class="form-control  mx-1" id="Cfechaini" type="date"  >
                </div>
                <div class="mx-1 formulariocita" style="min-width: 100px" >
                    <p class="m-0">Fecha final</p>
                    <input class="form-control  mx-1" id="Cfechafin" type="date"  >
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive mxh" >
        <table class="table table-hover scroll" id="tablaAdminvisitas">
            <thead>
                <tr>

                    <th style="min-width: 50px">ACCIONES</th>
                    <th style="min-width: 100px">REF</th>
                    <th style="min-width: 100px">ESTADO</th>
                    <th style="min-width: 200px">CLIENTES</th>
                    <th style="min-width: 300px">VISITA</th>
                    <th style="min-width: 100px">IDIOMA</th>
                    <th style="min-width: 150px">FECHA</th>
                    <th style="min-width: 100px">HORA</th>
                    <th style="min-width: 150px"><div><i class="mr-1 fa fa-users"></i>PERSONAS</div></th>

                </tr>
            </thead>
            <tbody id="body_table"   >

            </tbody>
            <tfoot>
                <tr>

                    <th style="min-width: 50px">ACCIONES</th>
                    <th style="min-width: 100px">REF</th>
                    <th style="min-width: 100px">ESTADO</th>
                    <th style="min-width: 200px">CLIENTES</th>
                    <th style="min-width: 300px">VISITA</th>
                    <th style="min-width: 100px">IDIOMA</th>
                    <th style="min-width: 150px">FECHA</th>
                    <th style="min-width: 100px">HORA</th>
                    <th style="min-width: 150px"><div><i class="mr-1 fa fa-users"></i>PERSONAS</div></th>

                </tr>
            </tfoot>
        </table>
    </div>

    <div class="dnone">
        <div id="lista_hours" data-hours="{{ json_encode($hours) }}">
        </div>
        <div id="lista_diassemana" data-diassemana="{{ json_encode($diassemana) }}">
        </div>
        <div id="lista_languages" data-languages="{{ json_encode($languages) }}">
        </div>
        <div id="lista_admincitas" data-admincitas="{{ json_encode($admincitas) }}">
        </div>
    </div>

</div>

<script>

let listaadmincitas = $('#lista_admincitas').data('admincitas') || [];

$('.menu').removeClass('activ');
$("#linkadminreservasguia").addClass('activ');
setTableCita();

function setTableCita(){

    let fechaFiltrarini = $('#Cfechaini').val();
    let fechaFiltrarfin = $('#Cfechafin').val();
    
    let filtAdmincitasTable = listaadmincitas.data;
    if( fechaFiltrarini != "" ){
        filtAdmincitasTable = filtAdmincitasTable.filter(cita => cita.fecha >= fechaFiltrarini  ) ?? [] ;    
    }
    if( fechaFiltrarfin != "" ){
        filtAdmincitasTable = filtAdmincitasTable.filter(cita => cita.fecha <= fechaFiltrarfin  ) ?? [] ;    
    }
    mostrarResultados(filtAdmincitasTable);
}


function mostrarResultados(citasTable){
  $('#body_table').html('');

  citasTable.forEach( c => {
  let fila =``;
  fila +=` '<tr id='c-${c.id}' class='trreservas'> `;
  fila += `<td style="min-width: 50px;">`;
  fila += `     <button type='button' id='delete-${c.id}' class='btdelete btn btn-danger py-0'>`;
  fila += `         <i class='fa fa-ban' style="color: #fff"></i>`;
  fila += `     </button>`;
  fila += `</td>  `;
  fila += ` <td style='width: 100px'> `;
  fila += `     <div id='E-${c.id}'>${c.id}</div> `;
  fila += ` </td> `;
  fila += ` <td style='width: 100px'> `;
  fila += `     <div id='Eestado-${c.id}'>${c.status == 1 ? 'Cerrada' : 'Abierta'  }</div> `;
  fila += ` </td> `;
  fila += ` <td style='width: 200px'> `;
  fila += `     <div id='Euser-${c.id}'>${c.user.name }</div> `;
  fila += ` </td> `;
  fila += ` <td style='width: 300px'> `;
  fila += `     <div id='Evisit-${c.id}'>${c.visit.name }</div> `;
  fila += ` </td> `;
  fila += ` <td style='width: 100px'> `;
  fila += `     <div id='Elanguage-${c.id}'>${c.language.name }</div> `;
  fila += ` </td> `;
  fila += ` <td style='width: 150px'> `;
  let fecha = new Date(c.fecha);
  fila += `     <div id='Efecha-${c.id}'>${ fecha.toLocaleDateString() }</div> `;
  fila += ` </td> `;
  fila += ` <td style='width: 100px'> `;
  fila += `     <div id='Ehora-${c.id}'>${c.hour.hora }</div> `;
  fila += ` </td> `;
  fila += ` <td style='width: 150px'> `;
  fila += `     <div id='Epersons-${c.id}'>${c.clients }</div> `;
  fila += ` </td> `;
  fila += ` <div class="dnone" hidden>
      <div id='Eguia_id-${c.id}'>${c.guia_id}</div>
      <div id='Euser_id-${c.id}'>${c.user_id}</div>
      <div id='Evisit_id-${c.id}'>${c.visit_id}</div>
      <div id='Elanguage_id-${c.id}'>${c.language_id}</div>
      <div id='Evisit_hours_id-${c.id}'>${c.hours_id}</div>
      <div id='Estatus-${c.id}'>${c.status}</div>     
      </div> `;
  fila += ` </tr> `;
  
  $('#body_table').append(fila);
  });

}



$(function () {

  $(document).on('change', '#Cfechaini', function () {
      setTableCita();
  });
  $(document).on('change', '#Cfechafin', function () {
      setTableCita();
  });

});



///////////////////////////////////////////////////////calls ajax

$(".btdelete").on('click', function() {
    let idtodelete = $(this).attr('id').split('-')[1]; 
    var formData = {
        id: idtodelete
    }
    if (confirm('¿Estás seguro de que quieres rechazar esta Cita?')) {
      try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admincitasguia/rechazarcita',
            data: formData,
            dataType: "json",
            method: "POST",
            success: function(result) {
                if(result != null){
                  // location.reload();
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



</script>





@stop