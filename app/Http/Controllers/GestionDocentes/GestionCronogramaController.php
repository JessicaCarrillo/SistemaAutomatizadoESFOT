<?php

namespace App\Http\Controllers\GestionDocentes;

use App\gestionPeriodo\tbl_periodo as periodo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\CsvImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\gestionAsistencia\tbl_cronograma as cronograma;
use App\Http\Requests\ValidacionSubirCronograma as RequestSubir;
//use App\Docente as docente;
use App\User as docente;

class GestionCronogramaController extends Controller
{

    public function index($id){
        $cronogramas=cronograma::where('id_docente',$id)->get();
        $docentes=docente::find($id);
        $periodos=periodo::where('estado', 1)->get();
       // dd($cronogramas);
        return view('gestioncronogramas.gestionCronograma',compact('cronogramas','docentes','periodos'));
    }
    public function subir($id){
        $cronogramas=cronograma::where('id_docente',$id)->get();
        $docentes=docente::find($id);
        $periodos=periodo::where('estado', 1)->get();
        // dd($cronogramas);
        return view('gestioncronogramas.gestionSubir',compact('cronogramas','docentes','periodos'));

    }

    public function csv_import(RequestSubir $request){
        //dd($request->all());
        $file = $request->file('file');
        //Excel::import(new CsvImport, request()->file('file'));
        Excel::import(new CsvImport, $file);

        return back()->with('success', 'Importación realizada con éxito!!');

    }

    public function eliminar_masivo(){

        $a =$_POST["id_cronograma"];
        $array1 = explode(',', $a[0]);
        if(count($array1)>0){
            foreach ($array1 as $dato ) {
                $cronogramas = cronograma::find($dato);
                $cronogramas->delete();
            }
        }
         return back()->with('success', 'Temas Removidos Exitosamente!!');
    }

    public function buscar($id_periodo,$id_do){
        $id =$id_do;
        // $cronogramas = cronograma::where('id_periodo',$id_periodo)->get();
        $cronogramas = DB::connection('SistemaEsfot')->select("SELECT * FROM `tbl_cronograma` WHERE id_periodo=$id_periodo and id_docente=$id");
        return response()->json($cronogramas);
        /*if(isset($cronogramas)){
            return response()->json($cronogramas);
        }else{
            return 'No se encontraron resultados' ;
        }*/
    }




}
