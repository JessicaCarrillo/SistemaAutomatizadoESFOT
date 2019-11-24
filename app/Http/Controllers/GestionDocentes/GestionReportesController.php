<?php

namespace App\Http\Controllers\GestionDocentes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\gestionAsistencia\tbl_ficha_asistencia as asistencia;
use App\Docente as docentes;
use DB;

class GestionReportesController extends Controller
{
    public function asistencia(Request $request){
        if(request()->ajax())
        {
            if(!empty($request->from_date))
            {
                $data =DB::connection('SistemaEsfot')->select("SELECT id_asistencia, fecha_registro,hora_registro,name, hora_inicio,hora_fin, tema ,tbl_ficha_asistencia.observacion from `tbl_ficha_asistencia` ,`tbl_cronograma`,`users` WHERE tbl_cronograma.id_cronograma=tbl_ficha_asistencia.id_cronograma and users.id= tbl_cronograma.id_docente and fecha_registro BETWEEN CAST('$request->from_date' AS DATE) AND CAST('$request->to_date' AS DATE);");

            }
            else
            {
                $data = DB::connection('SistemaEsfot')->select("SELECT id_asistencia, fecha_registro,hora_registro,name, hora_inicio,hora_fin, tema, tbl_ficha_asistencia.observacion  from `tbl_ficha_asistencia` ,`tbl_cronograma`,`users` WHERE tbl_cronograma.id_cronograma=tbl_ficha_asistencia.id_cronograma and users.id= tbl_cronograma.id_docente;");

            }

            return datatables()->of($data)->make(true);
        }
        return view('Reportes.ReporteAsistencia');
    }


    public function proyectores(Request $request){
        if(request()->ajax())
        {
            if(!empty($request->from_date))
            {
                $data =DB::connection('SistemaEsfot')->select("SELECT id_ficha_proyector,fecha,name,proyector,hora_retiro, hora_entrega,observacion FROM tbl_ficha_proyector,users,tbl_proyector WHERE id_proyector_fk=id_proyector and tbl_ficha_proyector.id_docente_fk=users.id and fecha BETWEEN CAST('$request->from_date' AS DATE) AND CAST('$request->to_date' AS DATE);");

            }
            else
            {
                $data = DB::connection('SistemaEsfot')->select("SELECT id_ficha_proyector,fecha,name,proyector,hora_retiro, hora_entrega,observacion FROM tbl_ficha_proyector,users,tbl_proyector WHERE id_proyector_fk=id_proyector and tbl_ficha_proyector.id_docente_fk=users.id;");

            }

            return datatables()->of($data)->make(true);
        }
        return view('Reportes.ReporteProyector');

    }
}
