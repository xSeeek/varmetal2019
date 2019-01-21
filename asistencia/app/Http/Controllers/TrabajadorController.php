<?php

namespace Asistencia\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Asistencia\Http\Requests\InsertTrabajadorRequest;
use Asistencia\Http\Requests\EditarTrabajadorRequest;
use Asistencia\User;
use Asistencia\Trabajador;

class TrabajadorController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function agregarTrabajadores()
  {
    return view('trabajador.agregarTrabajadores');
  }

  public function detallesTrabajador($rut)
  {
    return view('trabajador.detallesTrabajador')
      ->with('trabajador', Trabajador::where('rut', $rut)->first());
  }

  public function editar(EditarTrabajadorRequest $request)
  {
    $trabajador = Trabajador::where('rut', $request->$request->rut)->first();
    $trabajador->nombre = $request->nombre_completo;
    $trabajador->rut = $request->rut;
    $trabajador->cargo = $request->cargo;

    if(count($trabajador->getDirty()))
    {
      $trabajador->update();

      return redirect()
      ->back()
      ->with('success', 'Trabajador editado con éxito');
    }
    return redirect()->back()
      ->withInput()
      ->with('error', 'No se registran cambios');
  }

  public function insert(InsertTrabajadorRequest $request)
  {
    $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user->type = $request->type;
    $user->save();

    $trabajador = new Trabajador();
    $trabajador->nombre = $request->nombre_completo;
    $trabajador->rut = $request->rut;
    $trabajador->cargo = $request->cargo;
    $trabajador->estado = true;

    $user->trabajador()->save($trabajador);

    return redirect()->route('administrador.agregarTrabajadores')->with('success', '' . $trabajador->nombre . ' registrada con éxito');
  }
}
