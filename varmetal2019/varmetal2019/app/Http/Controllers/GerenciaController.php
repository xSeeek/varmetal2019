<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Obra;
use Varmetal\Producto;
use Varmetal\Trabajador;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
        $j = 0;

        foreach($obras_almacenadas as $obra_almacenada)
        {
            $obra = array();
            $array_trabajadores = array();

            $productos_obra = $obra_almacenada->producto;
            foreach($productos_obra as $producto)
            {
                /* Obtener trabajadores de los productos de la obra */
                $trabajadores = $producto->trabajadorWithAtributtes;

                if($producto->fechaFin > $fechaFin)
                    $fechaFin = $producto->fechaFin;
                if($producto->fechaFin == NULL && $fechaFin == NULL)
                    $fechaFin = $carbon->now();

                $fechaFin = Carbon::parse($fechaFin);

                /* Contar Kilos trabajador por trabajador */
                foreach($trabajadores as $trabajador)
                {
                    $kilosTerminados += $trabajador->pivot->kilosTrabajados;
                    if(($this->isOnArray($array_trabajadores, $trabajador->idTrabajador) == -1))
                    {
                        $array_trabajadores[$j] = array();
                        $data_trabajador = array();
                        $data_trabajador[0] = $trabajador->idTrabajador;
                        $data_trabajador[1] = $trabajador->pivot->fechaComienzo;
                        $data_trabajador[2] = $trabajador->nombre;
                        $array_trabajadores[$j] = $data_trabajador;
                        $j++;
                    }
                    else
                    {
                        $index_trabajador = $this->isOnArray($array_trabajadores, $trabajador->idTrabajador);
                        if(($trabajador->pivot->fechaComienzo != NULL) && ($array_trabajadores[$index_trabajador][1] > $trabajador->pivot->fechaComienzo))
                            $data_trabajador[$index_trabajador][1] = $trabajador->pivot->fechaComienzo;
                    }
                }

                /* Contar tiempo en pausa por trabajador */
                $tiempoPausa += $producto->tiempoEnPausa;
                $tiempoSetUp += $producto->tiempoEnSetUp;

                /* Acumular peso en kilogramos de los productos */
                $kilosObra += ($producto->pesoKg * $producto->cantProducto);
            }

            for($i = 0; $i < count($array_trabajadores); $i++)
                $diffHoras += $this->calcularHorasHombre(Carbon::parse($array_trabajadores[$i][1]), $fechaFin);

            $obra[0] = $obra_almacenada->idObra;
            $obra[1] = $obra_almacenada->codigo;
            $obra[2] = $kilosObra;
            $obra[3] = $kilosTerminados;
            $obra[4] = $kilosObra - $kilosTerminados;
            $obra[5] = $diffHoras;
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
            $diffHoras = 0;
            $j = 0;

            for($i = 0; $i < count($array_trabajadores); $i++)
                unset($array_trabajadores[$i]);
            unset($array_trabajadores);
        }

        return view('gerencia')
                ->with('obras', $obras_reporte);
    }

    private function isOnArray($array, $toFind)
    {
        if(count($array) != 0)
            for($i = 0; $i < count($array); $i++)
                if($array[$i][0] == $toFind)
                    return $i;
        return -1;
    }

    private function calcularHorasHombre($fechaInicio, $fechaFin)
    {
        $period = CarbonPeriod::create($fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d'));
        $period->toggleOptions(CarbonPeriod::EXCLUDE_START_DATE, true);
        $period->toggleOptions(CarbonPeriod::EXCLUDE_END_DATE, true);
        $horasHombre = 0;

        $inDayStart = Carbon::parse($fechaInicio->format('Y-m-d'));
        $inDayEnd = Carbon::parse($fechaFin->format('Y-m-d'));

        if($inDayEnd->diffInHours($inDayStart) < 24)
            return $fechaFin->diffInHours($fechaInicio);
        else
            $startHour = $this->getTimeStart($fechaInicio);

        $finHour = ($fechaFin->format('G') - 8);

        foreach($period as $date)
        {
            $actualDate = $date->format('l');
            $actualHour = $date->format('G');
            $actualMinutes = $date->format('m');

            if($actualHour < 8)
                $actualHour = 8;

            switch($actualDate)
            {
                case('Monday'):
                    $horasHombre += 9;
                    break;
                case('Tuesday'):
                    $horasHombre += 10;
                    break;
                case('Wednesday'):
                    $horasHombre += 10;
                    break;
                case('Thursday'):
                    $horasHombre += 10;
                    break;
                case('Friday'):
                    $horasHombre += 9;
                    break;
                case('Saturday'):
                    $horasHombre += 5;
                default:
                    break;
            }
        }
        $horasHombre += $startHour;
        $horasHombre += $finHour;
        return $horasHombre;
    }

    private function getTimeStart($date)
    {
        $actualDate = $date->format('l');
        $resultDate = 0;
        $diff = 0;
        $hourDate = $date->format('G');

        switch($actualDate)
        {
            case('Monday'):
                if($hourDate > 8)
                    $diff = $hourDate - 8;
                $resultDate += (9 - $diff);
                break;
            case('Tuesday'):
                if($hourDate > 8)
                    $diff = $hourDate - 8;
                $resultDate += (10 - $diff);
                break;
            case('Wednesday'):
                if($hourDate > 8)
                    $diff = $hourDate - 8;
                $resultDate += (10 - $diff);
                break;
            case('Thursday'):
                if($hourDate > 8)
                    $diff = $hourDate - 8;
                $resultDate += (10 - $diff);
                break;
            case('Friday'):
                if($hourDate > 8)
                    $diff = $hourDate - 8;
                $resultDate += (9 - $diff);
                break;
            case('Saturday'):
                if($hourDate > 8)
                    $diff = $hourDate - 8;
                $resultDate += (5 - $diff);
            default:
                break;
        }
        return $resultDate;
    }
}
