@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">CRONOGRAMA</div>
                    <div class="card-body">
                    <!--if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        endif-->
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif

                                        <center><h3>No exiten cronogramas registrados!!!</h3>
                                            <h4>Es necesario subir archivo mediante el siguiente formato <a role="button" class="btn btn-success btn-sm" href="{{ asset('Documents/FormatoCronograma.csv') }}">Descargar</a>
                                            </h4></center>
                                        <div class="text-lg-center" >
                                            <div class="text-center" >
                                                <form action="{{route('import')}}" method="post" id="subir" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    <center  >
                                                        <select name="id_periodo" id="id_periodo" class="form-control col-md-6" >
                                                            <option value="">--Seleccione período--</option>
                                                            @foreach($periodos as $periodo)
                                                                <option value="{{$periodo->id_periodo}}">{{$periodo->periodo}}</option>
                                                            @endforeach
                                                        </select>
                                                    </center>
                                                    {!! $errors->first('id_periodo','<small style="color:Red;">:message</small>')!!}
                                                    <br>
                                                    <input type="file"  name="file"  >
                                                    <button class="btn btn-outline-secondary" >Subir</button>
                                                    <input type="hidden" id="id_docente" name="id_docente" value="{{$docentes->id}}">
                                                    <br>
                                                    {!! $errors->first('file','<small style="color:Red;">:message</small>')!!}
                                                </form>
                                            </div>
                                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection