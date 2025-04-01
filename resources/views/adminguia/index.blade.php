@extends('base')
@section('content')


<div class="panel panel-default shadow p-3 my-5 bg-white rounded  ">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xl-2 col-12">
                <h2>MIS DATOS</h2>
            </div>
            <!-- <div class="col-xl-2 col-12">
                <button id="crear" type="button" class="btn btn-dark cupo mb-2" title="buscar">
                    <i class="fa fa-plus mr-2"></i> <small> NUEVA VISITA</small>
                </button>
            </div> -->
            </div>
    </div>
    <div class='w100 formulariomodal mxh'>
        <div class="row">
            <div class="col-xl-4 ">
                <div class="dnone">
                    <input id="Cid" name='id'  value="{{ $adminguia->id }}">
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">Email</p>
                    <input type="text" disabled="true" id="Cemail" name="email" class='form-control mxwfield ' value="{{ $adminguia->email }}" >
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">Nombre</p>
                    <input type="text" id="Cnombre" name="nombre" class='form-control mxwfield ' value="{{ $adminguia->name }}" >
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">Apellidos</p>
                    <input type="text" id="Capellidos" name="apellidos" class='form-control mxwfield ' value="{{ $adminguia->surname }}" >
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">Teléfono</p>
                    <input type="text" id="Ctelefono" name="telefono" class='form-control mxwfield ' value="{{ $adminguia->telefono }}" >
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">Provincia</p>
                    <input type="text" id="Cprovincia" name="provincia" class='form-control mxwfield ' value="{{ $adminguia->state }}">
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">Ciudad</p>
                    <input type="text" id="Cciudad" name="ciudad" class='form-control mxwfield ' value="{{ $adminguia->city }}" >
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">CP</p>
                    <input type="text" id="Cpostalcode" name="cp" class='form-control mxwfield ' value="{{ $adminguia->postalcode }}" >
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">Dirección</p>
                    <input type="text" id="Cdireccion" name="direccion" class='form-control mxwfield ' value="{{ $adminguia->address }}" >
                </div>
                <div class="my-2 mx-auto">
                    <p class="m-0">Número</p>
                    <input type="text" id="Cnumero" name="numero" class='form-control mxwfield ' value="{{ $adminguia->number }}" >
                </div>
            </div>



            <div class="col-xl-4 ">
                <div class="my-2 mx-auto">
                    <div class='w100 '>
                        <div class="dnone">
                            <input id="Cg_id" name='Cg_id'>
                        </div>
                        <div class="my-2 mx-auto">
                            <h4>No Disponibilidad</h4>
                            <div id="Cg_nodisponibilidad" class="mb-4 mx-auto">
                            </div>
                            <input type="date" class="form-control mxwfield m-1" id="fechaSeleccionada">

                            <select class="form-control mxwfield m-1" id="franjaSeleccionada">
                                <option value="0">Día completo </option>
                                @foreach($franjashorarias as $franja)
                                <option value="{{ $franja->id }}">{{ $franja->hourinit }} - {{ $franja->hourend }}</option>
                                @endforeach
                            </select>

                            <button id="addFechaBtn" class="btn btn-success m-1" >Añadir Fecha</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-4 dnone">
                <div class="my-2 mx-auto">
                    <div class='w100 '>
                        <div class="dnone">
                            <input id="Cg_id" name='Cg_id'>
                        </div>
                        <div id="Cg_disponibilidad" class="my-2 mx-auto">
                            <h4>Disponibilidad Semanal</h4>
                            @foreach($diassemana as  $key => $dia)
                            <div>
                                <h5>{{$dia}}</h5>
                                <div class="time-slots">
                                @foreach($franjashorarias as $franja)
                                <label>
                                <input id="dia-{{$key}}-{{$franja->id}}"  type="checkbox" name="{{ $dia }}" > 
                                {{ $franja->hourinit }} - {{ $franja->hourend }}
                                </label>
                                @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 ">
                <div class="my-2 mx-auto">
                    <div class='w100 '>
                        <div id="Cg_guialanguages" class="my-2 mx-auto">
                            <h4>Idiomas Disponibles</h4>
                            @foreach($idiomas as  $key => $l)
                            <div>
                                <div class="time-slots">
                                <label>
                                <input id="language-{{$key+1}}"  type="checkbox" name="{{ $l }}" > 
                                {{ $l }}
                                </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr>
                <div class="my-2 mx-auto">
                    <div id="Cg_visitas" class='w100 '>
                        <div class="my-2 mx-auto">
                            <h4>Visitas</h4>
                            @foreach($visitas as  $key => $l)
                            <div>
                                <div class="time-slots">
                                <label>
                                <input id="visit-{{$l->id}}"  type="checkbox" name="{{ $l->nombrevisita }}" > 
                                {{ $l->nombrevisita }}
                                </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 ">
                <div class="m10 mxauto text-center">
                    <button type="button" id="bteditarX" class='m-2 btn btn-info'>GUARDAR</button>
                </div>
            </div>
        </div>

        <div class="dnone">
            <div id="lista_hours" data-hours="{{ json_encode($hours) }}">
            </div>
            <div id="lista_diassemana" data-diassemana="{{ json_encode($diassemana) }}">
            </div>
            <div id="lista_languages" data-idiomas="{{ json_encode($idiomas) }}">
            </div>
            <div id="lista_franjas" data-franjas="{{ json_encode($franjashorarias) }}">
            </div>
            <div id="lista_visitas" data-visitas="{{ json_encode($visitas) }}">
            </div>
            <div id="disponibilities" data-disponibilidad="{{ json_encode($adminguia->disponibilities) }}">
            </div>
            <div id="nodisponibilities" data-nodisponibilidad="{{ json_encode($adminguia->nodisponibilities) }}">
            </div>
            <div id="lista_guialanguages" data-guialanguages="{{ json_encode($adminguia->guialanguages) }}">
            </div>
            <div id="lista_guiavisitas" data-guiavisitas="{{ json_encode($adminguia->guiavisits) }}">
            </div>
        </div>
    </div>
</div>


<script>
    let franjasData = $('#lista_franjas').data('franjas') || [];
    let languages = $('#lista_languages').data('idiomas') || [];
    let visitas = $('#lista_visitas').data('visitas') || [];
    let hoursData = $('#lista_hours').data('hours') || [];
    let diasSemanaData = $('#lista_diassemana').data('diassemana') || [];
    let disponibilities = $('#disponibilities').data('disponibilidad') || [];
    let nodisponibilities = $('#nodisponibilities').data('nodisponibilidad') || [];
    let guialanguagesData = $('#lista_guialanguages').data('guialanguages') || [];
    let guiavisitsData = $('#lista_guiavisitas').data('guiavisitas') || [];

    disponibilities.forEach((disponibilidad) => {
        $('#dia-'+ (disponibilidad.diasemana - 1) +'-'+ disponibilidad.franjahoraria_id).prop('checked', true);
    })
    nodisponibilities.forEach((nodisponibilidad) => {
        let [year, month, day] = nodisponibilidad.fecha.split('-');
        let resultfecha = `${day}/${month}/${year}`;
        $('#Cg_nodisponibilidad').append('<div id="div-'+nodisponibilidad.fecha+'" class="mx-auto my-1"><span class="badge bg-light p-2 ">' + resultfecha + '</span><span class="fa fa-trash bg-danger text-white p-1 cupo eliminarfecha" style="font-size:11px" id="delno-'+nodisponibilidad.fecha+'" ></span></div>');
    })
    guialanguagesData.forEach((guialanguage) => {
        $('#language-'+ (guialanguage.language_id ) ).prop('checked', true);
    })
    guiavisitsData.forEach((guiavisit) => {
        $('#visit-'+ (guiavisit.visit_id ) ).prop('checked', true);
    })

    $('.menu').removeClass('activ');
    $("#linkadminguia").addClass('activ');

    $("#addFechaBtn").on('click', function() {
        let fecha = $('#fechaSeleccionada').val();
        let franjaid = $('#franjaSeleccionada').val();
        if(fecha != undefined){
            let idguia = $('#Cid').val(); 
            let fechaExistente = nodisponibilities.some(function(nodisponibility) {
                return nodisponibility.fecha === fecha;
            });

            if( !fechaExistente ){
                let newnodisponibility = {
                    user_id: parseInt(idguia),
                    fecha: fecha,
                    franjahoraria_id: franjaid
                }
                nodisponibilities.push(newnodisponibility);
                let [yearA, monthA, dayA] = fecha.split('-');
                let resultfechaA = `${dayA}/${monthA}/${yearA}`;
                $('#Cg_nodisponibilidad').append('<div id="div-'+fecha+'" class="mx-auto my-1"><span class="badge bg-light p-2 ">' + resultfechaA + '</span><span class="fa fa-trash bg-danger text-white p-1 cupo eliminarfecha" style="font-size:11px" id="delno-'+fecha+'" ></span></div>');
            }

        }
        
    })

    $('#Cg_nodisponibilidad').on('click', '.eliminarfecha', function() {
        let fecha = $(this).attr('id').split('-')[1];
        let indexNodisponibility = nodisponibilities.findIndex(function(nodisponibility) {
            return nodisponibility.fecha === fecha;
        });
        nodisponibilities.splice(indexNodisponibility, 1);
        $(this).parent().remove();
    })
    
    $("#bteditarX").on('click', function() {

        let idguia = $('#Cid').val();  
        if(idguia != null && idguia != "")
        {
            let email = $('#Cemail').val();
            let name = $('#Cnombre').val();
            let surname = $('#Capellidos').val();
            let telefono = $('#Ctelefono').val();
            let state = $('#Cprovincia').val();
            let city = $('#Cciudad').val();
            let postalcode = $('#Cpostalcode').val();
            let address = $('#Cdireccion').val();
            let number = $('#Cnumero').val();

            let listadisponibilidad = [];
            diasSemanaData.forEach((diasemana, index) => {
                franjasData.forEach(franja => {
                    let diacheck =  $('#dia-'+ (index) +'-'+ franja.id).prop('checked');
                    if(diacheck){
                        let newdisponibility = {
                            user_id: parseInt(idguia),
                            franjahoraria_id: franja.id,
                            diasemana: index+1
                        }
                        listadisponibilidad.push(newdisponibility);
                    }
                })
            })
            let listaidiomas = [];
            languages.forEach((language, index) => {
                let idiomacheck =  $('#language-'+ (index+1) ).prop('checked');
                if(idiomacheck){
                    let newdguialanguage = {
                        user_id: parseInt(idguia),
                        language_id: index+1
                    }
                    listaidiomas.push(newdguialanguage);
                }
            })
            let listavisitas = [];
            visitas.forEach((visita, index) => {
                let visitacheck =  $('#visit-'+ (index+1) ).prop('checked');
                if(visitacheck){
                    let newvisita = {
                        user_id: parseInt(idguia),
                        visit_id: index+1
                    }
                    listavisitas.push(newvisita);
                }
            })
        
            let urlaccion = "{{ route('adminguia/setguia', ['id' => '__id__']) }}".replace('__id__', idguia);

            let formData = {
            id: idguia,
            name: name,
            surname: surname,
            telefono: telefono,
            state: state,
            city: city,
            postalcode: postalcode,
            address: address,
            number: number,
            disponibilities: listadisponibilidad,
            nodisponibilities: nodisponibilities,
            guialanguages: listaidiomas,
            guiavisits: listavisitas
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
                    if (result != null) {
                        console.log("result==> ", result);
                    }
                },
                fail: function() {
                    console.error("fail");
                },
                beforeSend: function() {
                    $("#loading-spinner").show();
                },
                complete: function() {
                   $("#loading-spinner").hide();
                }
            });         
            } catch (error) {
            console.err(error);
            }       
        }    
    });


            
</script>



@stop
