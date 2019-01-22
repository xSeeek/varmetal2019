<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;
use Varmetal\Trabajador;
use Varmetal\Pausa;
use Auth;
use Varmetal\User;
use Carbon\Carbon;

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

      $trabajador = Trabajador::find($idTrabajador);
      $pausa = Pausa::find($idPausa);
      $producto = Producto::find($pausa->producto_id_producto);

      $productos = $trabajador->productoWithAtributes()->where('producto_id_producto', '=', $producto->idProducto)->get()->first();

      $pausa->fechaFin=now();
      $usuarioActual = Auth::user();
      $supervisor = $usuarioActual->trabajador;
      $diferenciaTiempo = $pausa->fechaFin->diffInSeconds($pausa->fechaInicio); //tiempo en segundos
      if($motivo=='Cambio de pieza')
      {
        if($producto->tiempoEnSetUp == 'null')
        {
          $producto->tiempoEnSetUp = $diferenciaTiempo/(60);
          $productos->pivot->tiempoEnSetUp = $diferenciaTiempo/(60);

        }else {
          $producto->tiempoEnSetUp += $diferenciaTiempo/(60);
          $productos->pivot->tiempoEnSetUp += $diferenciaTiempo/(60);
        }
      }
      if($motivo != 'No se pudo especificar el motivo (Leer la descripción)' && $motivo != 'Cambio de pieza')
      {
        if($producto->tiempoEnPausa == 'null')
        {
          $producto->tiempoEnPausa = $diferenciaTiempo/(60);
          $productos->pivot->tiempoEnPausa = $diferenciaTiempo/(60);
        }else {
          $producto->tiempoEnPausa += $diferenciaTiempo/(60);
          $productos->pivot->tiempoEnPausa += $diferenciaTiempo/(60);
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

      if($descripcion==NULL)
      {
        $descripcion = 'No posee descripcion';
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
      $idProducto = $response[1];
      $idPausa = $response[0];
      $pausa = Pausa::find($idPausa);
      $producto = Producto::find($idProducto);

      $usuarioActual = Auth::user();
      if($usuarioActual->trabajador == NULL)
        return view('welcome');
      if($pausa->fechaFin!=NULL)
        return view('welcome');

      if($pausa->fechaFin==NULL)
      {
        $trabajador = $usuarioActual->trabajador;
        $productos = $trabajador->productoWithAtributes()->where('producto_id_producto', '=', $producto->idProducto)->get()->first();
        $productos->pivot->pausasRealizadas--;
        $productos->pivot->save();
        $producto->cantPausa--;
        $producto->save();
        $pausa->delete();
      }else {
        return 'La pausa ya fue finalizada';
      }

      return 'Pausa eliminada';
    }
}
