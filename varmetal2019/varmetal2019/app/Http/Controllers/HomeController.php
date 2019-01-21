<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Varmetal\Pausa;

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
        return redirect()->route('/homepage/Trabajador');
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
