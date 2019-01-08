<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;

class ProductoController extends Controller
{
    public function adminProducto()
    {
        $productos = Producto::get();

        return view('admin.producto.administracion_productos')
                ->with('productos', $productos);
    }

    public function productoControl($id)
    {
        $producto = Producto::find($id);
        $trabajadores = $producto->trabajador;
        var_dump($trabajadores);

        return view('admin.producto.detalle_producto')
                ->with('producto', $producto)
                ->with('trabajadores', $trabajadores);
    }

    public function detalleProducto($id)
    {
        $producto = Producto::find($id);

        return view('producto.detalle_producto')
                ->with('producto', $producto);
    }
}
