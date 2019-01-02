<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trabajador;

class TrabajadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminTrabajadores()
    {
        $trabajadores_registrados = Trabajador::get();
        return view('admin.administracion_trabajadores')->with('trabajadores_almacenados', $trabajadores_registrados);
    }

    public function trabajadorControl($data)
    {
        if($data == 'undefined')
            return redirect()->route('adminTrabajador');

        $datos_trabajador = Trabajador::find($data)->first();
        $userTrabajador = $datos_trabajador->user;
        $productos = $datos_trabajador->producto;

        return view('admin.trabajador.trabajador_control')
                                ->with('trabajador', $datos_trabajador)
                                ->with('usuario_trabajador', $userTrabajador)
                                ->with('productos_trabajador', $productos);
    }

    public function addTrabajador()
    {
        return view('admin.trabajador.addTrabajador');
    }
}
