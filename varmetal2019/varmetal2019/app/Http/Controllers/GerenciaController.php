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
        $obras_almacenadas = Obra::get();
        $carbon = new Carbon();
        $kilosTerminados = 0;
        $kilosObra = 0;
        $tiempoPausa = 0;
        $tiempoSetUp = 0;
        $fechaFin = 0;
        $fechaInicio = 0;
        $diffHoras = 0;

        $obras_reporte = array();
        $index = 0;

        foreach($obras_almacenadas as $obra_almacenada)
        {
            $obra = array();

            $productos_obra = $obra_almacenada->producto;
            foreach($productos_obra as $producto)
            {
                /* Obtener trabajadores de los productos de la obra */
                $trabajadores = $producto->trabajadorWithAtributtes;

                /* Contar Kilos trabajador por trabajador */
                foreach($trabajadores as $trabajador)
                    $kilosTerminados += $trabajador->pivot->kilosTrabajados;

                /* Contar tiempo en pausa por trabajador */
                $tiempoPausa += $producto->tiempoEnPausa;
                $tiempoSetUp += $producto->tiempoEnSetUp;

                if($producto->fechaFin == NULL)
                    $fechaFin = $carbon->now();
                else
                    $fechaFin = $producto->fechaFin;

                $fechaFin = Carbon::parse($fechaFin);
                $fechaInicio = Carbon::parse($producto->fechaInicio);
                $diffHoras += ($fechaFin->diffInMinutes($fechaInicio, true));

                /* Acumular peso en kilogramos de los productos */
                $kilosObra += ($producto->pesoKg * $producto->cantProducto);
            }

            $obra[0] = $obra_almacenada->idObra;
            $obra[1] = $obra_almacenada->codigo;
            $obra[2] = $kilosObra;
            $obra[3] = $kilosTerminados;
            $obra[4] = $kilosObra - $kilosTerminados;
            $obra[5] = $diffHoras/60;
            $obra[6] = $tiempoPausa;
            $obra[7] = $tiempoSetUp;

            // Actualización y asignación de datos a los indices //
            $obras_reporte[$index] = $obra;
            $index++;

            // Reseteo de variables //
            $kilosTerminados = 0;
            $tiempoPausa = 0;
            $tiempoSetUp = 0;
            $kilosObra = 0;
        }

        var_dump($obras_reporte);

        return view('gerencia')
                ->with('obras', $obras_reporte);
    }
}
