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
            <button id="crear" type="button" class="btn btn-dark cupo mb-2" title="buscar">
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

                    <th style="min-width: 200px">ACCIONES</th>
                    <th style="min-width: 100px">NOMBRE</th>
                    <th style="min-width: 100px">CATEGORÍAS</th>
                    <th style="min-width: 100px">TAGS</th>
                    <th style="min-width: 100px">IDIOMAS</th>
                    <th style="min-width: 100px"> <span> PRECIO €</span></th>
                    <th style="min-width: 100px"><div><i class="mr-1 fa fa-user"></i> MIN</div></th>
                    <th style="min-width: 100px"><i class="mr-1 fa fa-user"></i> MAX</th>
                    <th style="min-width: 150px">DURACION min</th>
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

                    <td style="min-width: 200px;">
                        <button type='button' id='edit-{{$c->id}}' class='editar btn btn-warning py-0'>
                            <i class='fa fa-cog'></i>
                        </button>
                        <button type='button' id='delete-{{$c->id}}' class='btdelete btn btn-danger py-0'>
                            <i class='fa fa-trash' style="color: #000"></i>
                        </button>
                    </td>
                    
                    <td style='width: 200px'>
                        <div id='Ename-{{$c->id}}'>{{$c->name}}</div>
                    </td>

                    <td style='width: 100px'>
                        <div id='Ecategorias-{{$c->id}}'>{{ $c->visitcategories->pluck('category.name')->join(', ') }}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Etags-{{$c->id}}'>{{ $c->visittags->pluck('tags.name')->join(', ') }}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Elanguages-{{$c->id}}'>{{ $c->visitlanguages->pluck('languages.name')->join(', ') }}</div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Eprecio-{{$c->id}}'>{{$c->precio}}</div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Enummin-{{$c->id}}'>{{$c->nummin}} </div>
                    </td>
                    <td style='width: 100px'>
                        <div id='Enummax-{{$c->id}}'>{{$c->nummax}} </div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Eduracionmin-{{$c->id}}'>{{$c->duracionmin}}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Ecancelaciontext-{{$c->id}}'>{{$c->cancelacion == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Etemporadatext-{{$c->id}}'>{{$c->temporada == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Emascotastext-{{$c->id}}'>{{$c->mascotas == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Eaccesibilidadtext-{{$c->id}}'>{{$c->accesibilidad == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 50px'>
                        <div id='Erecomendadotext-{{$c->id}}'>{{$c->recomendado == 1 ? 'Si' : 'No'  }}</div>
                    </td>
                    <td style='width: 200px'>
                        <div id='Epuntoencuentro-{{$c->id}}'>{{$c->puntoencuentro}}</div>
                    </td>
                    <td style='width: 300px'>
                        <div id='Epuntoencuentrotext-{{$c->id}}'>{{$c->puntoencuentrotext}}</div>
                    </td>
                    <div class="dnone" hidden>
                        <div id='Euuid-{{$c->id}}'>{{$c->uuid}}</div>
                        <div id='Epreciohoramin-{{$c->id}}'>{{$c->preciohoramin}}</div>
                        <div id='Ecancelacion-{{$c->id}}'>{{$c->cancelacion}}</div>
                        <div id='Etemporada-{{$c->id}}'>{{$c->temporada}}</div>
                        <div id='Emascotas-{{$c->id}}'>{{$c->mascotas}}</div>
                        <div id='Eaccesibilidad-{{$c->id}}'>{{$c->accesibilidad}}</div>
                        <div id='Erecomendado-{{$c->id}}'>{{$c->recomendado}}</div>
                        <div id='Epuntoencuentrotext-{{$c->id}}'>{{$c->puntoencuentrotext}}</div>
                        
                        <div id='Evisitcategories-{{$c->id}}'> 
                            @if ($c->visitcategories->isNotEmpty())
                            {{ $c->visitcategories->pluck('category_id')->join(',') }}
                            @endif
                        </div>
                        <div id='Evisittags-{{$c->id}}'> 
                            @if ($c->visittags->isNotEmpty())
                            {{ $c->visittags->pluck('tags_id')->join(',') }}
                            @endif
                        </div>
                        <div id='Evisitlanguages-{{$c->id}}'> 
                            @if ($c->visitlanguages->isNotEmpty())
                            {{ $c->visitlanguages->sortBy('language_id')->pluck('language_id')->join(',') }}
                            @endif
                        </div>
                        <div id='Evisitlanguagesname-{{$c->id}}'> 
                            @if ($c->visitlanguages->isNotEmpty())
                              {{ $c->visitlanguages->sortBy('language_id')->pluck('name')->join(',') }}
                            @endif
                        </div>
                        <div id='Evisitlanguagesdescripcion-{{$c->id}}'> 
                            @if ($c->visitlanguages->isNotEmpty())
                              {{ $c->visitlanguages->sortBy('language_id')->pluck('descripcion')->join(',,,') }}
                            @endif
                        </div>


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
                    <th style="min-width: 100px">NOMBRE</th>
                    <th style="min-width: 100px">CATEGORÍAS</th>
                    <th style="min-width: 100px">TAGS</th>
                    <th style="min-width: 100px">IDIOMAS</th>
                    <th style="min-width: 100px"><div> PRECIO €</div></th>
                    <th style="min-width: 100px"><div><i class="mr-1 fa fa-user"></i> MIN</div></th>
                    <th style="min-width: 100px"><i class="mr-1 fa fa-user"></i> MAX</th>
                    <th style="min-width: 150px">DURACION min</th>
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
                    <div class='w100 formulariomodal'>

                        <div class="dnone">
                            <input id="Cid" name='id'>
                        </div>

                        <div class="my-2 mx-auto">
                            <p class="m-0">Nombre</p>
                            <input type="text" id="Cname" name="name" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Categorias</p>
                            <select class="form-control" id="Cvisitcategories" name="Cvisitcategories[]" multiple>
                            @foreach ($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Tags</p>
                            <select class="form-control" id="Cvisittags" name="Cvisittags[]" multiple>
                            @foreach ($tags as $tag)
                              <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Idiomas</p>
                            <select class="form-control" id="Cvisitlanguages" name="Cvisitlanguages[]" multiple>
                            @foreach ($languages as $language)
                              <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="my-4 mx-auto bg-light p-2">
                        @foreach ($languages as $language)
                            <div class="idioma-section" id="Cidioma_{{$language->id}}"   >
                                <p class="m-0">{{$language->name}}</p>
                                <div class="my-2 mx-auto">
                                    <p class="m-0">Nombre en {{ $language->name }}</p>
                                    <input type="text" id="Clanguagename_{{ $language->id }}" name="Clanguagename_{{ $language->id }}" class='form-control'  >
                                </div>
                                <div class="my-2 mx-auto">
                                    <p class="m-0">Descripción en {{ $language->name }}</p>
                                    <input type="text" id="Clanguagedescripcion_{{ $language->id }}" name="Clanguagedescripcion_{{ $language->id }}" class='form-control' >
                                </div>
                            </div>
                        @endforeach
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
                            <p class="m-0">Duración</p>
                            <input type="number" id="Cduracionmin" name="duracionmin" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Punto encuentro</p>
                            <input type="text" id="Cpuntoencuentro" name="puntoencuentro" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Punto encuentro texto</p>
                            <input type="text" id="Cpuntoencuentrotext" name="puntoencuentrotext" class='form-control'>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Cancelación</p>
                            <select class="form-control" id="Ccancelacion" name="Ccancelacion">
                                <option value="0" selected>NO</option>
                                <option value="1" selected>SI</option>
                            </select>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Temporada</p>
                            <select class="form-control" id="Ctemporada" name="Ctemporada">
                                <option value="0" selected>NO</option>
                                <option value="1" selected>SI</option>
                            </select>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Mascotas</p>
                            <select class="form-control" id="Cmascotas" name="Cmascotas">
                                <option value="0" selected>NO</option>
                                <option value="1" selected>SI</option>
                            </select>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Accesibilidad</p>
                            <select class="form-control" id="Caccesibilidad" name="Caccesibilidad">
                                <option value="0" selected>NO</option>
                                <option value="1" selected>SI</option>
                            </select>
                        </div>
                        <div class="my-2 mx-auto">
                            <p class="m-0">Recomendado</p>
                            <select class="form-control" id="Crecomendado" name="Crecomendado">
                                <option value="0" selected>NO</option>
                                <option value="1" selected>SI</option>
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


$('.menu').removeClass('activ');
$("#linkadminvisits").addClass('activ');


$(".editar").on('click', function() {

    let id = $(this).attr('id').split('-')[1];
    let visit_categoriestext = $('#Evisitcategories-' + id).text();
    let categories = visit_categoriestext.split(',').map(id => id.trim());
    let visit_tagstext = $('#Evisittags-' + id).text();
    let tags = visit_tagstext.split(',').map(id => id.trim());
    let visit_languagestext = $('#Evisitlanguages-' + id).text();
    let languages = visit_languagestext.split(',').map(id => id.trim());

    let visit_languages_nametext = $('#Evisitlanguagesname-' + id).text();
    var languages_name = visit_languages_nametext.split(',').map(id => id.trim());
    let visit_languages_descripciontext = $('#Evisitlanguagesdescripcion-' + id).text();
    var languages_descripcion = visit_languages_descripciontext.split(',,,').map(id => id.trim());

    var visit_languagesdata = [];
    let key = 0;
    languages.forEach(function(i){
        visit_languagesdata.push({
        language_id: i,
        name: languages_name[key],
        descripcion: languages_descripcion[key]
        });
        key++;
    });

    console.log("**categories ==> ",categories);
    console.log("**tags ==> ",tags);
    console.log("**languages ==> ",languages);
    console.log("**languages_name ==> ",languages_name);
    console.log("**languages_descripcion ==> ",languages_descripcion);

    let name = $('#Ename-' + id).text();
    let precio = parseInt($('#Eprecio-' + id).text());
    let nummin = parseInt($('#Enummin-' + id).text());
    let nummax = parseInt($('#Enummax-' + id).text());
    let duracionmin = parseInt($('#Eduracionmin-' + id).text());
    let cancelacion = $('#Ecancelacion-' + id).text();
    let temporada = $('#Etemporada-' + id).text();
    let mascotas = $('#Emascotas-' + id).text();
    let accesibilidad = $('#Eaccesibilidad-' + id).text();
    let recomendado = $('#Erecomendado-' + id).text();
    let puntoencuentro = $('#Epuntoencuentro-' + id).text();
    let puntoencuentrotext = $('#Epuntoencuentrotext-' + id).text();
    let model = $('#Emodel-' + id).text();
    let visitObject = JSON.parse(model);
    
    console.log("model visita ==> ",visitObject);


    $('#Cvisitlanguages').on('change', function() {
        mostraridiomasactivados(visit_languagesdata);
    });

    // function mostraridiomasactivados(){
    //     let selectedLanguages = $('#Cvisitlanguages').val();
    //     $('.idioma-section').addClass(' dnone ');
    //     if (selectedLanguages) {
    //         selectedLanguages.forEach(function(id) {
    //             $('#Cidioma_' + id).removeClass('dnone');
    //             let namedata = visit_languagesdata.filter(x=> x.language_id == id).map(x=> x.name) || "";
    //             let descriptiondata = visit_languagesdata.filter(x=> x.language_id == id).map(x=> x.descripcion) || "";
    //             $('#Clanguagename_'+ id).val(namedata);
    //             $('#Clanguagedescripcion_'+ id).val(descriptiondata);
    //         });
    //     }
    // }


    $('#Cid').val(id);
    $('#Cname').val(name);
    $('#Cprecio').val(precio);
    $('#Cnummin').val(nummin);
    $('#Cnummax').val(nummax);
    $('#Ccancelacion').val(cancelacion);
    $('#Cduracionmin').val(duracionmin);
    $('#Ctemporada').val(temporada);
    $('#Cmascotas').val(mascotas);
    $('#Caccesibilidad').val(accesibilidad);
    $('#Crecomendado').val(recomendado);
    $('#Cpuntoencuentro').val(puntoencuentro);
    $('#Cpuntoencuentrotext').val(puntoencuentrotext);
    
    $('#Cvisitcategories').val(categories);
    $('#Cvisittags').val(tags);
    $('#Cvisitlanguages').val(languages);


    $('#abrirModalX').click();
    $('#form-data-display').removeClass('oculto');
    updateFormData();
    mostraridiomasactivados(visit_languagesdata);
});


$("#crear").on('click', function() {

let name = "";
let precio = 0;
let nummin = 0;
let nummax = 0;
let duracionmin = 0;
let cancelacion = 0;
let temporada = 0;
let mascotas = 0;
let accesibilidad = 0;
let recomendado = 0;
let puntoencuentro = "";
let puntoencuentrotext = "";
let categories = [];
let tags = [];
let languages = [1];

var visit_languagesdata = [];

$('#Cvisitlanguages').on('change', function() {
    mostraridiomasactivados(visit_languagesdata);
});



$('#Cid').val(null);
$('#Cname').val(name);
$('#Cprecio').val(precio);
$('#Cnummin').val(nummin);
$('#Cnummax').val(nummax);
$('#Ccancelacion').val(cancelacion);
$('#Cduracionmin').val(duracionmin);
$('#Ctemporada').val(temporada);
$('#Cmascotas').val(mascotas);
$('#Caccesibilidad').val(accesibilidad);
$('#Crecomendado').val(recomendado);
$('#Cpuntoencuentro').val(puntoencuentro);
$('#Cpuntoencuentrotext').val(puntoencuentrotext);
$('#Cvisitcategories').val(categories);
$('#Cvisittags').val(tags);
$('#Cvisitlanguages').val(languages);

$('#abrirModalX').click();
$('#form-data-display').removeClass('oculto');
updateFormData();
mostraridiomasactivados(visit_languagesdata);
});


//bteditarX
$("#bteditarX").on('click', function() {
    var create = false;
    let urlaccion = "{{ route('adminvisits/updatevisit')}}";
    let idaccion = $('#Cid').val();
    if(idaccion == null || idaccion == "" ){
        urlaccion = "{{ route('adminvisits/createvisit')}}";
        create = true;
    }

    let visit_languages_data = [];
    let visit_languages = $('#Cvisitlanguages').val();

    visit_languages.forEach(function(lId) {
        let languagenameid = $('#Clanguagename_'+ lId).val();
        let languagedescripcionid = $('#Clanguagedescripcion_'+ lId).val(); 
        visit_languages_data.push({
        language_id: lId,
        name: languagenameid,
        descripcion: languagedescripcionid
        });

    });
    let formData = {
        id: idaccion,
        name: $('#Cname').val(),
        precio: $('#Cprecio').val(),
        nummin: $('#Cnummin').val(),
        nummax: $('#Cnummax').val(),
        visitcategories: $('#Cvisitcategories').val(),
        visittags: $('#Cvisittags').val(),
        visitlanguages: visit_languages_data,
        duracionmin: $('#Cduracionmin').val(),
        cancelacion: $('#Ccancelacion').val(),
        temporada: $('#Ctemporada').val(),
        mascotas: $('#Cmascotas').val(),
        accesibilidad: $('#Caccesibilidad').val(),
        recomendado: $('#Crecomendado').val(),
        puntoencuentro: $('#Cpuntoencuentro').val(),
        puntoencuentrotext: $('#Cpuntoencuentrotext').val()

    }
    console.log("payload ",formData);
    console.log("urlaccion ",urlaccion);
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
                    if(create){
                        location.reload();
                    }
                    else
                    {
                      let id = result["id"];
                      $("#Ename-" + id).text(result["name"]);
                      $("#Eprecio-" + id).text(result["precio"]);
                      $("#Enummin-" + id).text(result["nummin"]);
                      $("#Enummax-" + id).text(result["nummax"]);
                      $("#Eduracionmin-" + id).text(result["duracionmin"]);
                      $("#Ecancelacion-" + id).text(result["cancelacion"]);
                      $("#Etemporada-" + id).text(result["temporada"]);
                      $("#Emascotas-" + id).text(result["mascotas"]);
                      $("#Eaccesibilidad-" + id).text(result["accesibilidad"]);
                      $("#Erecomendado-" + id).text(result["recomendado"]);
                      $("#Epuntoencuentro-" + id).text(result["puntoencuentro"]);
                      $("#Epuntoencuentrotext-" + id).text(result["puntoencuentrotext"]);
                      let resultvisitcategories = result["visitcategories"];
                      if (resultvisitcategories && Array.isArray(resultvisitcategories) && resultvisitcategories.length > 0 )
                      {
                        $("#Evisitcategories-" + id).text(resultvisitcategories.filter(category => category.category && category.category.id).map(category => category.category.id).join(','));
                        $("#Ecategorias-" + id).text(resultvisitcategories.filter(category => category.category && category.category.name).map(category => category.category.name).join(','));
                      }
                      let resultvisittags = result["visittags"];
                      if (resultvisittags && Array.isArray(resultvisittags) && resultvisittags.length > 0 )
                      {
                        $("#Evisittags-" + id).text(resultvisittags.filter(tag => tag.tags && tag.tags.id).map(tag => tag.tags.id).join(','));
                        $("#Etags-" + id).text(resultvisittags.filter(tag => tag.tags && tag.tags.name).map(tag => tag.tags.name).join(','));
                      }
                      let resultvisitlanguages = result["visitlanguages"];
                    
                      if (resultvisitlanguages && Array.isArray(resultvisitlanguages) && resultvisitlanguages.length > 0 )
                      {
                        $("#Evisitlanguages-" + id).text(resultvisitlanguages.filter(language => language.languages && language.languages.id).map(language => language.language_id).join(','));
                        $("#Evisitlanguagesname-" + id).text(resultvisitlanguages.filter(language => language.languages && language.languages.id).map(language => language.name).join(','));
                        $("#Evisitlanguagesdescripcion-" + id).text(resultvisitlanguages.filter(language => language.languages && language.languages.id).map(language => language.descripcion).join(',,,'));
                      }
                      $("#Elanguages-" + id).text(result["visitlanguages"].map(l => l.languages.name).join(','));
                    }
                }
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
            url: '/adminvisits/deletevisit',
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
            }
        })
      }catch (error) {
        console.err(error);
      }
    }
});


function mostraridiomasactivados(visit_languagesdatax){
    let selectedLanguages = $('#Cvisitlanguages').val();
    $('.idioma-section').addClass(' dnone ');
    if (selectedLanguages) {
        selectedLanguages.forEach(function(id) {
            $('#Cidioma_' + id).removeClass('dnone');
            let namedata = visit_languagesdatax.filter(x=> x.language_id == id).map(x=> x.name) || "";
            let descriptiondata = visit_languagesdatax.filter(x=> x.language_id == id).map(x=> x.descripcion) || "";
            $('#Clanguagename_'+ id).val(namedata);
            $('#Clanguagedescripcion_'+ id).val(descriptiondata);
        });
    }
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

<div id="form-data-display" class="oculto" >
        <h3>Valores del formulario</h3>
        <span>Nombre: </span><span id="displayName"></span><br>
        <span>Precio: </span><span id="displayPrecio"></span><br>
        <span>Número Mínimo: </span><span id="displayNumMin"></span><br>
        <span>Número Máximo:</span><span id="displayNumMax"></span><br>
        <span>Categorías:</span><span id="displayCategories"></span><br>
        <span>Tags:</span><span id="displayTags"></span><br>
        <span>Idiomas:</span><span id="displayLanguages"></span><br>
        <span>Duración mínima:</span><span id="displayDuracionMin"></span><br>
        <span>Cancelación:</span><span id="displayCancelacion"></span><br>
        <span>Temporada:</span><span id="displayTemporada"></span><br>
        <span>Mascotas:</span><span id="displayMascotas"></span><br>
        <span>Accesibilidad:</span><span id="displayAccesibilidad"></span><br>
        <span>Recomendado:</span><span id="displayRecomendado"></span><br>
        <span>Punto de encuentro:</span><span id="displayPuntoEncuentro"></span><br>
        <span>Texto del punto de encuentro:</span><span id="displayPuntoEncuentroText"></span><br>
    </div>

    <script>
            // Función para actualizar los valores en el div
            function updateFormData() {
                
                $('#displayName').text('' + $('#Cname').val());
                $('#displayPrecio').text('' + $('#Cprecio').val());
                $('#displayNumMin').text('' + $('#Cnummin').val());
                $('#displayNumMax').text('' + $('#Cnummax').val());

                let visitcategories = $('#Cvisitcategories').val();
                $('#displayCategories').text('' + (visitcategories));
                let visittags = $('#Cvisittags').val();
                $('#displayTags').text('' + (visittags));
                let visitlanguages = $('#Cvisitlanguages').val();
                $('#displayLanguages').text('' + (visitlanguages));

                $('#displayDuracionMin').text('' + $('#Cduracionmin').val());
                $('#displayCancelacion').text('' + $('#Ccancelacion').val());
                $('#displayTemporada').text('' + $('#Ctemporada').val());
                $('#displayMascotas').text('' + $('#Cmascotas').val());
                $('#displayAccesibilidad').text('' + $('#Caccesibilidad').val());
                $('#displayRecomendado').text('' + $('#Crecomendado').val());
                $('#displayPuntoEncuentro').text('' + $('#Cpuntoencuentro').val());
                $('#displayPuntoEncuentroText').text('' + $('#Cpuntoencuentrotext').val());

            }
            $('.formulariomodal input, .formulariomodal select').on('input change', function () {
                updateFormData();
            });

            $('#btcloseeditar').on('click', function (){
                $('#form-data-display').addClass('oculto');
            })
    </script>


@stop