<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

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
      $newPausa=new Pausa;
      $mytime = Carbon/Carbon::now();
      $newPausa->fechaInicio = $mytime;
      $newPausa->fechaFin = null;
      $newPausa->descripcion = null;
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
