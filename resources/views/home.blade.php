@extends('layouts.administrador')

@section('estilo')
    <style>
        .btnElegir[data-estado='0'] {
            background-color:#ff253a ;
            color: white;
            opacity: 0.6 !important; /* Fade effect */
            cursor: not-allowed;
            pointer-events: none;

        }
        .btnElegir[data-activo='0'] {
            background-color: rgba(8, 6, 21, 0.73);
            color: white;
            opacity: 0.6 !important; /* Fade effect */
            cursor: not-allowed;
            pointer-events: none;

        }
        /* .reserva[value=''] {
             opacity: 0.6 !important;
             cursor: not-allowed;
             pointer-events: none;
         }*/

        .estado[data-estado='1'] {
            opacity: 0.6 !important;
            cursor: not-allowed;
            pointer-events: none;


        }

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header" align="center" style="font-size: xx-large"><u>GESTIÓN DE PROYECTORES</u>
                    </div>
                    <div class="card-body" >
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{Session::get('success')}}</div>

                        @endif
                        <div class= "container-fluid">

                            <div  class= "row justify-content-center">
                                <?php $i=1; ?>
                                @foreach($proyectores as $proyector)
                                    <div class="card-group">
                                        <div class="card col-12">
                                            <div id="pro" class="card-body" style="padding-bottom: 15px;padding-top: 15px;" >
                                                <input type="button" id="disponible-{{$i}}" name="{{$i}}" style="width: 129px; height: 38px;" class="btn btn-success btnElegir"  href="#modalReservar-{{$proyector->id_proyector}}" onclick="habiltar(this.name)" data-estado=" " data-activo="{{$proyector->estado}}" data-toggle="modal" value="{{$proyector->proyector}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; ?>

                                @endforeach

                            </div>

                        </div>
                        <input type="hidden" id="Estado_cierre" name="Estado_cierre" value="">
                        <br>
                        <div  class="table-responsive">
                            <table class="table table-bordered " style="margin-top: 10px;">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Dispositivo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora Retiro</th>
                                    <th scope="col">Hora Devolución</th>
                                    <th scope="col">Observación</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fichas_proyectores as $ficha_proyector)
                                    <tr>
                                        <td>{{$ficha_proyector->reserva->proyector}}</td>
                                        <td>{{$ficha_proyector->fecha}}</td>
                                        <td>{{date('h:i:s',strtotime($ficha_proyector->hora_retiro))}}</td>
                                        <td>{{date('h:i:s',strtotime($ficha_proyector->hora_entrega))}}</td>
                                        <td>{{$ficha_proyector->observacion}}</td>
                                        <td>{{\App\Http\Controllers\GestionProyector\GestionProyectorController::EstadoProyector($ficha_proyector->estado)}}</td>
                                        <td><button style="font-size: 20px; color: white" href="#" class="btn btn-info btn-sm estado" data-atraso="{{$ficha_proyector->atraso}}" data-id="{{$ficha_proyector->id_ficha_proyector}}" data-proyector="{{$ficha_proyector->reserva->proyector}}"  data-fecha="{{$ficha_proyector->fecha}}"
                                                    data-horaretiro="{{$ficha_proyector->hora_retiro}}" data-horaentrega="{{$ficha_proyector->hora_entrega}}" data-observacion="{{$ficha_proyector->observacion}}" data-idproyector="{{$ficha_proyector->id_proyector_fk}}"
                                                    data-estado="{{$ficha_proyector->estado}}" data-toggle="modal" data-target="#modalDevolver" value="{{$ficha_proyector->estado}}">Devolver</button>
                                        </td>
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

                <?php $i=1; ?>
                @foreach($proyectores as $proyector)
                    <div class="modal fade" tabindex="-1" role="dialog" id="modalReservar-{{$proyector->id_proyector}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Reservar</h4>
                                </div>
                                <form  method="POST"  action="/ReservarProyector" >
                                    {{csrf_field()}}
                                    <div class="modal-body" >
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" id="re">Dispositivo:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="proyector" name="proyector"  value="{{$proyector->proyector}}" readonly/>
                                                <input type="hidden" class="form-control" id="id_proyector" name="id_proyector"  value="{{$proyector->id_proyector}}" readonly/>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label   class="col-sm-3 col-form-label"  id="rec">Fecha:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" readonly/>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <div class="form-group " style="width: 230px;">
                                                <label  class=" control-label" id="rec">Hora Retiro:</label>
                                                <input type="time" class="form-control" id="hora_retiro" name="hora_retiro" value="{{ date('H:i:s') }}" readonly />
                                            </div>

                                            <div  class="form-group " style="width: 230px;">
                                                <label  class=" control-label" >Hora Entrega:</label>

                                                <input type="time" class="form-control" id="hora_entrega{{$i}}" name="hora_entrega" value="{{$hora_fin}}" />

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label  class=" control-label" >Observación:</label>
                                            <textarea type="text" class="form-control" id="observacion" name="observacion" readonly >{{ $proyector->descripcion}}</textarea>
                                        </div>
                                        <div class="form-group habilitar" id="fuerahorario-{{$i}}">
                                            <center> <label style="color: #ff253a" >Fuera del horario regular de clases para reservar (Habilitar)!!</label></center>
                                            <div class="form-group form-check" align="center">
                                                <input type="checkbox" id="{{$i}}" class="form-check-input" onChange="comprobar(this);">
                                                <label class="form-check-label" for="exampleCheck1">Habilitar</label>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" id="reservar-{{$i}}"  class="btn btn-primary reserva" name="{{$i}}" onclick="myFunction(this.name);" >Reservar</button>

                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>

                <?php $i++; ?>
            @endforeach
            <!----------------------------------------------------------------------------------------------------------------------------------->
                <div class="modal fade" tabindex="-1" role="dialog" id="modalDevolver">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Devolver</h4>
                            </div>
                            <form  method="POST"  action="/DevolverProyector" >
                                {{csrf_field()}}
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="id_ficha_proyector" name="id_ficha_proyector"  value="" />

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" id="re">Dispositivo:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="proyector" name="proyector"  value="" readonly/>
                                            <input type="hidden" class="form-control" id="id_proyector" name="id_proyector"  value="" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label   class="col-sm-3 col-form-label"  id="rec">Fecha:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="fecha" name="fecha" value="" readonly/>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-group " style="width: 230px;">
                                            <label  class=" control-label" id="rec">Hora Retiro:</label>
                                            <input type="time" class="form-control" id="hora_retiro" name="hora_retiro" value="" readonly />
                                        </div>

                                        <div  class="form-group " style="width: 230px;">
                                            <label  class=" control-label" id="rec">Hora Entrega:</label>
                                            <input type="time" class="form-control" id="hora_entrega" name="hora_entrega" value="{{ date('H:i:s') }}" readonly  />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class=" control-label" id="rec">Observación:</label>
                                        <textarea type="text" class="form-control" id="observacion" name="observacion"></textarea>
                                    </div>
                                    <input type="hidden" id="atraso">
                                    <div class="alert alert-danger" role="alert" id="cont3"  align="center"></div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Devolver</button>

                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
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


        function myFunction(id) {
            var id_proyector=id;

            //console.log(id_proyector);
            if (confirm("Esta seguro de la reserva!!")) {
                $("#disponible-"+id_proyector).toggleClass("btn-success btn-danger");
                // document.getElementById("disponible"+id_proyector).disabled = true;

            }else{
                event.preventDefault();
            }
        }


        function comprobar(obj)
        {
            var id=$(obj).attr('id');
            console.log(id);
            console.log(obj);
            if (obj.checked){

                document.getElementById('hora_entrega'+id).readOnly = false;
                document.getElementById('reservar-'+id).disabled = false;

            } else{

                document.getElementById('hora_entrega'+id).readOnly = true;
                document.getElementById('reservar-'+id).disabled = true;
                document.getElementById('hora_entrega'+id).value='';
            }
        }
        function habiltar(id) {
            var id_proyector=id;
            // console.log(id_proyector);
            var value = document.getElementById("hora_entrega"+id_proyector).value;
            console.log(value);
            document.getElementById('hora_entrega'+id_proyector).readOnly = true;
            if(value==''){
                document.getElementById('fuerahorario-'+id_proyector).style.display = 'block';
                document.getElementById('reservar-'+id_proyector).disabled = true;


            }else{
                document.getElementById('fuerahorario-'+id_proyector).style.display = 'none';
                document.getElementById('reservar-'+id_proyector).readOnly = false;
            }

        }

        function ca_estados(){
            $.ajax({
                url: '/cambio_admin/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    //console.log(data);

                }
            });


        }

        function estados(){
            $.ajax({
                url: '/leer_admin/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    console.log("si");
                    var a=data['Proyector1'];
                    var b=data['Proyector2'];
                    var c=data['Proyector3'];
                    var d=data['Proyector4'];
                    var e=data['Proyector5'];
                    var f=data['Proyector6'];
                    var g=data['Proyector7'];
                    var h=data['Proyector8'];
                    var i=data['Proyector9'];
                    var j=data['Proyector10'];
                    var k=data['Proyector11'];
                    var l=data['Proyector12'];
                    var m=data['Proyector13'];
                    var n=data['Proyector14'];
                    var o=data['Proyector15'];
                    var p=data['Proyector16'];
                    var q=data['Proyector17'];
                    var r=data['Proyector18'];
                    var s=data['Proyector19'];
                    var t=data['Proyector20'];
                    $("#disponible-1").attr('data-estado',a);
                    $("#disponible-2").attr('data-estado',b);
                    $("#disponible-3").attr('data-estado',c);
                    $("#disponible-4").attr('data-estado',d);
                    $("#disponible-5").attr('data-estado',e);
                    $("#disponible-6").attr('data-estado',f);
                    $("#disponible-7").attr('data-estado',g);
                    $("#disponible-8").attr('data-estado',h);
                    $("#disponible-9").attr('data-estado',i);
                    $("#disponible-10").attr('data-estado',j);
                    $("#disponible-11").attr('data-estado',k);
                    $("#disponible-12").attr('data-estado',l);

                    // $("#proyector-1").val(data['Proyector1']);

                    $("#Estado_cierre").val(data['Estado']);
                    if( data['Estado']==1){
                        ca_estados()
                        //alert("Cierre la puerta");
                        swal({
                            title: "Recoja el Proyector",
                            text: "No olvide cerrar la puerta y sesión!",
                            icon: "warning",
                            dangerMode: true,
                            closeOnClickOutside: false,
                            buttons: false,
                        })

                    }

                    cambio_cero();
                }



            });


        }

        function cambio_cero() {
            var x= document.getElementById("Estado_cierre").value;
            console.log(x);
            if(x==0 || x==''){
                ca_estados();
                swal.close();





            }

        }

        var myVar = setInterval(estados, 2000);
        function myStopFunction() {
            clearInterval(myVar);
        }
        $(document).ready(function(){



            $('#modalDevolver').on('shown.bs.modal', function (event) {
                console.log('modal abierto');
                var button=$(event.relatedTarget);
                var id= button.data('id');
                var proyector=button.data('proyector');
                var fecha=button.data('fecha');
                var hora_retiro=button.data('horaretiro');
                var id_proyector=button.data('idproyector');
                var atraso=button.data('atraso');
                var modal=$(this);
                modal.find('.modal-body #id_ficha_proyector').val(id);
                modal.find('.modal-body #proyector').val(proyector);
                modal.find('.modal-body #fecha').val(fecha);
                modal.find('.modal-body #hora_retiro').val(hora_retiro);
                modal.find('.modal-body #id_proyector').val(id_proyector);
                modal.find('.modal-body #atraso').val(atraso);
                var valor = document.getElementById('atraso').value;
                console.log(valor);
                if(valor==""){
                    document.getElementById('cont3').style.display = 'none';

                }else{
                    document.getElementById('cont3').innerHTML=' '+valor+'!!';

                }
            });
            ;

            $.ajax({
                url: '/leer_admin/',
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data) {
                    console.log(data["Proyector1"]);
                    var a=data['Proyector1'];
                    var b=data['Proyector2'];
                    var c=data['Proyector3'];
                    var d=data['Proyector4'];
                    var e=data['Proyector5'];
                    var f=data['Proyector6'];
                    var g=data['Proyector7'];
                    var h=data['Proyector8'];
                    var i=data['Proyector9'];
                    var j=data['Proyector10'];
                    var k=data['Proyector11'];
                    var l=data['Proyector12'];
                    var m=data['Proyector13'];
                    var n=data['Proyector14'];
                    var o=data['Proyector15'];
                    var p=data['Proyector16'];
                    var q=data['Proyector17'];
                    var r=data['Proyector18'];
                    var s=data['Proyector19'];
                    var t=data['Proyector20'];
                    $("#disponible-1").attr('data-estado',a);
                    $("#disponible-2").attr('data-estado',b);
                    $("#disponible-3").attr('data-estado',c);
                    $("#disponible-4").attr('data-estado',d);
                    $("#disponible-5").attr('data-estado',e);
                    $("#disponible-6").attr('data-estado',f);
                    $("#disponible-7").attr('data-estado',g);
                    $("#disponible-8").attr('data-estado',h);
                    $("#disponible-9").attr('data-estado',i);
                    $("#disponible-10").attr('data-estado',j);
                    $("#disponible-11").attr('data-estado',k);
                    $("#disponible-12").attr('data-estado',l);

                }
            });
        });



        var buttons = document.querySelectorAll('.estado');

        buttons.forEach(function(button) {
            //  console.log(button);
            if (button.value==0) {
                var elegir = document.querySelectorAll('.btnElegir');
                elegir.forEach(function(buttone) {

                    buttone.disabled=true;

                });

            }
        });



    </script>
@endsection

