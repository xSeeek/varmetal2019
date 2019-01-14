<?php

namespace Asistencia\Http\Controllers;

use Freshwork\ChileanBundle\Rut;

use Asistencia\Obra;
use Asistencia\Asistencia;
use Asistencia\Trabajador;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

  }

  public function verAsistencia($rut)
  {
    $trabajador = Trabajador::where('rut', $rut)->first();
    return view('asistencia.verAsistenciaTrabajador')->with('trabajador', $trabajador);
  }

  public function menuAdministrador()
  {
    return view('administrador.menuAdministrador')->with('obras', Obra::all());
  }
}
