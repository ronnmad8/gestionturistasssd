@extends('base')
@section('content')



<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-2 col-12">
                <h2>FACTURACIÓN</h2>
            </div>
        </div>

        <div class="row ">
                <div class="col-xl-6 my-1 d-flex">
                    <div class="mx-1 formulariocita" style="min-width: 150px">
                        <p class="m-0">Mes</p>
                        <select class="form-control  mx-1" id="Cmeses" >
                            <option value="">-</option>
                            @foreach($meses as $id => $nombre)
                            <option value="{{ $id }}">
                            {{ ucfirst($nombre) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 my-1 d-flex">
                    <div class="mx-1 formulariocita" style="min-width: 100px">
                        <p class="m-0">TOTAL</p>
                        <div id="Csuma" >0 €</div>
                    </div>
                </div>
                <div class="col-xl-3 my-1 d-flex">
                    <div class="mx-1" style="min-width: 50px">
                        <a href="#" id="exportexcel"  class="btn btn-primary">Exportar a Excel</a>
                    </div>
                </div>
            </div>
    </div>

    <div class="table-responsive mxh" >
        <table class="table table-hover scroll" id="tablaAdminvisitas">
            <thead>
                <tr>

                    <th style="min-width: 100px"><span> CANTIDAD €</span></th>
                    <th style="min-width: 100px">REF</th>
                    <th style="min-width: 200px">GUÍA</th>
                    <th style="min-width: 200px">CLIENTE</th>
                    <th style="min-width: 300px">VISITA</th>
                    <th style="min-width: 100px">IDIOMA</th>
                    <th style="min-width: 150px">FECHA</th>
                    <th style="min-width: 100px">HORA</th>

                </tr>
            </thead>
            <tbody id="body_table" style="min-height: 200px;" >


            </tbody>
            <tfoot>
                <tr>
                    <th style="min-width: 100px"><span> CANTIDAD €</span></th>
                    <th style="min-width: 100px">REF</th>
                    <th style="min-width: 200px">GUÍA</th>
                    <th style="min-width: 200px">CLIENTE</th>
                    <th style="min-width: 300px">VISITA</th>
                    <th style="min-width: 100px">IDIOMA</th>
                    <th style="min-width: 150px">FECHA</th>
                    <th style="min-width: 100px">HORA</th>

                </tr>
            </tfoot>
        </table>
    </div>

    <div class="dnone">
        <div id="adminfacturacion" data-reservas="{{ json_encode($admincitas) }}">
        </div>
    </div>

</div>

<script>

let listaadminfacturacion = $('#adminfacturacion').data('reservas') || [];
console.log("listaadminfacturacion ", listaadminfacturacion);

$('.menu').removeClass('activ');
$("#linkadminfacturacion").addClass('activ');

function setTableCita(){
  let mesesFiltrar = $('#Cmeses').val();
  let filtAdmincitasTable = [];
  if( mesesFiltrar != "" ){
      filtAdmincitasTable = listaadminfacturacion.filter(item => {
          const fecha = new Date(item.fecha);
          let fe =  fecha.getMonth();
          let ye = fecha.getFullYear();
          let yearactual = new Date().getFullYear();
          return (fe == parseInt(mesesFiltrar)  && ye == yearactual);
      });
  }

  console.log("filtAdmincitasTable ", filtAdmincitasTable);

  $('#body_table').html('');
  let suma = 0;
  filtAdmincitasTable.forEach( cita => {
    
    let fila =``;
    fila +=` '<tr id='c-${cita.id}' class='trreservas'> `;
    fila += ` <td style='width: 100px'> `;
    fila += `     <div id='Etotal-${cita.id}'>${cita.total}</div> `;
    fila += ` </td> `
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
    fila += ` </td> `;;
    fila += ` <td style='width: 100px'> `;
    fila += `     <div id='Ehora-${cita.id}'>${cita.hour}</div> `;
    fila += ` </td> `;
    fila += ` </tr> `;

    $('#body_table').append(fila);
    suma += parseFloat(cita.total);
  });

  $('#Csuma').html(suma + ' €');

  
  if(mesesFiltrar == ""){
      mesesFiltrar = 1;
    }
    var url = "{{ route('excelfacturacion', ['mes' => ':mes']) }}";
    url = url.replace(':mes', parseInt(mesesFiltrar)+1);
    $('#exportexcel').attr('href', url);
}



$(function () {

    $(document).on('change', '#Cmeses', function () {
        setTableCita();
    });
});





</script>







@stop