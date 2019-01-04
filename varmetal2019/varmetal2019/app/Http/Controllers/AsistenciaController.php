<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function home()
  {
    return view('asistencia.asistencia_home');
  }
}
