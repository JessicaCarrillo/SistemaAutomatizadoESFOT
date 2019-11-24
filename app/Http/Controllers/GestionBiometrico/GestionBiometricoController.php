<?php

namespace App\Http\Controllers\GestionBiometrico;

use App\Mail\MessageReceived;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use stdClass;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\gestionProyector\tbl_ficha_proyector as proyector;
use League\Flysystem\Exception;
use App\Docente as docente;
use File;
use DB;
use App\User as usuario;


class GestionBiometricoController extends Controller
{
    public function obtener_registro_biometrico()
    {
        try {

            //$process2 = new Process('C:/Python/Python36/python.exe /C:/xampp/htdocs/SistemaAutomatizadoESFOT/SistemaAutomatizadoESFOT/public/pyscripts/py_get_regs.py 2>&1');
            //$process2->run();
            //$y = $process2-> getOutput();
            $process = shell_exec('C:\Python\Python36\python.exe C:\xampp\htdocs\SistemaAutomatizadoESFOT\SistemaAutomatizadoESFOT\public\pyscripts\py_get_regs.py 2>&1');
            $registros_biometricos = json_decode($process);
            //dd($registros_biometricos);
           /* foreach ($registros_biometricos as $registro){

                    $id_biometrico=$registro->badgenumber;
                    $uid= $registro->uid;
                    $checktime= $registro->checktime;
                    $status= $registro->status;
                    $checktype= $registro->checktype;
                    $sensorid= $registro->sensorid;

            }*/
           /* $id=end($registros_biometricos);
            $bio=$id->badgenumber;
            $docente=docente::where('id_biometrico',$bio)->first();
            dd($docente->id_docente);*/
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function obtener_usuarios()
    {

        try {
            $hello = 'world';

            $process2 = shell_exec('C:\Python\Python36\python.exe C:\xampp\htdocs\SistemaAutomatizadoESFOT\SistemaAutomatizadoESFOT\public\pyscripts\usuarios.py 2>&1' .$hello);
            $registros_biometricos = json_decode($process2);
            // dd($registros_biometricos);

        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function obtener_usuarios_biometrico()
    {
        try {

            $process2 = shell_exec('C:\Python\Python36\python.exe C:\xampp\htdocs\SistemaAutomatizadoESFOT\SistemaAutomatizadoESFOT\public\pyscripts\py_get_users.py 2>&1');
            $registros_biometricos = json_decode($process2);
            if($registros_biometricos!= null){
                foreach ($registros_biometricos as $registro_biometrico) {
                    $name=$registro_biometrico->name;
                    $privilege=$registro_biometrico->privilege;
                    $password=$registro_biometrico->password;
                    $group_id=$registro_biometrico->group_id;
                    $badgenumber=$registro_biometrico->id_biometrico;
                    $ip=$registro_biometrico->ip;

                    $z=usuario::where('id_biometrico',$badgenumber)->count();
                    if($z==0){
                        $usuarios=new usuario();
                        $usuarios->id_biometrico=$badgenumber;
                        $usuarios->name=$name;
                        $usuarios->tipo_rol=2;
                        $usuarios->estado=1;
                        $usuarios->save();
                        return redirect('GestionDocentes')->with('success', 'Docente Añadido Exitosamente!!');

                    }else{
                        return redirect('GestionDocentes')->with('success', 'No hay docentes que agregar!!');

                    }

                }
            }else{
                return redirect('GestionDocentes')->with('success', 'Biométrico Desconectado!!');
            }

        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function leer_login()
    {
        try {
            $filename = 'C:\xampp\htdocs\pyphp\login.txt';
            $contents = File::get($filename);
            //dd($contents);
            if($contents==0){
                $std = new stdClass();
                $std->id_biometrico = $contents;
                $json = json_encode($std);
                return $json;

            }else{
            $docente=usuario::where('id_biometrico',$contents)->first();
            if($docente!=null){
                $id_docente=$docente->id_docente;

                $std = new stdClass();
                $std->id_biometrico = $id_docente;
                $json = json_encode($std);
                return $json;

            }else{
                $std = new stdClass();
                $std->id_biometrico ="";
                $json = json_encode($std);
                return $json;

            }

            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            echo "No existe el archivo";
        }
    }

    public function cambio(){
        $archive = 'C:\xampp\htdocs\pyphp\login.txt';
        $manager = fopen($archive, "w");
        $val = "0";
        $write = fwrite($manager,$val);
        fclose($manager);
        return "ok";
    }

    public function mensaje(){
        $now = Carbon::now();
        $date_actual = $now->format('Y-m-d');
        $hora=$now->toTimeString();
        //$hora='22:10';
        $mensajes=DB::connection('SistemaEsfot')->select("SELECT id_ficha_proyector,fecha,hora_entrega,name,email FROM tbl_ficha_proyector, users WHERE id_docente_fk=id and 
            fecha='$date_actual';");
        if(count($mensajes)>0){
            foreach ($mensajes as $mensaje){
                $id=$mensaje->id_ficha_proyector;
                $hora_entrega=$mensaje->hora_entrega;
                $email=$mensaje->email;
                if ($hora > $hora_entrega) {
                    //Mail::to($email)->queue(new MessageReceived);
                    $proyectores=proyector::find($id);
                    $proyectores->atraso = "Atraso";
                    $proyectores->save();

                    return "ok";

                }else{
                    return "no";
                }

            }


        }



    }
}
