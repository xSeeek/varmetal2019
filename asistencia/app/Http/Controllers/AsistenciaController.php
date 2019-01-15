<?php

namespace Asistencia\Http\Controllers;

use Freshwork\ChileanBundle\Rut;

use Asistencia\Obra;
use Asistencia\Asistencia;
use Asistencia\Trabajador;
use Illuminate\Http\Request;
use Asistencia\Http\Requests\MarcarAsistencia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AsistenciaController extends Controller
{


  public function verAsistencia($rut)
  {
    $trabajador = Trabajador::where('rut', $rut)->first();
    return view('asistencia.verAsistenciaTrabajador')->with('trabajador', $trabajador);
  }

  public function menuAdministrador()
  {
    return view('administrador.menuAdministrador')->with('obras', Obra::all());
  }

  public function registrarAsistencia(MarcarAsistencia $request)
  {
    if($request->hasFile('file'))
      {
        $file = $request->file('file');

        $trabajador = Trabajador::where('rut', $request->rut)->first();

        $asistencia = new Asistencia();

        $dt = Carbon::now();

        $file_name = $dt->format('d-m-Y') . '.' . $file->getClientOriginalExtension();
        Storage::disk('asistencia')->put($request->rut.'/'. $file_name, File::get($file));

        $asistencia->image = $file_name;
        $trabajador->asistencias()->save($asistencia);

        return redirect()->route('home')->with('success', 'Asistencia a ' . $trabajador->nombre . ' registrada con éxito');
      }
  }
}
