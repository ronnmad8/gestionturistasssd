@extends('base')
@section('content')



<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-2 col-12">
                <h2>SERVICIO</h2>
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
                        <p class="m-0">Horas</p>
                        <select class="form-control mx-1" id="Choras" value="">
                            <option value="">-</option>
                        </select>
                    </div>
                    <div class="mx-1 formulariocita" style="min-width: 100px">
                        <p class="m-0">Idiomas</p>
                        <select class="form-control mx-1" id="Cidiomas" value="">
                            <option value="">-</option>
                        </select>
                    </div>
                </div>
            </div>
    </div>

    <div class="table-responsive mxh" >
        <table class="table table-hover scroll" id="tablaAdminvisitas">
            <thead>
                <tr>

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

                </tr>
            </thead>
            <tbody id="body_table" >


            </tbody>
            <tfoot>
                <tr>
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

                </tr>
            </tfoot>
        </table>
    </div>

    <div class="dnone">
        <div id="admincitas" data-visits="{{ json_encode($admincitas) }}">
        </div>
    </div>

</div>

<script>

let listaadmincitas = $('#admincitas').data('visits') || [];
console.log("listaadmincitas ", listaadmincitas);

$('.menu').removeClass('activ');
$("#linkadmincitas").addClass('activ');

///////////////////////////////////////////////////////calls ajax



function setCita(){

  $('#body_table').html('');
  let listahoras = [];
  let listaidiomas = [];
  let fechaFiltrar = $('#Cfecha').val();
  let visitaFiltrar = $('#Cvisitas').val();

  let filtAdmincitas = [];
  if( fechaFiltrar != "" && visitaFiltrar != "" ){
    filtAdmincitas = listaadmincitas.filter(cita => cita.fecha == fechaFiltrar && cita.visit_id == visitaFiltrar ) ?? [] ;
  }

  $('#Choras').html('');
  $('#Cidiomas').html('');
  
  let op = ` <option value=''>-</option> `;
  $('#Choras').append(op);
  let opl = ` <option value=''>-</option> `;
  $('#Cidiomas').append(opl);
  filtAdmincitas.forEach( cita => {
    let horaid = cita.visit_hours_id;
    if(!listahoras.includes(horaid)){
        listahoras.push(horaid)
        op = ` <option value='${horaid}'>${cita.hour}</option> `;
        $('#Choras').append(op);
    }

    let idiomaid = cita.language_id;
    if(!listaidiomas.includes(idiomaid)){
        listaidiomas.push(idiomaid)
        opl = ` <option value='${idiomaid}'>${cita.language}</option> `;
        $('#Cidiomas').append(opl);
    }
  });
}

function setTableCita(){

  let horasFiltrar = $('#Choras').val();
  let idiomasFiltrar = $('#Cidiomas').val();
  let fechaFiltrar = $('#Cfecha').val();
  let visitaFiltrar = $('#Cvisitas').val();
  console.log("horasFiltrar ",horasFiltrar);

  let filtAdmincitasTable = [];
  if( fechaFiltrar != "" && visitaFiltrar != "" && horasFiltrar != ""  ){
    filtAdmincitasTable = listaadmincitas.filter(cita => cita.fecha == fechaFiltrar && cita.visit_id == parseInt(visitaFiltrar) 
    && cita.visit_hours_id == parseInt(horasFiltrar)  && cita.language_id == parseInt(idiomasFiltrar)  ) ?? [] ;
  }

  console.log("filtAdmincitasTable ", filtAdmincitasTable);

  $('#body_table').html('');

  filtAdmincitasTable.forEach( cita => {
    
    let fila =``;
    fila +=` '<tr id='c-${cita.id}' class='trreservas'> `;
    fila += ` <td style='width: 100px'> `;
    fila += `     <div id='E-${cita.id}'>${cita.id}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 200px'> `;
    fila += `    <div id='Eguia-${cita.id}'>${cita.guia ?? ""}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 200px'> `;
    fila += `     <div id='Euser-${cita.id}'>${cita.cliente}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 300px'> `;
    fila += `     <div id='Evisit-${cita.id}'>${cita.titulo}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 100px'> `;
    fila += `     <div id='Elanguage-${cita.id}'>${cita.language}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 150px'> `;
    fila += `     <div id='Efecha-${cita.id}'>${cita.fecha}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 100px'> `;
    fila += `     <div id='Etotal-${cita.id}'>${cita.total}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 100px'> `;
    fila += `     <div id='Ehora-${cita.id}'>${cita.hour}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 150px'> `;
    fila += `     <div id='Epersons-${cita.id}'>${cita.persons}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 150px'> `;
    fila += `     <div id='Eadults-${cita.id}'>${cita.adults}</div> `;
    fila += ` </td> `;
    fila += ` <td style='width: 150px'> `;
    fila += `     <div id='Echildren-${cita.id}'>${cita.children}</div> `;
    fila += ` </td> `;
    fila += ` </tr> `;

    $('#body_table').append(fila);
  });

}



$(function () {
    $(document).on('change', '#Cvisitas', function () {
        setCita();
    });
    $(document).on('change', '#Cfecha', function () {
        setCita();
    });

    $(document).on('change', '#Choras', function () {
        setTableCita();
    });
    $(document).on('change', '#Cidiomas', function () {
        setTableCita();
    });
});





</script>







@stop