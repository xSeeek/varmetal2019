<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pausa;
use App\Producto;

class PausaController extends Controller
{
    public function addPausa($data)
    {
        if($data == 'undefined')
            return redirect()->route('detalleProducto');

        $producto = Producto::find($data);

        return view('trabajador.addPausa')
            ->with('producto', $producto);
    }

    public function insertPausa(Request $data)
    {
        $newPausa=new Pausa;
        $mytime = Carbon/Carbon::now();
        $newPausa->fechaInicio= $mytime;
    }
}
