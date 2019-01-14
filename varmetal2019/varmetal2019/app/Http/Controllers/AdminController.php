<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Obra;
use Varmetal\Pausa;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function admin()
    {
        $pausas = Pausa::get();
        $obras = Obra::get();
        return view('admin')
                ->with('obras',$obras)
                ->with('pausas',$pausas);
    }
}
