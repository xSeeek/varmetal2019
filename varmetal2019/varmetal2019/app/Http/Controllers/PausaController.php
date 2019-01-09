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
        if($data == 'undefined')
            return redirect()->route('detalleProducto', $idProducto);
        $datos_pausa = Pausa::find($data); //id de la pausa
        if($datos_pausa == NULL )
            return redirect()->route('detalleProducto', $idProducto);
        $productoPausa = $datos_pausa->productos;
        $trabajador = $datos_pausa->trabajador;

        return view('admin.pausa.pausa_control')
                ->with('pausa', $datos_pausa)
                ->with('productos_pausa', $productoPausa)
                ->with('trabajador_pausa', $trabajador);
    }

    public function addPausa($idProducto)
    {
      $date = Carbon::now();
      $producto=Producto::find($idProducto);
      return view('pausa.addPausa')
              ->with('producto', $producto)
              ->with('fechaInicio', $date);
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
