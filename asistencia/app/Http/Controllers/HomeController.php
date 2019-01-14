<?php

namespace Asistencia\Http\Controllers;

use Illuminate\Http\Request;
use Asistencia\Http\Requests\MarcarAsistencia;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

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
}
