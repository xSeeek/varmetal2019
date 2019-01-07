<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;

class PausaController extends Controller
{
    public function addPausa($idTrabajador, $idProducto)
    {
        if($idTrabajador == 'undefined' || $idProducto )
            return redirect()->route('detalleProducto', $idProducto);

        $producto = Producto::find($idProducto);
        $trabajador = Trabajador::find($idTrabajador);

        return view('trabajador.addPausa')
                ->with('pausa', null)
                ->with('producto', $producto)
                ->with('trabajador', $trabajador);
    }

    public function savePausa($data)
    {
      return view('trabajador.addPausa');
    }

    public function adminPausas()
    {
        $pausas_registradas = Pausa::get();
        return view('admin.administracion_pausas')->with('pausas_almacenadas', $pausas_registradas);
    }

    public function insertPausa(Request $data)
    {

      $response=json_decode($data->DATA);

      $producto = Producto::find($response[0]);
      $trabajador = Trabajador::find($response[3]);

      $newPausa=new Pausa;
      $mytime = Carbon/Carbon::now();
      $newPausa->fechaInicio = $response[2];
      $newPausa->fechaFin = null;
      $newPausa->descripcion = $response[1];

      $producto->newPausa()->associate($newPausa);
      $newPausa->trabajador()->associate($trabajador);

      return 1;
    }

    public function pausaControl($data)
    {
      if($data == 'undefined')
      {
        return redirect()->route('')
      }
    }
}
