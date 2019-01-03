<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PausaControllerController extends Controller
{
    public function pausaControl($data)
    {
      if($data == 'indefined')
        return redirect()->route('detalleProducto');

      $datos_pausa = Pausa::find($data);
      $producto = $datos_pausa->producto;
      $pausas = $datos_productos->pausa

      return view('trabajador.pausa_control')
            ->with('pausa', $datos_pausa)
            ->with('producto', $datos_producto);
    }

    public function addPausa()
    {
      return view('trabajador.addPausa');
    }

    public function insertPausa(Request $data)
    {
      $newPausa=new Pausa;
      $mytime = Carbon/Carbon::now();
      $newPausa->fechaInicio= $mytime;
    }
}
