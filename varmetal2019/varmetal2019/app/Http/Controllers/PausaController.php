<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;

class PausaController extends Controller
{
    public function addPausa($data)
    {
        if($data == 'undefined')
            return redirect()->route('detalleProducto', $data);

        $producto = Producto::find($data);

        return view('trabajador.addPausa')
                ->with('pausa', null)
                ->with('producto', $producto);
    }

    public function savePausa($data)
    {
      return view('trabajador.addPausa');
    }

    public function insertPausa(Request $data)
    {

      $response=json_decode($data->DATA);

      $producto=find($response[0]);

      $newPausa=new Pausa;
      $mytime = Carbon/Carbon::now();
      $newPausa->fechaInicio = $response[3];
      $newPausa->fechaFin = null;
      $newPausa->descripcion = $response[2];

      $producto->newPausa()->associate($newPausa);

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
