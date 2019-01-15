<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Obra;
use Carbon\Carbon;

class ObraController extends Controller
{
    public function adminObra()
    {
        $obras = Obra::get();

        return view('admin.administracion_obras')
                ->with('obras', $obras);
    }

    public function addObra()
    {
        return view('admin.obra.addObra');
    }

    public function insertObra(Request $request)
    {
        if($request->nameListado == NULL)
            return 'Tiene que ingresar un nombre para el listado';

        if($request->nameProyecto == NULL)
            return 'Tiene que ingresar un nombre para el proyecto';

        $obra = new Obra;
        $date = new Carbon
        $obra->nombre = $request->nameListado;
        $obra->proyecto = $request->nameProyecto;
        $obra->fechaInicio = $date->now();
        $obra->save();

        return 1;
    }

    public function obraControl($data)
    {
        $obra = Obra::find($data);
        $productos_obra = $obra->producto;
        $cantidadFinalizada = 0;
        $kilosTerminados = 0;
        $kilosObra = 0;

        foreach($productos_obra as $producto)
        {
            if($producto->terminado == true)
                $cantidadFinalizada++;
            $kilosObra += ($producto->pesoKg * $producto->cantProducto);
            $trabajadores = $producto->trabajadorWithAtributtes;
            foreach($trabajadores as $trabajador)
                $kilosTerminados += $trabajador->pivot->kilosTrabajados;
        }

        if($cantidadFinalizada == count($productos_obra))
            $terminado = true;
        else
            $terminado = false;

        $obra->terminado = $terminado;
        $obra->save();

        return view('admin.obra.detalle_obra')
                ->with('obra', $obra)
                ->with('productos_obra', $productos_obra)
                ->with('cantidadFinalizada', $cantidadFinalizada)
                ->with('kilosTerminados', $kilosTerminados)
                ->with('kilosObra', $kilosObra)
                ->with('terminado', $terminado);
    }
}
