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

  public function registrarAsistencia(MarcarAsistencia $request)
  {
    /*
    $size = $request->image->getClientSize();
    $file_size = number_format($size / 1048576,2);

    print_r($file_size);
    */
    $rut = Rut::parse($request->rut)->format();
    $rut_supervisor = Rut::parse($request->supervisor)->format();

    $supervisor = Trabajador::where('rut', $rut_supervisor)->first();

    if($supervisor->obra == null){
      return redirect()->back()
        ->withInput()
        ->with('error', 'El supervisor no esta vinculado a ninguna obra');
    }

    $trabajador = Trabajador::where('rut', $rut)->first();

    if($trabajador->obra != null){
      if($trabajador->obra != $supervisor->obra){
        return redirect()->back()
          ->withInput()
          ->with('error', 'El trabajador seleccionado no pertenece a esta obra');
      }
    }else {
      return redirect()->back()
        ->withInput()
        ->with('error', 'El trabajador ingresado no posee una obra asignada');
    }

    /*if($request->tipo == Asistencia::SALIDA_TYPE){
      $asistencias = Asistencia::where('trabajador_id_trabajador', $trabajador->idTrabajador)
      ->whereDate('created_at', Carbon::today())->where('tipo', Asistencia::ENTRADA_TYPE)->get();
      if(count($asistencias) == 0)
      {
        return redirect()->back()
          ->withInput()
          ->with('error', 'El trabajador no cuenta con asistencia de entrada hoy');
      }
    }*/

    if($request->hasFile('image'))
    {
      $asistencias = Asistencia::where('trabajador_id_trabajador', $trabajador->idTrabajador)
      ->whereDate('created_at', Carbon::today())->where('tipo', $request->tipo)->get();
      if(count($asistencias) > 0)
      {
        return redirect()->back()
          ->withInput()
          ->with('error', 'El trabajador ya tiene una asistencia de '. $request->tipo .' marcada hoy');
      }
      $asistencia = new Asistencia();
      $asistencia->tipo = $request->tipo;

      $dt = Carbon::now();

      $file = $request->file('image');

      $file_name = $dt->format('d-m-Y') . '-' . $request->tipo . '.' . $file->getClientOriginalExtension();

      $img = Image::make($file)->orientate()
      ->resize(600, null, function ($constraint) { $constraint->aspectRatio(); } )
      ->encode('jpg',85);

      Storage::disk('asistencia')->put($rut.'/'. $file_name, $img);

      $asistencia->image = $file_name;
      $trabajador->asistencias()->save($asistencia);

      return redirect()->route('home')->with('success', 'Asistencia a ' . $trabajador->nombre . ' registrada con éxito');

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

  public function obtenerAsistencia(Request $request)
  {
    if(($request->rut == null) || ($request->tipo == null) || ($request->fecha_inicio == null) || ($request->fecha_fin == null))
      {return -4;}

    if(!Rut::parse($request->rut)->validate())
      {return -1;}

    $rut = Rut::parse($request->rut)->format();

    $trabajador = Trabajador::where('rut', $rut)->first();

    if($trabajador == null)
      {return -2;}

    $fecha_inicio = new Carbon($request->fecha_inicio);
    $fecha_fin = new Carbon($request->fecha_fin);

    $fecha_inicio->startOfDay();
    $fecha_fin->endOfDay();

    if($fecha_inicio > $fecha_fin)
      {return -5;}



    return $asistencias;
  }

}
