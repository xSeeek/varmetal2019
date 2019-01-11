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
      $date = Carbon::now();
      $producto=Producto::find($idProducto);
      return view('pausa.addPausa')
              ->with('producto', $producto)
              ->with('fechaInicio', $date)
              ->with('pausas_almacenadas', $pausas_registradas);
    }

    public function trabajadorUpdateFechaFin(Request $data)
    {
      $response = json_decode($data->DATA, true);
      $idPausa = $response[0];
      $descripcion = $response[1];
      $pausa = Pausa::find($idPausa);
      $pausa->fechaFin=now();
      $pausa->descripcion=$descripcion;
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
      if($descripcion==NULL)
        return 'Añada una descripción';

      $newPausa=new Pausa;
      $newPausa->fechaInicio = $fechaInicio;
      $newPausa->fechaFin = NULL;
      $newPausa->descripcion = $descripcion;

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
          return redirect()->route('/home');

      $datos_trabajador = $usuarioActual->trabajador;
      $productos = $datos_trabajador->productoWithAtributes()->where('producto_id_producto', '=', $idProducto)->get()->first();
      $productos->pivot->pausasRealizadas--;
      $productos->pivot->save();
      $producto->cantPausa--;
      $producto->save();
      $pausa->delete();

      return 'Pausa eliminada';
    }
}
