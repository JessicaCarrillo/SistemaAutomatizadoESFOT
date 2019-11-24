@extends('layouts.usuario')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" >
                    <div class="card-header" align="center" style="font-size: xx-large"><u>GESTIÓN DE ASISTENCIA</u>
                    </div>

                    <div class="card-body" align="center">
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif

                            <form  action="/Asistencia"  method="post">
                                {{csrf_field()}}
                            <div class="col-md-8">
                                <select name="capitulo" id="capitulo" class="form-control" >
                                    <option  value="">----Seleccione Capítulo----</option>
                                    @foreach($cronogramas as $cronograma)
                                        <option value="{{$cronograma->capitulo}}">{{$cronograma->capitulo}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <br>
                            <div class="col-md-8">
                                <select name="tema" id="tema" class="form-control" >

                                </select>
                            </div>
                            <br>
                            <div class="col-md-8">
                              <!--  <textarea  class="form-control" name="" id=""  rows="3">{$cronogramas[0]->detalle}}</textarea>-->
                                <textarea  class="form-control" name="detalle" id="detalle"  rows="3"></textarea>
                            </div>
                            <br>
                            <input type="hidden" id="id_cronograma" name="id_cronograma"  value="">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="id_permiso" value="permiso">
                                <label class="form-check-label" for="exampleCheck1">Permiso</label>
                            </div>
                                <input type="hidden" name="permiso" id="permiso">
                                <input type="hidden" name="hora_registro" id="hora_registro" value="{{ date('H:i:s') }}">
                                <input type="hidden" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
                        <div>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                            </form>
                            <br>
                        <div  class="table-responsive">
                            <!--    <table class="table">
                                  <thead class="thead-dark">
                                  <tr>
                                      <th scope="col">Fecha</th>
                                      <th scope="col">Hora Inicio</th>
                                      <th scope="col">Hora Fin</th>
                                      <th scope="col">Capítulos/Subcapítulos</th>
                                      <th scope="col">Tema</th>
                                      <th scope="col">Detalle de actividades</th>
                                  </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>-->

                             <table class="table">
                                  <thead class="thead-light">
                                  <tr>
                                      <th scope="col">Fecha</th>
                                      <th scope="col">Hora Inicio</th>
                                      <th scope="col">Hora Fin</th>
                                      <th scope="col">Capítulos</th>
                                      <th scope="col">Tema</th>
                                      <th scope="col">Detalle de actividades</th>
                                      <th scope="col">Observación</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($asistencias as $asistencia)
                                      <tr>
                                          <td>{{$asistencia->fecha_registro}}</td>
                                          <td>{{$asistencia->hora_inicio}}</td>
                                          <td>{{$asistencia->hora_fin}}</td>
                                          <td>{{$asistencia->capitulo}}</td>
                                          <td>{{$asistencia->tema}}</td>
                                          <td>{{$asistencia->detalle}}</td>
                                          <td>{{$asistencia->observacion}}</td>
                                      </tr>
                                      @endforeach

                                  </tbody>
                              </table>
                        </div>

                    </div>
                    <div align="center">
                        <a type="button" style="margin-bottom: 10px; font-size: 25px" href="/docente" class="btn btn-secondary btn-sm" >Regresar</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(document).on('change','input[type="checkbox"]' ,function(e) {
            if(this.id=="id_permiso") {
                if(this.checked) $('#permiso').val(this.value);
                else $('#permiso').val("");
            }

        });
        $(document).ready(function() {
            $('#capitulo').on('change', function() {
                var capitulo = $(this).val();
                if(capitulo) {
                    $.ajax({
                        url: '/Capitulos/'+capitulo,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#tema').empty();
                                $('#tema').focus;
                                $('#detalle').val("");
                                $('#id_cronograma').val("");
                                $('#tema').append('<option value="">--Seleccione Tema--</option>');
                                $.each(data, function(id, value){
                                    $('select[name="tema"]').append('<option value="'+ value.capitulo +'">' + value.tema+ '</option>');
                                    //$('#detalle').val(value.detalle);
                                    $('#id_cronograma').val(value.id_cronograma);
                                });

                            }else{
                                $('#tema').empty();
                                $('#id_cronograma').val("");
                            }
                        }
                    });
                }else{
                    $('#tema').empty();
                    $('#id_cronograma').val("");

                }


            });

            $('#tema').on('change', function() {
                var tema = $(this).val();
                console.log(tema);
                if(tema) {
                    $.ajax({
                        url: '/Tema/'+tema,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#detalle').val("");

                               // $('#detalle').val(data[0]["detalle"]);
                                $.each(data, function(id, value){
                                    $('#detalle').val(value.detalle);
                                });

                            }else{
                                $('#detalle').val("");
                            }
                        }
                    });
                }else{
                    $('#detalle').val("");
                }


            });


        });

    </script>
@endsection