<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Obra;
use Varmetal\Producto;
use Varmetal\Trabajador;
use Carbon\Carbon;

class GerenciaController extends Controller
{
    public function showObras()
    {
        $obras_almancenadas = Obra::get();
        $obra = Obra::find($data);
        $carbon = new Carbon();
        $productos_obra = $obra->producto;
        $cantidadFinalizada = 0;
        $kilosTerminados = 0;
        $kilosObra = 0;
        $tiempoFinalizado = 0;
        $tiempoPausa = 0;
        $tiempoSetUp = 0;
        $fechaFin = 0;
        $fechaInicio = 0;

        foreach($obras_almancenadas as $obra_almacenada)
        {
            break;
        }

        foreach($productos_obra as $producto)
        {
            if($producto->terminado == true)
            {
                $cantidadFinalizada++;
                $fechaFin = Carbon::parse($producto->fechaFin);
                $fechaInicio = Carbon::parse($producto->fechaInicio);
                $tiempoFinalizado += ($fechaFin->diffInMinutes($fechaInicio, true));
            }
            $kilosObra += ($producto->pesoKg * $producto->cantProducto);
            $trabajadores = $producto->trabajadorWithAtributtes;
            $tiempoPausa += $producto->tiempoEnPausa;
            $tiempoSetUp += $producto->tiempoEnSetUp;

            foreach($trabajadores as $trabajador)
                $kilosTerminados += $trabajador->pivot->kilosTrabajados;
        }

        if($cantidadFinalizada == count($productos_obra))
            $terminado = true;
        else
            $terminado = false;

        $obra->terminado = $terminado;
        $obra->save();

        return view('gerencia')
                ->with('obra', null);
    }
}
