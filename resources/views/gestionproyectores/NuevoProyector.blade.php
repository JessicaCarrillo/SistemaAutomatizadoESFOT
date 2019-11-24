@extends('layouts.administrador')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large">NUEVO PROYECTOR</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form  action="/NuevoProyector"  method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="proyector">Proyector:</label>
                                <input id="proyector" name="proyector" class="form-control" type="text" placeholder="Proyector N°">
                            </div>
                            <div class="form-group">
                                <label for="name">Descripcion:</label>
                                <textarea id="descripcion" name="descripcion" class="form-control" type="text" placeholder="Descripcion"></textarea>
                            </div>

                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

