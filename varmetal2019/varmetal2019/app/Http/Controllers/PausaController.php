<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;
use Varmetal\Trabajador;
use Varmetal\Pausa;
use Auth;
use Varmetal\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Varmetal\Http\Controllers\GerenciaController;


class PausaController extends Controller
{

    public function pausaControl($data)
    {
        $pausa = Pausa::find($data); //id de la pausa
        $producto = Producto::find($pausa->producto_id_producto);
        $trabajador = Trabajador::find($pausa->trabajador_id_trabajador);
        $usuarioActual = Auth::user();

        return view('admin.pausa.detalle_pausa')
                ->with('pausa', $pausa)
                ->with('producto', $producto)
                ->with('trabajador', $trabajador)
                ->with('usuarioActual', $usuarioActual);
    }

    public function addPausa($idProducto)
    {
      $pausas_registradas = Pausa::get();
      $date = Carbon::now()->toDateTimeString();
      $producto=Producto::find($idProducto);
      $usuarioActual = Auth::user();
      return view('pausa.addPausa')
              ->with('producto', $producto)
              ->with('fechaInicio', $date)
              ->with('pausas_almacenadas', $pausas_registradas)
              ->with('usuarioActual', $usuarioActual);
    }

    public function trabajadorUpdateFechaFin(Request $data)
    {
      $response = json_decode($data->DATA, true);

      $idPausa = $response[0];
      $idTrabajador = $response[1];
      $motivo = $response[2];
      $idObra = $response[3];
      $diferenciaTiempo = 0;

      $trabajador = Trabajador::find($idTrabajador);
      $pausa = Pausa::find($idPausa);
      $producto = Producto::find($pausa->producto_id_producto);

      if($pausa->fechaFin != NULL)
        return view('welcome');

      $productos = $trabajador->productoWithAtributes()->where('producto_id_producto', '=', $producto->idProducto)->get()->first();

      $usuarioActual = Auth::user();
      $supervisor = $usuarioActual->trabajador;

      $pausa->fechaFin = now();
      $diferenciaTiempo = $this->calcularHorasHombre(Carbon::parse($pausa->fechaInicio), ($pausa->fechaFin));

      if($motivo=='Cambio de pieza')
      {
        if($producto->tiempoEnSetUp == NULL)
        {
          $producto->tiempoEnSetUp = $diferenciaTiempo/60;
          $productos->pivot->tiempoEnSetUp = $diferenciaTiempo/60;

        }else{
          $producto->tiempoEnSetUp += $diferenciaTiempo;
          $productos->pivot->tiempoEnSetUp += $diferenciaTiempo/60;
        }
      }
      if($motivo != 'Cambio de pieza')
      {
        if($producto->tiempoEnPausa == NULL)
        {
          $producto->tiempoEnPausa = $diferenciaTiempo/60;
          $productos->pivot->tiempoEnPausa = $diferenciaTiempo/60;
        }else {
          $producto->tiempoEnPausa += $diferenciaTiempo/60;
          $productos->pivot->tiempoEnPausa += $diferenciaTiempo/60;
        }
      }
      $producto->save();
      $productos->pivot->save();
      $pausa->save();
      return 1;
    }

    public function updateFechaFin(Request $data)
    {
      $fechaHora = Carbon::now();
      $pausa = Pausa::find($data->DATA);
      if($pausa->fechaFin != NULL)
        return view('welcome');
      $pausa->fechaFin= $fechaHora->toDateTimeString();
      $pausa->save();
      return 1;
    }

    public function adminPausasDeProducto($idProducto)
    {
      $producto = Producto::find($idProducto);
      $pausas_registradas = Pausa::get();
      return view('admin.administracion_pausas_producto')
              ->with('producto', $producto)
              ->with('pausas_almacenadas', $pausas_registradas);
    }

    public function adminPausas()
    {
        $pausas_registradas = Pausa::get();
        $productos_registrados = Producto::get();
        return view('admin.administracion_pausas')
                ->with('pausas_almacenadas', $pausas_registradas)
                ->with('productos_almacenados', $productos_registrados);
    }

    public function insertPausa(Request $data)
    {

      $response = json_decode($data->DATA, true);
      $idProducto = $response[0];
      $descripcion = $response[1];
      $fechaInicio = $response[2];
      $motivo = $response[3];

      if($motivo==4 && $descripcion==NULL)
      {
        return "Debe ingresar una descripcion";
      }else{
        $descripcion = "No Posee descripcion";
      }

      $newPausa=new Pausa;
      $newPausa->fechaInicio = $fechaInicio;
      $newPausa->fechaFin = NULL;
      $newPausa->descripcion = $descripcion;
      if($response[3]=='0')
      {
        $newPausa->motivo='Falta materiales';
      }
      if($response[3]=='1')
      {
        $newPausa->motivo='Falla en el equipo';
      }
      if($response[3]=='2')
      {
        $newPausa->motivo='Falla en el plano';
      }
      if($response[3]=='3')
      {
        $newPausa->motivo='Cambio de pieza';
      }
      if($response[3]=='No se pudo especificar el motivo (Leer la descripción)')
      {
        $newPausa->motivo='No se pudo especificar el motivo (Leer la descripción)';
      }
      $producto = Producto::find($idProducto);
      $newPausa->producto()->associate($producto);
      $usuarioActual = Auth::user();
      $trabajador = $usuarioActual->trabajador;
      if($usuarioActual->type == User::DEFAULT_TYPE){
          $trabajador = $usuarioActual->trabajador;
          $newPausa->trabajador()->associate($trabajador);
      }
      else
          return 'Usted no es un Trabajador';
      $productos = $trabajador->productoWithAtributes()->where('producto_id_producto', '=', $producto->idProducto)->get()->first();
      $productos->pivot->pausasRealizadas++;
      $productos->pivot->save();
      $producto->cantPausa++;
      $producto->save();
      $newPausa->save();
      return 'Datos almacenados';
    }

    public function deletePausa(Request $data)
    {
      $response = json_decode($data->DATA, true);
      $idPausa = $response[0];
      $idProducto = $response[1];
      $pausa = Pausa::find($idPausa);
      $producto = Producto::find($idProducto);
      $trabajador = Trabajador::find($pausa->trabajador_id_trabajador);

      if($pausa->fechaFin!=NULL)
        return 'Pausa ya finalizada';
      if($pausa == NULL)
        return 'No existe la pausa';

      if($pausa->fechaFin==NULL)
      {
        $productos = $trabajador->productoWithAtributes()->where('producto_id_producto', '=', $producto->idProducto)->get()->first();
        if($productos!=NULL)
        {
          $productos->pivot->pausasRealizadas--;
          $productos->pivot->save();
          $producto->cantPausa--;
          $producto->save();
          $pausa->delete();
        }else {
          return 'No existe el pivot';
        }
      }else {
        return 'La pausa ya fue finalizada';
      }

      return 'Pausa eliminada';
    }

    public function calcularHorasHombre($fechaInicio, $fechaFin)
    {
        $period = CarbonPeriod::create($fechaInicio->format('Y-m-d h:m:s'), $fechaFin->format('Y-m-d h:m:s'));
        $period->toggleOptions(CarbonPeriod::EXCLUDE_START_DATE, true);
        $period->toggleOptions(CarbonPeriod::EXCLUDE_END_DATE, true);
        $horasHombre = 0*60;

        $inDayStart = Carbon::parse($fechaInicio->format('Y-m-d h:m:s'));
        $inDayEnd = Carbon::parse($fechaFin->format('Y-m-d h:m:s'));

        if($inDayEnd->diffInMinutes($inDayStart) < 24*60*60)
            return $fechaFin->diffInMinutes($fechaInicio);
        else
            $startHour = $this->getTimeStart($fechaInicio);

        $finHour = ($fechaFin->format('m') - 8*60);

        foreach($period as $date)
        {
            $actualDate = $date->format('l');
            $actualHour = $date->format('m');
            $actualMinutes = $date->format('s');

            if($actualHour < 8*60)
                $actualHour = 8*60;

            switch($actualDate)
            {
                case('Monday'):
                    $horasHombre += 9*60;
                    break;
                case('Tuesday'):
                    $horasHombre += 10*60;
                    break;
                case('Wednesday'):
                    $horasHombre += 10*60;
                    break;
                case('Thursday'):
                    $horasHombre += 10*60;
                    break;
                case('Friday'):
                    $horasHombre += 9*60;
                    break;
                case('Saturday'):
                    $horasHombre += 5*60;
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
        $resultDate = 0.0;
        $diff = 0.0;
        $hourDate = $date->format('m');

        switch($actualDate)
        {
            case('Monday'):
                if($hourDate > 8*60)
                    $diff = $hourDate - 8*60;
                $resultDate += (9*60 - $diff);
                break;
            case('Tuesday'):
                if($hourDate > 8*60)
                    $diff = $hourDate - 8*60;
                $resultDate += (10*60 - $diff);
                break;
            case('Wednesday'):
                if($hourDate > 8*60)
                    $diff = $hourDate - 8*60;
                $resultDate += (10*60 - $diff);
                break;
            case('Thursday'):
                if($hourDate > 8*60)
                    $diff = $hourDate - 8*60;
                $resultDate += (10*60 - $diff);
                break;
            case('Friday'):
                if($hourDate > 8*60)
                    $diff = $hourDate - 8*60;
                $resultDate += (9*60 - $diff);
                break;
            case('Saturday'):
                if($hourDate > 8*60)
                    $diff = $hourDate - 8*60;
                $resultDate += (5*60 - $diff);
            default:
                break;
        }
        return $resultDate;
    }
}
