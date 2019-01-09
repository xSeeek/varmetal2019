<?php

namespace Asistencia\Http\Controllers;
use Freshwork\ChileanBundle\Rut;
use Asistencia\Trabajador;
use Illuminate\Http\Request;
use Asistencia\Http\Requests\MarcarAsistencia;

class AsistenciaController extends Controller
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

  public function registrarAsistencia(MarcarAsistencia $request)
  {

  }
}
