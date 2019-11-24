<?php

namespace App\Http\Controllers\GestionDocentes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\gestionProyector\tbl_proyector as proyector;
use DB;
class GestionProyecController extends Controller
{
    public function index(){
        //$proyectores=proyector::where('estado',1)->get();
        $proyectores=proyector::all();
        $numero_proyectores=proyector::count();

        return view('gestionproyectores.listaProyectores',compact('proyectores','numero_proyectores'));

    }
    public function create(){
        return view('gestionproyectores.NuevoProyector');

    }
    public function store(Request $request){
        $proyectores = new proyector();
        $proyectores->proyector = $request->proyector;
        $proyectores->descripcion = $request->descripcion;
        $proyectores->estado = 1;
        $proyectores->save();
        return redirect('Proyectores')->with('success', 'Proyector Añadido Exitosamente!!');

    }
    public  function edit($id){
        $proyectores = proyector::find($id);
        return view('gestionproyectores.EditarProyector',compact('proyectores'));

    }

    public function update(Request  $request, $id){
        $proyectores = proyector::find($id);
        $proyectores->proyector = $request->proyector;
        $proyectores->descripcion = $request->descripcion;
        $proyectores->save();
        return redirect('Proyectores')->with('success', 'Proyector Editado Exitosamente!!');

    }

    public function eliminar($id){
        $proyectores = proyector::find($id);
        $proyectores->estado='0';
        $proyectores->save();
        return redirect('Proyectores')->with('success', 'Proyector Removido Exitosamente!!');
    }

    public function destroy($id){
        $proyectores = proyector::find($id);
        $proyectores->delete();
        return redirect('Proyectores')->with('success', 'Proyector Removido Exitosamente!!');
    }

    public function cambioestado(Request $request)
    {
        $proyectores = proyector::find($request->id_proyector);
        $proyectores->estado = $request->estado;
        $proyectores->save();

        return response()->json(['message'=>'Estado de proyector cambiado exitosamente!!']);
    }
}
