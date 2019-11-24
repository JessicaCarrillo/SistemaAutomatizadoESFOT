@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">EDITAR DOCENTE</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  action="/EditarProyector/{{$proyectores->id_proyector}}"  method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label for="proyector">Proyector:</label>
                                <input id="proyector" name="proyector" class="form-control" type="text" placeholder="Proyector N°" value="{{$proyectores->proyector}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Descripcion:</label>
                                <textarea id="descripcion" name="descripcion" class="form-control" type="text" placeholder="Descripcion">{{$proyectores->descripcion}}</textarea>
                            </div>
                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

