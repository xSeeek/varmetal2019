<?php

namespace Asistencia\Http\Controllers;

use Freshwork\ChileanBundle\Rut;

use Asistencia\Trabajador;
use Asistencia\Asistencia;
use Illuminate\Http\Request;
use Asistencia\Http\Requests\MarcarAsistencia;
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

  /**
   * [registrarAsistencia registra una asistencia para un trabajador]
   * @param  MarcarAsistencia $request [Form que hace validaciones del request]
   * @return [type]                    [Retorna una redirección hacia la misma ruta
   *                                   con un mensaje de éxito.]
   */
  public function registrarAsistencia(MarcarAsistencia $request)
  {
    if($request->hasFile('file'))
    {
      $file = $request->file('file');
      $t = Trabajador::where('rut', $request->rut)->first();

      $a = new Asistencia();
      $a->trabajador_id_trabajador = $t->idTrabajador;

      $dt = Carbon::now();

      $file_name = $dt->format('d-m-Y') . '.' . $file->getClientOriginalExtension();

      Storage::disk('asistencia')->put($request->rut.'/'. $file_name, File::get($file));

      $a->image = $file_name;
      $a->save();

      return redirect()->route('home')->with('success', 'Asistencia a ' . $t->nombre . ' registrada con éxito');
    }
  }



  public function menuAdministrador()
  {
    return view('administrador.menuAdministrador')->with('trabajador', Auth::user()->trabajador);
  }
}
