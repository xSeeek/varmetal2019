<?php

namespace Asistencia\Http\Controllers;

use Illuminate\Http\Request;

use Asistencia\User;
use Asistencia\Http\Requests\InsertObraRequest;
use Asistencia\Http\Requests\InsertTrabajadorRequest;
use Asistencia\Trabajador;
use Asistencia\Obra;

class ObraController extends Controller
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

  public function agregarObra()
  {
    $encargados = User::where('type', User::SUPERVISOR_TYPE)->get();
    return view('obra.agregarObra')->with('encargados', $encargados);
  }

  public function insertObra(InsertObraRequest $request)
  {
    $trabajador = Trabajador::where('rut', $request->encargado)->first();

    if($trabajador->obra == null)
    {
      $obra = new Obra();
      $obra->nombre = $request->name;
      $obra->save();

      $obra->trabajadores()->save($trabajador);
      return redirect()->back()->with('success', 'Obra ' . $obra->nombre . ' registrada con éxito');
    }
    return redirect()->back()
      ->withInput()
      ->with('error', 'El encargado seleccionado ya posee una obra asignada');
  }

  public function detallesObra($id)
  {
    $obra = Obra::find($id);
    $trabajadores = $obra->trabajadores;
    foreach ($trabajadores as $trabajador) {
      if($trabajador->user->isSupervisor()){
        $encargado = $trabajador;
        break;
      }
    }

    $trabajadoresTodos = Trabajador::all();
    return view('obra.detallesObra')
      ->with('obra', $obra)
      ->with('encargado', $encargado)
      ->with('trabajadores', $trabajadoresTodos);

  }

  public function registrarTrabajadores(InsertTrabajadorRequest $request, $idObra)
  {
    $obra = Obra::find($idObra);
    $trabajador = Trabajador::where('rut', $request->trabajador)->first();
    if($trabajador->obra == null)
    {
      if(!$trabajador->user->isSupervisor()){
        $obra->trabajadores()->save($trabajador);
        return redirect()->back()->with('success', 'Trabajador ' . $trabajador->nombre . ' registrado con éxito en la obra');
      }else{
        return redirect()->back()
          ->withInput()
          ->with('error', 'No puede agregar un supervisor como trabajador a una obra');
      }
    }
    return redirect()->back()
      ->withInput()
      ->with('error', 'El trabajador seleccionado ya posee una obra asignada');
  }
}
