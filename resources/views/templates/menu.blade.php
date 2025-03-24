<div class="d-flex " id="wrapper" >

    <div class="activado fondoGris text-light border-right" id="sidebar-wrapper" style=""  >
        <div class="sidebar-heading" style="min-width: 229px !important; text-align: center;">
            <img src="https://madguidesmadrid.com/assets/images/logo-madguides.svg" style="width:100px; height: auto;">
        </div>

        <div id="linksadmin" class="list-group list-group-flush">
            <div class="w-100 text-center mb-2">
                <small><b> MADGUIDES ADMIN</b> </small>
            </div>

            @if(Auth::user()->rol_id == 3)

            <a href="{{ route('inicio') }}" id="linkhome"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                HOME
                <i class="fas fa-home icomenu" style=" right: 15px; "></i>
            </a>
            <a href="{{ route('adminvisits') }}" id="linkadminvisits"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                VISITAS
                <i class="fas fa-plane icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('adminreservas') }}" id="linkadminreservas"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                RESERVAS
                <i class="fas fa-house-user icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('admincitas')  }}" id="linkadmincitas"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                CITAS
                <i class="fas fa-map-signs icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('adminguias')  }}" id="linkadminguias"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                GUIAS
                <i class="fas fa-users icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('adminclientes')  }}" id="linkadminclientes"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                CLIENTES
                <i class="fas fa-users icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('adminfacturacion')  }}" id="linkadminfacturacion"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                FACTURACIÓN
                <i class="fas fa-money-bill-wave icomenu" style=" right: 17px; "></i>
            </a>

            <button   id="btsorteo" class="btn btn-danger m-3">
                SORTEO
            </button>

            @endif

            @if(Auth::user()->rol_id == 2  || Auth::user()->rol_id == 4)

            <a href="{{ route('inicioguias') }}" id="linkhomeguias"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                HOME
                <i class="fas fa-home icomenu" style=" right: 15px; "></i>
            </a>
            <a href="{{ route('adminreservasguia')  }}" id="linkadminreservasguia"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                MIS RESERVAS
                <i class="fas fa-house-user icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('adminguia', ['id' => Auth::user()->id] )  }}" id="linkadminguia"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                MIS DATOS
                <i class="fas fa-user-edit icomenu" style=" right: 17px; "></i>
            </a>

            @endif
            
        </div>
    </div>


    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-light" id="menu-toggle" onclick="mostrar()">
                <i class="fas fa-align-justify fa-2x"></i>
                <span style="position: relative; bottom: 6px "> Menu </span>
            </button>

            <div class="ml-auto mr-1 d-block px-2" style="border-right:2px solid  #87cedb">
                <div class="mx-1 text-right" style="height: 20px;">
                    <strong>
                        Zona de administración
                    </strong>
                </div>
                <div class="m-1 text-right" style="height: 28px;">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                        SALIR <i class="fas fa-sign-out-alt ml-1"></i>
                        </button>
                    </form>
                </div>
            </div>


        </nav>

        <div class="container-fluid">

            @yield('content')

        </div>
    </div>

</div>

<div id="loading-spinner" style="display: none;">
    <div class="spinner"></div>
</div>

<script>
function logout() {
    alert('logout');
}


function mostrar() {
     
    if ($("#sidebar-wrapper").hasClass('activado')) {
        $("#sidebar-wrapper").removeClass('activado').addClass('ocultado');
    } else {
        $("#sidebar-wrapper").removeClass('ocultado').addClass('activado');
    }
}



function ocultarmvl() {

    if (this.esmovil()) {
        mostrar();
    }

}

function esmovil() {
    var ua = navigator.userAgent;
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Mobile|mobile|CriOS/i.test(ua);
}


$("#btsorteo").on('click', function() {
    
    if (confirm('¿Estás seguro de que desea realizar el sorteo?')) {
      try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/adminreservas/sorteo',
            dataType: "json",
            method: "GET",
            success: function(result) {
                console.log("result ",result);
                if(result == true){
                    alert("Sorteo realizado con éxito");
                    location.reload();
                }
            },
            err: function(result) {
                console.log("result ",result);
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