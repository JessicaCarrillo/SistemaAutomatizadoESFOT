<?php

namespace App\Imports;

use App\gestionAsistencia\tbl_cronograma;
use App\gestionAsistencia\tbl_cronograma as cronograma;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CsvImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       // dd($row);
        $cronogramas = $_POST["id_docente"];
        $periodos=$_POST["id_periodo"];
        return new tbl_cronograma([
            'fecha' =>  $row['fecha'],
            'hora_inicio' =>  $row['hora_inicio'],
            'hora_fin' =>  $row['hora_fin'],
            'capitulo' =>  $row['capitulo'],
            'subcapitulo' =>  $row['subcapitulo'],
            'tema' =>  $row['tema'],
            'detalle' =>  $row['detalle'],
            'id_docente' =>  $cronogramas,
            'id_periodo' => $periodos,
        //
        ]);
    }
}
