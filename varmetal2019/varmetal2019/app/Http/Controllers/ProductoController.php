<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;

class ProductoController extends Controller
{
    public function detalleProducto($id)
    {
        $producto = Producto::find($id);

        return view('producto.detalle_producto')
                ->with('producto', $producto);
    }
}
