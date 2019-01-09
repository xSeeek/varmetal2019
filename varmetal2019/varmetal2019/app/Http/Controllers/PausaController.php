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

      $idProducto = $response[0];
      $descripcion = $response[1];
      $fechaInicio = $response[2];

      $newPausa=new Pausa;
      $newPausa->fechaInicio = '2019-03-03';
      $newPausa->fechaFin = now()->format('Y-m-d H:m:s');
      $newPausa->descripcion = 'holaholaholahola';
      /*echo'
            fechaInicio: ',$newPausa->fechaInicio,'
            fechaFin: ',$newPausa->fechaFin,'
            descripcion: ',$newPausa->descripcion;*/
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
