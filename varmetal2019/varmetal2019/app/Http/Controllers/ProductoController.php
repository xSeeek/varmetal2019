<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;
use Varmetal\Trabajador;

class ProductoController extends Controller
{
    public function adminProducto()
    {
        $productos = Producto::orderBy('prioridad', 'DESC')->get();

        return view('admin.administracion_productos')
                ->with('productos', $productos);
    }

    public function productoControl($id)
    {
        if($id == 'undefined')
            return redirect()->route('adminProducto');

        $producto = Producto::find($id);
        $trabajadores = $producto->trabajador;

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

    public function deleteProducto(Request $request)
    {
        $producto = Producto::find($request)->first();
        $producto->delete();
        return 1;
    }

    public function asignarTrabajo($data)
    {
        $producto = Producto::find($data);
        $trabajadores_almacenados = Trabajador::get();
        $trabajadores = $producto->trabajador;

        $trabajador_disponibles = null;
        $i = 0;
        $cont = 0;

        foreach($trabajadores_almacenados as $t_saved)
        {
            foreach($trabajadores as $t_asig)
                if($t_saved->idTrabajador == $t_asig->idTrabajador)
                    $cont++;
            if($cont == 0)
            {
                $trabajador_disponibles[$i] = $t_saved;
                $i++;
            }
            $cont = 0;
        }

        return view('admin.producto.trabajadores_disponibles')
                ->with('trabajadores_almacenados', $trabajador_disponibles)
                ->with('idProducto', $data);
    }

    public function addWorker(Request $request)
    {
        $response = json_decode($request->DATA);

        $trabajador = Trabajador::find($response[1]);
        $producto = Producto::find($response[0]);

        $trabajador->producto()->attach($producto->idProducto);
        $producto->estado = 2;
        $producto->save();
        return 1;
    }

    public function removeWorker(Request $request)
    {
        $response = json_decode($request->DATA);

        $trabajador = Trabajador::find($response[0]);
        $trabajador->producto()->detach($response[1]);

        $producto = Producto::find($response[1]);
        $trabajadores_producto = $producto->trabajador;
        if(($trabajadores_producto == NULL) || (count($trabajadores_producto) <= 0))
        {
            $producto->estado = 0;
            $producto->save();
        }

        return 1;
    }
}
