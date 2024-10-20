<div class="d-flex " id="wrapper" >

    <div class="activado fondoGris text-light border-right" id="sidebar-wrapper" style=""  >
        <div class="sidebar-heading" style="min-width: 229px !important; text-align: center;">
            <img src="https://madguidesmadrid.com/assets/images/logo-madguides.svg" style="width:100px; height: auto;">
        </div>

        <div id="linksadmin" class="list-group list-group-flush">
            <div class="w-100 text-center mb-2">
                <small><b> MADGUIDES ADMIN</b> </small>
            </div>
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
                <i class="fas fa-users icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('inicio')  }}" id="linkcitas"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                CITAS
                <i class="fas fa-users icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('inicio')  }}" id="linkguias"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                GUIAS
                <i class="fas fa-users icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('inicio')  }}" id="linkclientes"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                CLIENTES
                <i class="fas fa-users icomenu" style=" right: 17px; "></i>
            </a>
            <a href="{{ route('inicio')  }}" id="linkfacturacion"
                class="menu cupo posrel list-group-item list-group-item-action text-light border-light">
                FACTURACIÓN
                <i class="fas fa-users icomenu" style=" right: 17px; "></i>
            </a>

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
</script>