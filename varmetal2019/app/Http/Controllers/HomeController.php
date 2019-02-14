<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Varmetal\Pausa;
use Varmetal\Trabajador;
use Varmetal\Ayudante;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if($user->isAdmin() || $user->isSupervisor())
            return redirect()->route('admin');
        if($user->isGerente())
            return redirect()->route('gerencia');

        $usuarioActual = Auth::user();

        if($usuarioActual->trabajador == NULL)
            return redirect()->route('/');

        $datos_trabajador = $usuarioActual->trabajador;
        $ayudantes = $datos_trabajador->ayudante;

        return redirect()->route('/homepage/Trabajador')
              ->with('ayudantes_almacenados',$ayudantes)
              ->with('trabajador',$datos_trabajador);

    }

    public function loop()
    {
      $pausas_registradas = Pausa::all();
      foreach ($pausas_registradas as $key => $pausa) {
        if($pausa->fechaFin==NULL)
        {
          return 1;
        }
      }
      return 2;
    }
}
