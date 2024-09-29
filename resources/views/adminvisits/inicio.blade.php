@extends('base')
@section('content')


<div class="row">

    <div class="col-12 flex text-center pt-0 my-4">
        <h1>
           ADMIN MADGUIDES
        </h1>
    </div>

    <div class="col-12 my-2 ">
        <div class="panelG text-left">
            <div>
                <h2 class="text-center">Manual de uso</h3>
            </div>
            <div>
                <h3>Zona Visitas</h4>
            </div>
            <div>
                <p>
                La zona de gestión de visitas de la aplicación permite a los administradores crear y editar diferentes visitas turísticas, ofreciendo flexibilidad en cuanto a la oferta, idiomas, precios y otras características. A continuación, se describe cómo utilizar esta área de la aplicación.
                </p>
            </div>
            <div>
                <h4>Crear una Nueva Visita</h4>
            </div>
            <div>
                <p>
                Para agregar una nueva visita, presione el botón + NUEVA VISITA. Esto abrirá un formulario donde deberá ingresar los detalles de la nueva visita, tales como nombre, categorías, idiomas disponibles, precios, entre otros.
                </p>
            </div>
            <div>
                <h4>Tabla de Visitas</h4>
            </div>
            <div>
                <p>
                La tabla que se muestra en la zona de gestión permite visualizar y editar todas las visitas creadas. Cada fila en la tabla representa una visita diferente con los siguientes campos:
                </p>
                <p>
EDITAR: El ícono de engranaje permite modificar una visita existente. Haga clic en el ícono para editar los detalles de la visita seleccionada.
                </p>
                <p>
NOMBRE: Nombre de la visita o tour. Ejemplo: "siete", "seis", "cinco", etc.
                </p>
                <p>
CATEGORÍAS: Las categorías ayudan a clasificar la visita, por ejemplo, en base a lugares de interés como "prado", "museos" o "toledo", o actividades como "flamenco".
                </p>
                <p>
TAGS: Etiquetas adicionales que describen más a fondo la visita. Esto puede incluir si es una oferta especial, si es exterior o si tiene alta demanda.
                </p>
                <p>
IDIOMAS: Los idiomas disponibles en los que se ofrece la visita. Ejemplos: Español, Inglés, Alemán, Francés.
                </p>
                <p>
PRECIO (€): El costo de la visita, expresado en euros.
                </p>
                <p>
MIN: El número mínimo de personas requerido para que la visita pueda llevarse a cabo.
                </p>
                <p>
MAX: El número máximo de personas permitido para cada visita.
                </p>
                <p>
DURACIÓN (min): La duración estimada de la visita en minutos. Ejemplo: 120 minutos.
                </p>
                <p>
CANCELACIÓN: Indica si la visita admite cancelación. Opciones: "Sí" o "No".
                </p>
                <p>
TEMPORADA: Si la visita está disponible solo en una temporada específica. Opciones: "Sí" o "No".
                </p>
                <p>
MASCOTAS: Indica si se permiten mascotas durante la visita. Opciones: "Sí" o "No".
                </p>
                <p>
ACCESIBILIDAD: Indica si la visita es accesible para personas con discapacidades. Opciones: "Sí" o "No".
                </p>
                <p>
RECOMENDADO: Indica si la visita es recomendada. Opciones: "Sí" o "No".
                </p>
            </div>
            <div>
                <h4>Editar una Visita</h4>
            </div>
            <div>
                <p>
                Para modificar los detalles de una visita existente, haga clic en el ícono de engranaje en la columna "EDITAR". Esto abrirá un formulario donde podrá ajustar cualquier campo previamente ingresado.
                </p>
            </div>
            <div>
                <h4>Campos Clave al Crear o Editar una Visita</h4>
            </div>
            <div>
                <p>
                Al crear o editar una visita, deberá llenar los siguientes campos en el formulario:
                </p>
                <p>
Nombre: El nombre de la visita.
                </p>
                <p>
Categorías: Los principales temas o destinos de la visita.
                </p>
                <p>
Etiquetas (tags): Palabras clave para describir mejor la visita.
                </p>
                <p>
Idiomas: Seleccione uno o varios idiomas en los que se ofrece la visita.
                </p>
                <p>
Precio (€): El costo de la visita.
                </p>
                <p>
Mínimo y Máximo de participantes: Determine el mínimo y máximo número de personas.
               </p>
               <p>
Duración: La duración total de la visita en minutos.
               </p>
                <p>
Política de Cancelación: Si la visita permite cancelación (Sí/No).
                </p>
                <p>
Temporada: Especifique si está disponible solo en ciertas épocas.
                </p>
                <p>
Mascotas: Indique si se permiten mascotas durante la visita.
                </p>
                <p>
Accesibilidad: Indique si la visita es accesible para personas con discapacidades.
                </p>
                <p>
Recomendación: Marque si la visita es recomendada para los clientes.
                </p>
            </div>
        </div>
    </div>
   

</div>


<div class="row my-4">
<div class="col-12 my-2">
        <div class="panelG ">
            <div>
                <h3 class="text-center"></h3>
            </div>
            <div>
                <p>
            
                </p>
            </div>
        </div>
    </div>

</div>
<div style="height: 100px">

</div>


<div hidden class="dnone">


     <div id="adminvisitstotal">{{$adminvisitstotal ?? '' }}</div>
     @foreach($visittags as $c)
        <div  id="c-{{$c['id'] ?? ''}}" class="clis" >{{$c["valor"] ?? '' }}</div>
     @endforeach


</div>
   


<script>

$('.menu').removeClass('activ');
$("#linkhome").addClass('activ');




</script>




@stop