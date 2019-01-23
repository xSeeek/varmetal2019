<?php

namespace Asistencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

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
      if(Auth::user()->isAdmin())
        return redirect()->route('administrador.menuAdministrador');
      return view('home');
    }


}
