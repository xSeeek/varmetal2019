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
      $date = Carbon::now()->toDateTimeString();
      $producto=Producto::find($idProducto);
      $usuarioActual = Auth::user();
      $pausas_registradas = $usuarioActual->trabajador->pausa;
      return view('pausa.addPausa')
              ->with('producto', $producto)
              ->with('fechaInicio', $date)
              ->with('pausas_almacenadas', $pausas_registradas)
              ->with('usuarioActual', $usuarioActual);
    }

    public function editarPausa(Request $data)
    {
      $response = json_decode($data->DATA, true);

      $fechaInicio = $response[0];
      $fechaFin = $response[1];
      $motivo = $response[2];
      $descripcion = $response[3];
      $idPausa = $response[4];

      $pausa = Pausa::find($idPausa);

      if($motivo==4)
      {
        if($descripcion==NULL)
        {
          return "Debe Añadir una Descripción";
        }else {
          $pausa->motivo="Otro";
          $pausa->descripcion=$descripcion;;
        }
      }
      $pausa->fechaInicio=$fechaInicio;
      $pausa->fechaFin=$fechaFin;
      $pausa->save();

    }


    public function trabajadorUpdateFechaFin(Request $data)
    {
      $response = json_decode($data->DATA, true);

      $idPausa = $response[0];

      $pausa = Pausa::find($idPausa);

      if($pausa->fechaFin != NULL)
        return view('welcome');

      $pausa->fechaFin = now();
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
      $fechaInicio = now();
      $motivo = $response[3];

      if($motivo==4)
      {
        if($descripcion==NULL)
          return "Debe ingresar una descripcion";
      }
      if($motivo!=4)
        $descripcion='No Posee  Descripcion';

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
      if($response[3]=='4')
      {
        $newPausa->motivo='Otro';
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
        $conjunto = $producto->conjunto;
        $data_conjunto = $trabajador->conjuntoWithAtributtes()->where('conjunto_id_conjunto', '=', $conjunto->idConjunto)->get()->first();

        if($data_conjunto!=NULL)
        {
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
        $period = CarbonPeriod::create($fechaInicio->format('Y-m-d'), $fechaFin->format('Y-m-d'));
        $period->toggleOptions(CarbonPeriod::EXCLUDE_START_DATE, true);
        $period->toggleOptions(CarbonPeriod::EXCLUDE_END_DATE, true);
        $horasHombre = 0;

        $inDayStart = Carbon::parse($fechaInicio->format('Y-m-d'));
        $inDayEnd = Carbon::parse($fechaFin->format('Y-m-d'));

        if($inDayEnd->diffInHours($inDayStart) == 0)
            return $fechaFin->diffInHours($fechaInicio);
        else
            $startHour = $this->getTimeStart($fechaInicio);

        $finHour = $this->getTimeEnd($fechaFin);

        foreach($period as $date)
        {
            $actualDate = $date->format('l');
            $actualHour = $date->format('G');
            $actualMinutes = $date->format('m');

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
        $horasHombre += $startHour; //3 horas
        $horasHombre += $finHour; //6 horas
        return $horasHombre; //9 horas
    }

    private function getTimeStart($date) //2019-02-02 10:55:16
    {
        $actualDate = $date->format('l');//sabado
        $resultDate = 0;
        $diff = 0;
        $hourDate = $date->format('G');//10

        switch($actualDate)
        {
            case('Monday'):
                if($hourDate > 8)
                    $diff = 9-($hourDate - 8);
                $resultDate = $diff;
                break;
            case('Tuesday'):
                if($hourDate > 8)
                    $diff = 10-($hourDate - 8);
                $resultDate = $diff;
                break;
            case('Wednesday'):
                if($hourDate > 8)
                    $diff = 10-($hourDate - 8);
                $resultDate = $diff;
                break;
            case('Thursday'):
                if($hourDate > 8)
                    $diff = 10-($hourDate - 8);
                $resultDate = $diff;
                break;
            case('Friday'):
                if($hourDate > 8)
                    $diff = 9-($hourDate - 8);
                $resultDate = $diff;
                break;
            case('Saturday'):
                if($hourDate > 8)
                    $diff = 5-($hourDate-8); //5-(10-8)=3
                $resultDate = $diff;
            default:
                break;
        }
        //9
        return $resultDate;
    }

    private function getTimeEnd($date) //2019-02-04 15:48:48
    {
        $actualDate = $date->format('l'); //lunes
        $resultDate = 0;
        $diff = 0;
        $hourDate = $date->format('G'); //15

        switch($actualDate)
        {
            case('Monday'):
                if($hourDate < 18)//15<18
                  $diff = 9-(18 - $hourDate); //9-(18-15)=6
                $resultDate = $diff;
                break;
            case('Tuesday'):
                if($hourDate < 19)
                  $diff = 10-(19 - $hourDate);
                $resultDate = $diff;
                break;
            case('Wednesday'):
                if($hourDate < 19)
                  $diff = 10-(19 - $hourDate);
                $resultDate = $diff;
                break;
            case('Thursday'):
                if($hourDate < 19)
                  $diff = 10-(19 - $hourDate);
                $resultDate = $diff;
                break;
            case('Friday'):
                if($hourDate < 18)
                  $diff = 9-(18 - $hourDate);
                $resultDate = $diff;
                break;
            case('Saturday'):
                if($hourDate < 13)
                  $diff = 5-(13 - $hourDate);
                $resultDate = $diff;
                break;
            default:
                break;
        }
        return $resultDate;
    }
}
