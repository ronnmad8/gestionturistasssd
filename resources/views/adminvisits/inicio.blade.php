@extends('base')
@section('content')


<div class="row">

    <div class="col-12 flex text-center pt-0 my-4">
        <h1>
           ADMIN MADGUIDES
        </h1>
    </div>

    <div class="col-xl-6 my-2">
        <div class="panelM ">
            <div>
                <h3 class="text-center">VISITAS</h3>
            </div>
            <div>
                <h4 class="text-center">Total {{$visitastotal ?? ''}}</h4>
            </div>
            <div>
                <canvas class="w-100 h-100 canv" id="datos1">

                </canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6 my-2">
        <div class="panelM ">
            <div>
                <h3 class="text-center">GUIAS</h3>
            </div>
            <div>
                <h4 class="text-center">Total {{$guiastotal ?? ''}}</h4>
            </div>
            <div>
                <canvas class="w-100 h-100 canv" id="datos2">

                </canvas>
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