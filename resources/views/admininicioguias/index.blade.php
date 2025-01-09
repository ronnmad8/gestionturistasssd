@extends('base')
@section('content')

<div class="row">
    <div class="col-12 flex text-center pt-0 my-4">
        <h1>
            ADMIN MADGUIDES GUIAS
        </h1>
    </div>

    <div class="col-12 my-2">
        <div class="panelG text-left">
            <div>
                <h2 class="text-center">Manual de uso para Guías</h2>
            </div>
            <div>
                <p>
                    Este manual describe el funcionamiento de la zona de administración de datos personales y disponibilidad para guías turísticos. Esta sección permite a los guías gestionar su información personal, disponibilidad semanal, periodos de no disponibilidad, idiomas que dominan y lugares de interés que suelen visitar.
                </p>
            </div>

            <div>
                <h3 class="text-center">Tabla de Reservas del Guía</h3>
            </div>
            <div>
                <p>
                    La zona de citas de Guías se puede ver diferentes reservas turísticas ya realizadas o por realizar.
                </p>
                <p>Esta sección muestra un listado de las reservas que tiene asignadas el guía. Permite visualizar información clave de cada reserva y realizar acciones sobre ellas.</p>

                <strong>Componentes principales:</strong>

                <strong>Filtro por fechas:</strong>
                <ul>
                    <li><strong>Fecha inicial (dd/mm/aaaa):</strong> Permite filtrar las reservas mostrando solo aquellas cuya fecha de inicio sea igual o posterior a la fecha seleccionada. Se utiliza un selector de fecha para facilitar la introducción.</li>
                    <li><strong>Fecha final (dd/mm/aaaa):</strong> Permite filtrar las reservas mostrando solo aquellas cuya fecha de finalización sea igual o anterior a la fecha seleccionada. También utiliza un selector de fecha.</li>
                    <li><strong>Botón/Icono de búsqueda (Π):</strong> Este icono ejecuta el filtrado de las reservas basándose en las fechas introducidas.</li>
                </ul>

                <strong>Tabla de reservas:</strong>
                <p>Muestra las reservas en formato de tabla, con las siguientes columnas:</p>
                <table>
                    <thead>
                        <tr>
                            <th>ACCIONES</th>
                            <th>REF</th>
                            <th>ESTADO</th>
                            <th>PEDIDO</th>
                            <th>CLIENTE</th>
                            <th>VISITA</th>
                            <th>IDIOMA</th>
                            <th>FECHA</th>
                            <th>PRECIO €</th>
                            <th>HORA</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>

            <div>
                <h3 class="text-center">Zona de Datos</h3>
            </div>
            <div>
                <section>
                    <strong>Zona de Datos Personales</strong>
                    <p>Esta sección permite al guía ingresar y modificar su información personal. Los campos disponibles son:</p>
                    <ul>
                        <li><strong>Email:</strong> Dirección de correo electrónico del guía. Se utiliza para la comunicación y notificaciones.</li>
                        <li><strong>Nombre:</strong> Nombre del guía.</li>
                        <li><strong>Apellidos:</strong> Apellidos del guía.</li>
                        <li><strong>Teléfono:</strong> Número de teléfono del guía.</li>
                        <li><strong>Provincia:</strong> Provincia de residencia del guía.</li>
                        <li><strong>Ciudad:</strong> Ciudad de residencia del guía.</li>
                        <li><strong>CP:</strong> Código postal del guía.</li>
                        <li><strong>Dirección:</strong> Dirección postal del guía.</li>
                        <li><strong>Número:</strong> Número de la calle de la dirección del guía.</li>
                    </ul>
                </section>

                <section>
                    <strong>Zona de Disponibilidad Semanal</strong>
                    <p>Esta sección permite al guía definir su disponibilidad para cada día de la semana. Para cada día (lunes a domingo), se pueden seleccionar dos franjas horarias:</p>
                    <ul>
                        <li>09:00 - 15:00: Mañana.</li>
                        <li>15:00 - 20:00: Tarde.</li>
                    </ul>
                    <p>Marcando la casilla correspondiente a cada franja horaria, el guía indica que está disponible durante ese periodo.</p>
                </section>

                <section>
                    <strong>Zona de No Disponibilidad</strong>
                    <p>Esta sección permite al guía especificar periodos concretos en los que no estará disponible. Para añadir un periodo de no disponibilidad:</p>
                    <ul>
                        <li>Campo de fecha (dd/mm/aaaa): Seleccionar la fecha de no disponibilidad usando el selector de fecha.</li>
                        <li>Botón "Añadir Fecha": Hacer clic en este botón para agregar la fecha a la lista de periodos de no disponibilidad.</li>
                    </ul>
                </section>

                <section>
                    <strong>Zona de Idiomas Disponibles</strong>
                    <p>En esta sección, el guía puede seleccionar los idiomas que domina, marcando las casillas correspondientes a cada idioma (español, inglés, francés, alemán, italiano, portugués, griego, polaco).</p>
                    <ul>
                        <li>Español</li>
                        <li>Inglés</li>
                        <li>Francés</li>
                        <li>Alemán</li>
                        <li>Italiano</li>
                        <li>Portugués</li>
                        <li>Griego</li>
                        <li>Polaco</li>
                    </ul>
                </section>

                <section>
                    <strong>Zona de Visitas</strong>
                    <p>Esta sección muestra una lista de lugares de interés que el guía suele visitar o que ofrece en sus tours. El guía puede seleccionar los lugares que ofrece, marcando las casillas correspondientes:</p>
                    <ul>
                        <li>Museo del Prado</li>
                        <li>Estadio Santiago Bernabeu</li>
                        <li>Museo Reina Sofía</li>
                        <li>Plaza de toros Las Ventas</li>
                        <li>Palacio Real de Madrid</li>
                        <li>Madrid de los Austrias</li>
                        <li>Paisaje de la Luz</li>
                    </ul>
                </section>

                <section>
                    <strong>Botón "GUARDAR"</strong>
                    <p>Una vez que se han realizado los cambios en cualquiera de las secciones, se debe hacer clic en el botón "GUARDAR" para guardar la información.</p>
                </section>
            </div>
        </div>
    </div>
</div>

<div class="row my-4">
    <div class="col-12 my-2">
        <div class="panelG">
            <div>
                <h3 class="text-center"></h3>
            </div>
            <div>
                <p></p>
            </div>
        </div>
    </div>
</div>

<div style="height: 100px"></div>

<div hidden class="dnone"></div>

<script>
    $('.menu').removeClass('activ');
    $("#linkhomeguias").addClass('activ');
</script>

@stop