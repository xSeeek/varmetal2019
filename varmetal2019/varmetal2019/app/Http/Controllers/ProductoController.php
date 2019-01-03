<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
<<<<<<< HEAD
  
=======
    public function detalleProducto($id)
    {
        $producto = Producto::find($id);

        return view('producto.detalle_producto')
                ->with('producto', $producto);
    }
>>>>>>> 1f0f025b06f24e3c04db78c05ac0cfd6deb5d2f4
}
