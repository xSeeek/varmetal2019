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
        $datos_pausa = Pausa::find($data); //id de la pausa
        $producto = Producto::find($datos_pausa->producto_id_producto);
        $trabajador = Trabajador::find($datos_pausa->trabajador_id_trabajador);

        return view('admin.pausa.detalle_pausa')
                ->with('pausa', $datos_pausa)
                ->with('producto', $producto)
                ->with('trabajador', $trabajador);
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

    public function updateFechaFin(Request $data)
    {
      $pausa = Pausa::find($data->DATA);
      $pausa->fechaFin=now();
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
      //$fechaInicio = $response[2];

      $newPausa=new Pausa;
      $newPausa->fechaInicio = now();
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
      $newPausa->save();
      return 'Datos almacenados';
    }
}
