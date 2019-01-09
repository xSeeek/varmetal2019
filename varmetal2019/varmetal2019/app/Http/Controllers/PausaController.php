<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;
use Varmetal\Trabajador;
use Varmetal\Pausa;
use Auth;
use Varmetal\User;
use DateTime;

class PausaController extends Controller
{
    public function pausaControl($data)
    {
        if($data == 'undefined')
            return redirect()->route('detalleProducto', $idProducto);
        $datos_pausa = Pausa::find($data);
        if($datos_pausa == NULL )
            return redirect()->route('detalleProducto', $idProducto);
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
        return view('admin.administracion_pausas')
                ->with('pausas_almacenadas', $pausas_registradas);
    }

    public function insertPausa(Request $data)
    {
      $response = json_decode($data->DATA, true);

      $fechaInicio = new DateTime($response[2]);

      $usuarioActual = Auth::user();

      $trabajador = $usuarioActual->trabajador;
      if($usuarioActual->type == User::DEFAULT_TYPE)
          $trabajador = $usuarioActual->trabajador;
      else
          return 'Usted no es un Trabajador';

      if($response[1] == NULL)
          return 2;

      $newPausa=new Pausa;

      $newPausa->fechaInicio = $fechaInicio->format('Y-m-d');
      $newPausa->fechaFin = now()->format('Y-m-d');
      $newPausa->descripcion = $response[1];
      //$newPausa->updated_at=now()->format('Y-m-d');
      //$newPausa->created_at=now()->format('Y-m-d');
      $newPausa->save();

      $producto = Producto::find($response[0]);

      $producto->newPausa()->associate($newPausa);
      $newPausa->trabajador()->associate($trabajador);

      return 1;
    }
}
