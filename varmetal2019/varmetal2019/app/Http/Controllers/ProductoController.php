<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;

class ProductoController extends Controller
{
    public function adminProducto()
    {
        $productos = Producto::get();

        return view('admin.administracion_productos')
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

    public function addProducto()
    {
        return view('admin.producto.addProducto');
    }

    public function insertProducto(Request $request)
    {
        if($request->nombreProducto == NULL)
            return 'Tiene que ingresar un nombre para el producto';
        if($request->pesoProducto == NULL)
            return 'Tiene que ingresar el peso del producto.';;
        if($request->cantidadProducto == NULL)
            return 'Tiene que ingresar una cantidad para el producto';
        if($request->cantidadProducto < 0)
            return 'La cantidad tiene que ser mayor a 0';
        if($request->pesoProducto < 0)
            return 'La cantidad tiene que ser mayor a 0';

        $producto = new Producto;
        $producto->nombre = $request->nombreProducto;
        $producto->pesoKg = $request->pesoProducto;
        $producto->cantPausa = 0;
        $producto->prioridad = $request->inputPrioridad;
        $producto->fechaInicio = now();
        $producto->cantProducto = $request->cantidadProducto;
        $producto->fechaFin = NULL;

        $producto->save();
        return 1;
    }
}
