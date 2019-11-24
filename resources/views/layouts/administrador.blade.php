<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
<!--<script src="{{ asset('js/app.js') }}" defer></script> -->
    <script src="{{ asset('js/app.js') }}" ></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('Glyphicon/css/all.css')}}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/DataTables/datatables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>



    @yield('estilo')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">
            <!--  {{ config('app.name', 'Laravel') }}-->ESFOT
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Right Side Of Navbar -->



                    <!-- Authentication Links -->
                    @guest
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                            </li>
                        @endif
                    </ul>
                    @else
                <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" style="color: #3490dc"  data-toggle="dropdown" href="/GestionDocentes"><i class="fas fa-user"></i>Docentes</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/GestionDocentes">Lista Docentes</a>
                                <a class="dropdown-item" href="/GestionPeriodos">Lista Periodos</a>

                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" style="color: #3490dc" data-toggle="dropdown" href="/Proyectores"><i class="fas fa-video"></i>Proyectores</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/Proyectores">Lista Proyectores</a>

                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" style="color: #3490dc" data-toggle="dropdown" href="/Proyectores"><i class="fas fa-clipboard-list"></i>Reportes</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/ReporteAsistencia">Asistencia</a>
                                <a class="dropdown-item" href="/ReporteProyector">Proyectores</a>
                            </div>
                        </div>

                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>


                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
    @endguest
</div>


@yield('javascript')

</body>

<!--<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>-->
<script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>
<script>
    $(document).ready( function () {

        $.extend( $.fn.dataTable.defaults, {
            searching: false,
            ordering:  false
        } );
        $('#tbl_docentes').DataTable({
            destroy: true,
            searching: true,
            ordering:  true,
            stateSave: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ entradas",
                "zeroRecords": "No se ha encontrado resultados",
                "info": "Mostrándo página _PAGE_ de _PAGES_",
                "sInfo":  "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar:",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"

                }
            }
        });

    } );

</script>
</html>
