<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;
use Varmetal\Trabajador;

class PausaController extends Controller
{
    public function pausaControl($data)
    {
        if($data == 'undefined')
            return redirect()->route('detalleProducto', $idProducto);

        $datos_pausa = Pausa::find($data);
        $productos_pausa = $datos_pausa->productos;
        $trabajador_pausa = $datos_pausa->trabajador;

        return view('admin.pausa.pausa_control')
                ->with('pausa', $datos_pausa)
                ->with('productos_pausa', $productoPausa)
                ->with('trabajador_pausa', $trabajado);
    }

    public function addPausa($idProducto)
    {
      $fechaInicio=now();
      $producto=Producto::find($idProducto);
      return view('pausa.addPausa')
              ->with('producto', $producto)
              ->with('fechaInicio', $fechaInicio);
    }

    public function adminPausas()
    {
        $pausas_registradas = Pausa::get();
        return view('admin.pausa.administracion_pausas')->with('pausas_almacenadas', $pausas_registradas);
    }

    public function insertPausa(Request $data)
    {

      $usuarioActual = Auth::user();
          $trabajador = $usuarioActual->trabajador;
          if($usuarioActual->type == User::DEFAULT_TYPE)
              $trabajador = $usuarioActual->trabajador;
          else
              return -1;

      $response=json_decode($data->DATA);

      $producto = Producto::find($response[0]);
      $trabajador = Trabajador::find($response[3]);

      $newPausa=new Pausa;
      $mytime = Carbon/Carbon::now();
      $newPausa->fechaInicio = $response[2];
      $newPausa->fechaFin = null;
      $newPausa->descripcion = $response[1];
      $newPausa->fechaFin=$response[4];

      $producto->newPausa()->associate($newPausa);
      $newPausa->trabajador()->associate($trabajador);

      $newPausa->save();

      return 1;
    }
}
