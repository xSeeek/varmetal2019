<?php

namespace Asistencia\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Asistencia\Http\Requests\InsertTrabajadorRequest;
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
