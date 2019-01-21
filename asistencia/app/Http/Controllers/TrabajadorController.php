<?php

namespace Asistencia\Http\Controllers;

use Illuminate\Http\Request;

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
}
