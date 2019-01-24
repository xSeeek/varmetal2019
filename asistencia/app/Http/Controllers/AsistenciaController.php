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
use Image;

class AsistenciaController extends Controller
{


  public function verAsistencia($rut)
  {
    $trabajador = Trabajador::where('rut', $rut)->first();
    return view('asistencia.verAsistenciaTrabajador')->with('trabajador', $trabajador);
  }

  public function menuAdministrador()
  {
    return view('administrador.menuAdministrador')
      ->with('obras', Obra::all())
      ->with('trabajadores', Trabajador::all());
  }

  public function menuSupervisor()
  {
    $user = Auth::user();
    return view('supervisor.menuSupervisor')
      ->with('obra', $user->trabajador->obra);
  }

  public function registrarAsistencia(Request $request)
  {
    if($request->hasFile('file'))
    {
      $trabajador = Trabajador::where('rut', $request->rut)->first();
      if($trabajador->obra != null)
      {
        $asistencias = Asistencia::where('trabajador_id_trabajador', $trabajador->idTrabajador)
        ->whereDate('created_at', Carbon::today())->where('tipo', $request->tipo)->get();
        if(count($asistencias) > 0)
        {
          return redirect()->back()
            ->withInput()
            ->with('error', 'El trabajador ya tiene una asistencia marcada hoy');
        }
        $asistencia = new Asistencia();
        $asistencia->tipo = $request->tipo;

        $dt = Carbon::now();

        $file = $request->file('file');

        $file_name = $dt->format('d-m-Y') . '-' . $request->tipo . '.' . $file->getClientOriginalExtension();

        Storage::disk('asistencia')->put($request->rut.'/'. $file_name, File::get($file));

        $asistencia->image = $file_name;
        $trabajador->asistencias()->save($asistencia);

        return redirect()->route('home')->with('success', 'Asistencia a ' . $trabajador->nombre . ' registrada con éxito');
      }
      return redirect()->back()
        ->withInput()
        ->with('error', 'El trabajador ingresado no posee una obra asignada');
    }else {
      return 'esta malloc';
    }
  }

  public function detallesAsistencia($rut, $id)
  {
    $trabajador = Trabajador::where('rut', $rut)->first();
    $asistencia = Asistencia::find($id);
    return view('asistencia.detallesAsistencia')
      ->with('trabajador', $trabajador)
      ->with('asistencia', $asistencia);
  }

}
