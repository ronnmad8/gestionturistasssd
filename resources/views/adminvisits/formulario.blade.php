@extends('basepublic')
@section('content')


<div class="panel panel-default shadow py-3 px-0 my-5 mx-0 bg-white rounded  " style="font-size: 18px">
    <div class="panel-heading p-0">
        <div class="w-100">
            <img src="{{asset('\images\gsd-formulario.jpg')}}" alt="formulario" class="w-100 h-auto">

        </div>
    </div>

    <div class="row  px-md-5 px-3  mx-md-4 ">
        <div class="col-12 text-center mt-3">
            <h1 class="azul" style="font-weight: 400; font-size: 40px;"> NECESITAMOS QUE NOS DES ESTOS DATOS </h1>
        </div>

        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Nombre* </strong>
                <input type="text" class="form-control datorequerido bgazulclaro" placeholder="" id="TutorNombre"
                    name="TutorNombre">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Apellido1* </strong>
                <input type="text" class="form-control datorequerido bgazulclaro" placeholder="" id="TutorApellido"
                    name="TutorApellido">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Apellido2 </strong>
                <input type="text" class="form-control bgazulclaro" placeholder="" id="TutorApellido2"
                    name="TutorApellido2">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100">DNI/NIE* </strong>
                <input type="text" class="form-control datorequerido bgazulclaro" placeholder="" id="TutorNIF"
                    name="TutorNIF">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100">Email* </strong>
                <input type="email" class="form-control datorequerido bgazulclaro" placeholder="" id="TutorEmail"
                    name="TutorEmail">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 " style="min-width: 220px">Fecha de nacimiento* </strong>
                <input type="date" class="form-control fecharequerida bgazulclaro" placeholder=""
                    id="TutorNacimientoFecha" name="TutorNacimientoFecha">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Movil </strong>
                <input type="phone" class="form-control bgazulclaro" placeholder="" id="TutorMovil" name="TutorMovil">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Dirección* </strong>
                <input type="text" class="form-control datorequerido bgazulclaro" placeholder="" id="Direccion"
                    name="Direccion">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Localidad* </strong>
                <input type="text" class="form-control datorequerido bgazulclaro" placeholder="" id="Poblacion"
                    name="Poblacion">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Provincia* </strong>
                <input type="text" class="form-control datorequerido bgazulclaro" placeholder="" id="Provincia"
                    name="Provincia">
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Centro* </strong>
                <select class="form-control bgazulclaro sels" id="centros_id" name="centros_id">
                    <option class="bgazulclaro" value=""></option>
                    @foreach($centros as $key => $c)
                    <option class="bgazulclaro" value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-6 my-1 p-2">
            <div class="d-xl-flex mb-3">
                <strong class="pr-4 mt-1 mw100"> Profesión </strong>
                <input type="text" class="form-control datorequerido bgazulclaro" placeholder="" id="profesion"
                    name="profesion">
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <h3> Alumno/a en GSD </h3>
                </div>

                <div class="col-12" id="hijos">

                </div>
                <div class="row w-100">
                    <div class="col-12 my-1 p-2 text-center">
                        <button id="addchild" class="btn btn-light">
                            <i class="fas fa-plus"></i>
                            <span>Añadir otro alumno/a en GSD</span>
                        </button>
                    </div>
                </div>

                <div class="col-12 text-right">
                    <strong>*Campo obligatorio</strong>
                </div>
                <div id="aceptarzone" class="col-12 text-center mx-auto mt-4">
                    <div class="row w-100 mt-xl-1 mt-3 ">
                        <div class="wm80 col-xl-2 m-0 p-0" title="aceptar politica"
                            style=" position: relative; left: 10px; bottom: 20px">
                            <img id="ac1" src="{{asset('\images\check_n.jpg')}}" alt="aceptar políticas"
                                class="dnone  h-auto mb-xl-4 mb-0  cupo w80">
                            <img id="ap1" src="{{asset('\images\check-apagado_n.jpg')}}" alt="aceptar políticas"
                                class=" h-auto mb-xl-4 mb-0 cupo w80">
                        </div>
                        <div class="col-xl-10 text-xl-left text-center" style="min-widh: 350px; ">
                            <strong> Confirmo que acepto la
                                <a class="azul" target="_blank"
                                    href="https://www.seryes.com/wp-content/uploads/2021/10/RGPDSEGURODEESTUDOS.pdf">
                                    La política de protección de datos
                                </a>
                            </strong>
                        </div>
                    </div>
                    <div class="row w-100 mt-xl-1 mt-5 ">
                        <div class="wm80 col-xl-2 m-0 p-0" title="aceptar politica"
                            style="position: relative; left: 10px; bottom: 20px">
                            <img id="ac2" src="{{asset('\images\check_n.jpg')}}" alt="aceptar políticas"
                                class="dnone  h-auto mb-xl-4 mb-0  cupo w80">
                            <img id="ap2" src="{{asset('\images\check-apagado_n.jpg')}}" alt="aceptar políticas"
                                class="  h-auto mb-xl-4 mb-0  cupo w80 ">
                        </div>
                        <div class="col-xl-10 text-xl-left text-center" style="min-widh: 350px; ">
                            <strong>
                                Confirmo que acepto recibir noticias sobre seguros, la economía social y Seryes
                            </strong>

                        </div>
                    </div>
                </div>

                <div class="col-12 text-center my-4">
                    <input type="text" class="dnone form-control bgazulclaro" id="Aceptopublicidad"
                        placeholder="aceptar" />
                    <button type="button" class="btn btn-info btn-lg" id="aceptar">ENVIAR</button>
                </div>
                <div id="avisoreg" class='mx-auto dnone'> <span class='badge badge-danger '> REVISE CAMPOS CON ERRORES
                    </span>
                </div>

                <a id="aoutpdf" href="" target="_blank" hidden></a>
                <a id="aouturl" href="https://www.seryes.com/" hidden></a>
            </div>
        </div>
    </div>


    <div>
        <button type='button' class="dnone" id='abrirModalX' data-toggle='modal' data-target='#modalX'
            data-backdrop='static' data-keyboard='false'>
        </button>
        <div class='modal fade' id='modalX'>

            <div class='modal-dialog modal-xs' role='document' style="max-width: 350px; height: auto">
                <div class='modal-content'>
                    <div class='modal-body'>
                        <div class="p-0 mx-auto">

                            <img src="{{asset('\images\formulario-final-1.png')}}" alt=""
                                style="max-width: 320px; height: auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<script>
//add hijo
function addhijo(i) {

    var addhijo = '<div id="id-' + i + '"  class="hjs row">';
    addhijo += ' <div class="col-xl-6 my-1 p-2" > ';
    addhijo += ' <div class="d-xl-flex mb-3"> ';
    addhijo += ' <strong class="pr-4 mt-1 mw100"> Nombre* </strong> ';
    addhijo += ' <input type="text" class="form-control datorequerido bgazulclaro" placeholder=""  ';
    addhijo += '              id="Nombrehijo-' + i + '" name="Nombrehijo-' + i + '"> ';
    addhijo += '      </div>';
    addhijo += '  </div>';
    addhijo += '  <div class="col-xl-6 my-1 p-2">';
    addhijo += '      <div class="d-xl-flex mb-3">';
    addhijo += '          <strong class="pr-4 mt-1 mw100"> Apellido1* </strong>';
    addhijo += '          <input type="text" class="form-control datorequerido bgazulclaro" placeholder=""';
    addhijo += '              id="Apellido1hijo-' + i + '" name="Apellido1hijo-' + i + '">';
    addhijo += '      </div>';
    addhijo += '  </div>';
    addhijo += '  <div class="col-xl-6 my-1 p-2">';
    addhijo += '      <div class="d-xl-flex mb-3">';
    addhijo += '          <strong class="pr-4 mt-1 mw100"> Apellido2 </strong>';
    addhijo += '          <input type="text" class="form-control bgazulclaro" placeholder="" id="Apellido2hijo-' + i +
        '" ';
    addhijo += '              name="Apellido2hijo-' + i + '">';
    addhijo += '      </div>';
    addhijo += '  </div>';
    addhijo += '  <div class="col-xl-6 my-1 p-2">';
    addhijo += '      <div class="d-xl-flex mb-3">';
    addhijo += '          <strong class="pr-4 mt-1 mw100"> Curso </strong>';
    addhijo += '          <select class="form-control bgazulclaro" id="Curso-' + i + '" name="Curso-' + i + '">';
    addhijo += '              <option class="bgazulclaro" value=""></option>';
    addhijo += '              @foreach($cursos as $key => $c)';
    addhijo += '              <option class="bgazulclaro" value="{{$c->id}}">{{$c->nombre}}</option>';
    addhijo += '              @endforeach';
    addhijo += '          </select>';
    addhijo += '      </div>';
    addhijo += '  </div>';
    if (i != 0) {
        addhijo += '<div class="col-12 text-center mx-auto" > <div><i onclick="deltrashit(' + i + ')"  id="deltrash-' +
            i +
            '" class="deltrash fas fa-trash text-danger cupo"></i> </div></div>';
    }
    addhijo += '<div class="linesep" ></div>';
    addhijo += '</div>';


    $("#hijos").append(addhijo);
}

function deltrashit(id) {
    $("#id-" + id).html('');
}

// item add
var item = 0;
addhijo(item);
$("#addchild").on('click', function() {
    item++;
    addhijo(item);
});

$('#ap1').on('click', function() {
    $('#ap1').addClass('dnone');
    $('#ac1').removeClass('dnone');
});

$('#ac1').on('click', function() {
    $('#ac1').addClass('dnone');
    $('#ap1').removeClass('dnone');
});

$('#ap2').on('click', function() {
    $('#ap2').addClass('dnone');
    $('#ac2').removeClass('dnone');
    $('#Aceptopublicidad').val("T");
});

$('#ac2').on('click', function() {
    $('#ac2').addClass('dnone');
    $('#ap2').removeClass('dnone');
    $('#Aceptopublicidad').val("F");
});


// aceptar

$("#aceptar").on('click', function() {

    if (validarCampos()) {

        var hijosadd = [];

        $(".hjs").each(function(index) {

            let id = $(this).attr("id").split('-')[1];
            let nom = $("#Nombrehijo-" + id).val();
            let ape1 = $("#Apellido1hijo-" + id).val();
            let ape2 = $("#Apellido2hijo-" + id).val();
            let curso = $("#Curso-" + id).val();

            if (nom != '') {
                hijosadd.push([nom, ape1, ape2, curso]);
            }
        })

        var formData = {
            TutorNombre: $('#TutorNombre').val(),
            TutorApellido: $('#TutorApellido').val(),
            TutorApellido2: $('#TutorApellido2').val(),
            TutorNIF: $('#TutorNIF').val(),
            TutorNacimientoFecha: $('#TutorNacimientoFecha').val(),
            TutorEmail: $('#TutorEmail').val(),
            TutorMovil: $('#TutorMovil').val(),
            Direccion: $('#Direccion').val(),
            Poblacion: $('#Poblacion').val(),
            Provincia: $('#Provincia').val(),
            centros_id: $('#centros_id').val(),
            profesion: $('#profesion').val(),
            aceptarpublicidad: $('#Aceptopublicidad').val(),
            hijos: hijosadd

        }

        guardaradminvisit(formData)
    } else {
        $("#avisoreg").removeClass('dnone');
    }
});


let limit = 0;

function guardaradminvisit(fData) {
    try {
        limit++;
        if (limit < 2) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('adminvisits/guardar')}}",
                data: fData,
                dataType: "json",
                method: "POST",
                success: function(result) {
                    if (result != null) {
                        alert("registro realizado");
                    
                    }
                },
                fail: function() {
                    alert("error al guardar");
                },
                beforeSend: function() {
                    $("#loading-spinner").show();
                },
                complete: function() {
                   $("#loading-spinner").hide();
                }
            });
        }


    } catch (error) {
        console.err(error);
    }
}


//formuario reactivo validaciones

$('.datorequerido').on('keyup', function() {
    if (!isEmpty($(this).val())) {
        $(this).removeClass('invalid_field');
    }
})
$('.fecharequerida').on('change', function() {
    if (!isEmpty($(this).val())) {
        $(this).removeClass('invalid_field');
    }
})
$('.sels').on('change', function() {
    if (!isEmpty($(this).val())) {
        $(this).removeClass('invalid_field');
    }
})

function validarCampos() {
    let valido = true;
    if (isEmpty($('#TutorNombre').val())) {
        valido = false;
        $('#TutorNombre').addClass('invalid_field');
    }
    if (isEmpty($('#TutorApellido').val())) {
        valido = false;
        $('#TutorApellido').addClass('invalid_field');
    }
    if ((NIFvalid($('#TutorNIF').val()))) {
        valido = false;
        $('#TutorNIF').addClass('invalid_field');
    }
    if ((emailvalid($('#TutorEmail').val()))) {
        valido = false;
        $('#TutorEmail').addClass('invalid_field');
    }
    if ((isEmpty($('#TutorNacimientoFecha').val())) || (menoredad($('#TutorNacimientoFecha').val()))) {
        valido = false;
        $('#TutorNacimientoFecha').addClass('invalid_field');
    }
    if (isEmpty($('#Direccion').val())) {
        valido = false;
        $('#Direccion').addClass('invalid_field');
    }
    if (isEmpty($('#Poblacion').val())) {
        valido = false;
        $('#Poblacion').addClass('invalid_field');
    }
    if (isEmpty($('#Provincia').val())) {
        valido = false;
        $('#Provincia').addClass('invalid_field');
    }
    if (isEmpty($('#centros_id').val())) {
        valido = false;
        $('#centros_id').addClass('invalid_field');
    }
    if ($('#ac1').hasClass('dnone')) {
        valido = false;
        $('#ap1').addClass('invalid_ch');
    }

    if (valido) {
        $("#avisoreg").addClass('dnone');
    }
    return valido;
}


function menoredad(fecha) {

    let menor = true
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();
    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
    if (edad > 18) {
        menor = false
    }
    return menor;
}


function isEmpty(value) {
    return (value == null || value.length === 0);
}

function NIFvalid(doc) {
    let valid = true;
    if (/^\d{8}[a-zA-Z]{1}$/.test(doc)) {
        valid = false;
    } else if (/^[XxTtYyZz]{1}[0-9]{7}[a-zA-Z]{1}$/.test(doc)) {
        valid = false;
    }
    return valid;
}


function emailvalid(email) {
    let valid = true;
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(email)) {
        valid = false;
    }
    return valid;
}



</script>

@stop