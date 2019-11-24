<?php

namespace App\Http\Controllers\GestionAsistencia;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Docente as docente;
use App\gestionAsistencia\tbl_cronograma as cronograma;
use App\gestionAsistencia\tbl_ficha_asistencia as asistencia;
use Illuminate\Support\Facades\Auth;
use DB;


class GestionAsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:docente');
        //parent::__construct();
    }
    public function index(){
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $date_actual = $now->format('Y-m-d');
       // $cronogramas=cronograma::where('id_docente',$dato)->where('fecha',$date_actual)->get();
        $cronogramas=cronograma::where([
            ['id_docente', $dato],
            ['fecha', $date_actual],
        ])->get();
        $asistencias=DB::connection('SistemaEsfot')->select("SELECT * FROM `tbl_ficha_asistencia`,`tbl_cronograma` WHERE tbl_cronograma.id_cronograma=tbl_ficha_asistencia.id_cronograma and  id_docente=$dato and fecha_registro='$date_actual'");
        return view('gestionasistencia/GestionAsistencia',compact('cronogramas','asistencias'));
    }

    public function dependencia($capitulo)
    {
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $date_actual = $now->format('Y-m-d');
        $capitulos = cronograma::where('capitulo', $capitulo)->where('fecha',$date_actual)->where('id_docente',$dato)->get();
        return response()->json($capitulos);
        //return json_encode($subdepars);
    }

    public function dependenciaTema($tema)
    {
        $dato = Auth::user()->id;
        $now = Carbon::now();
        $date_actual = $now->format('Y-m-d');
        $temas = cronograma::where('capitulo', $tema)->where('fecha',$date_actual)->where('id_docente',$dato)->get();
        return response()->json($temas);
        //return json_encode($subdepars);
    }

    public function store(Request $request){
       // dd($request->all());
        $asistencia = new asistencia();
        $asistencia->id_cronograma = $request->id_cronograma;
        $asistencia->observacion = $request->permiso;
        $asistencia->hora_registro = $request->hora_registro;
        $asistencia->fecha_registro = $request->fecha;
        $asistencia->save();
        return redirect('GestionAsistencia')->with('success', 'Asistencia Registrada Exitosamente!!');

    }
}
