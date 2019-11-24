<?php

namespace App\Http\Controllers;

use App\gestionProyector\tbl_ficha_proyector as ficha_proyector;
use App\gestionProyector\tbl_proyector as proyector;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Exception;
use stdClass;
use File;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()

    {
        //$dato = Auth::user()->id_docente;
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $time=$now->toTimeString();

        $date_actual = $now->format('Y-m-d');
        $proyectores=proyector::all();
        //$fichas_proyectores=DB::connection('SistemaEsfot')->select("Select *from tbl_ficha_proyector where id_docente_fk=$dato and fecha='$date_actual';");
        //$fichas_proyectores=ficha_proyector::where('id_docente_fk',$dato)->get();
        $fichas_proyectores=ficha_proyector::where([
            ['id_docente_fk', $dato],
            ['fecha', $date_actual],
        ])->get();
        //$cronogramas=cronograma::where('id_docente',$dato)->where('fecha',$date_actual)->where('hora_fin',$time)->get();
        $cronogramas=DB::connection('SistemaEsfot')->select("Select *from tbl_cronograma where id_docente=$dato and fecha='$date_actual';");
        //dd($cronogramas);
        if (count($cronogramas)>0){
            foreach ($cronogramas as $cronograma){
                $hora_fin=$cronograma->hora_fin;
                //dd($hora_fin);
            }
        }else{
            $hora_fin='';
        }
        return view('home',compact('proyectores','fichas_proyectores','hora_fin'));

    }

    public static function EstadoProyector($estado){
        return ($estado == 1)? 'Entregado' : 'Retirado';
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $now = Carbon::now();
        $time=$now->toTimeString();
        $date_actual = $now->format('Y-m-d');
        $dato = Auth::user()->id;
        $ficha_docentes = new ficha_proyector();
        $ficha_docentes->fecha = $date_actual;
        $hora_entrega1 = strtotime("+15 minutes", strtotime($request->hora_entrega));
        $hora_entrega = date('H:i:s', $hora_entrega1);
        $ficha_docentes->hora_entrega = $hora_entrega;
        $ficha_docentes->hora_retiro = $request->hora_retiro;
        $ficha_docentes->observacion = $request->observacion;
        $ficha_docentes->id_docente_fk = $dato;
        $ficha_docentes->id_proyector_fk = $request->id_proyector;
        $ficha_docentes->estado=0;
        $ficha_docentes->save();

        $proyector=proyector::find($request->id_proyector);
        $proyector->estado=0;
        $proyector->save();

        $val = "0";
        $archive = 'C:\xampp\htdocs\pyphp\pyphp.txt';
        $manager = fopen($archive, "w");
        if(isset($_POST["1"])){
            $val = "1";
            $write = fwrite($manager,$val);
            fclose($manager);


        }
        if(isset($_POST["2"])){
            $val = "2";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["3"])){
            $val = "3";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["4"])){
            $val = "4";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["5"])){
            $val = "5";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["6"])){
            $val = "6";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["7"])){
            $val = "7";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["8"])){
            $val = "8";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["9"])){
            $val = "9";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["10"])){
            $val = "10";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["11"])){
            $val = "11";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["12"])){
            $val = "12";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["13"])){
            $val = "13";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["14"])){
            $val = "14";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["15"])){
            $val = "15";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["16"])){
            $val = "16";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["17"])){
            $val = "17";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["18"])){
            $val = "18";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["19"])){
            $val = "19";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if(isset($_POST["20"])){
            $val = "20";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        //estado();

        return redirect('GestionProyector')->with('success', 'Dispositivo Reservado Exitosamente!!');

    }

    public function update(Request $request)
    {
        //dd($request->all());
        $ficha_proyector = ficha_proyector::find($request->id_ficha_proyector);
        $ficha_proyector->hora_entrega = $request->hora_entrega;
        $ficha_proyector->observacion = $request->observacion;
        $ficha_proyector->estado = 1;
        $ficha_proyector->save();
        $proyector=proyector::find($request->id_proyector);
        $proyector->estado=1;
        $proyector->save();

        $val = "0";
        $archive = 'C:\xampp\htdocs\pyphp\pyphp.txt';
        $manager = fopen($archive, "w");
        if($_POST["id_proyector"]==1){
            $val = "1";
            $write = fwrite($manager,$val);
            fclose($manager);

        }
        if($_POST["id_proyector"]==2){
            $val = "2";
            $write = fwrite($manager,$val);
            fclose($manager);

        }


        return redirect('GestionProyector')->with('success', 'Dispositivo Entregado Exitosamente!!');

    }

    public function estado(){
        $filename = 'C:\xampp\htdocs\pyphp\lectura.txt';
        $contents = File::get($filename);
        $proyectores=str_replace("\r","",$contents);
        $array = explode("\n", $proyectores);
        $estado = substr($array[20], -1);
        $std = new stdClass();
        $std->Estado = $estado;
        $json = json_encode($std);
        return $json;
        //dd(  $json);

        /*if($estado==1){
            $archive = 'C:\xampp\htdocs\pyphp\pyphp.txt';
            $manager = fopen($archive, "w");
            $val = "21";
            $write = fwrite($manager,$val);
            fclose($manager);

        }*/

    }

    public function cambio_estado(){
        $archive = 'C:\xampp\htdocs\pyphp\pyphp.txt';
        $manager = fopen($archive, "w");
        $val = "21";
        $write = fwrite($manager,$val);
        fclose($manager);
        return "ok";
    }


    public function leer(){
        try
        {
            $filename = 'C:\xampp\htdocs\pyphp\lectura.txt';
            $contents = File::get($filename);
            $proyectores=str_replace("\r","",$contents);
            $array = explode("\n", $proyectores);

            $a1 = substr($array[0], -1);
            $b1 = substr($array[1], -1);

            $c1 = substr($array[2], -1);

            $d1 = substr($array[3], -1);

            $e1 = substr($array[4], -1);

            $f1 = substr($array[5], -1);

            $g1 = substr($array[6], -1);

            $h1 = substr($array[7], -1);

            $i1 = substr($array[8], -1);
            $j1 = substr($array[9], -1);
            $k1 = substr($array[10], -1);
            $l1 = substr($array[11], -1);
            $m1 = substr($array[12], -1);
            $n1 = substr($array[13], -1);
            $o1 = substr($array[14], -1);
            $p1 = substr($array[15], -1);
            $q1 = substr($array[16], -1);
            $r1 = substr($array[17], -1);
            $s1 = substr($array[18], -1);
            $t1 = substr($array[19], -1);
            $u1 = substr($array[20], -1);


            //return response()->json($array)
            //$a=json_encode($array,true);
            $std = new stdClass();
            $std->Estado = $a1;
            $std->Proyector1 = $b1;
            $std->Proyector2 = $c1;
            $std->Proyector3 = $d1;
            $std->Proyector4 = $e1;
            $std->Proyector5 = $f1;
            $std->Proyector6 = $g1;
            $std->Proyector7 = $h1;
            $std->Proyector8 = $i1;
            $std->Proyector9 = $j1;
            $std->Proyector10 = $k1;
            $std->Proyector11 = $l1;
            $std->Proyector12 = $m1;
            $std->Proyector13 = $n1;
            $std->Proyector14 = $o1;
            $std->Proyector15 = $p1;
            $std->Proyector16 = $q1;
            $std->Proyector17 = $r1;
            $std->Proyector18 = $s1;
            $std->Proyector19 = $t1;
            $std->Proyector20 = $u1;
            $json = json_encode($std);
            return $json;
            //dd(response()->json($json));
            //dd($json);
        }
        catch (Exception $e)
        {
            echo 'Message: ' . $e->getMessage();
            echo "No existe el archivo";
        }

    }





}
