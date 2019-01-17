<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Obra;
use Carbon\Carbon;
use Varmetal\Producto;

class ObraController extends Controller
{
    public function adminObra()
    {
        $obras = Obra::get();

        return view('admin.administracion_obras')
                ->with('obras', $obras);
    }

    public function addObra()
    {
        return view('admin.obra.addObra');
    }

    public function insertObra(Request $request)
    {
        if($request->nameListado == NULL)
            return 'Tiene que ingresar un nombre para el listado';

        if($request->nameProyecto == NULL)
            return 'Tiene que ingresar un nombre para el proyecto';

        $obra = new Obra;
        $date = new Carbon();
        $obra->nombre = $request->nameListado;
        $obra->proyecto = $request->nameProyecto;
        $obra->fechaInicio = $date->now();
        $obra->save();

        return 1;
    }

    public function obraControl($data)
    {
        $obra = Obra::find($data);
        $productos_obra = $obra->producto;
        $cantidadFinalizada = 0;
        $kilosTerminados = 0;
        $kilosObra = 0;

        foreach($productos_obra as $producto)
        {
            if($producto->terminado == true)
                $cantidadFinalizada++;
            $kilosObra += ($producto->pesoKg * $producto->cantProducto);
            $trabajadores = $producto->trabajadorWithAtributtes;
            foreach($trabajadores as $trabajador)
                $kilosTerminados += $trabajador->pivot->kilosTrabajados;
        }

        if($cantidadFinalizada == count($productos_obra))
            $terminado = true;
        else
            $terminado = false;

        $obra->terminado = $terminado;
        $obra->save();

        return view('admin.obra.detalle_obra')
                ->with('obra', $obra)
                ->with('productos_obra', $productos_obra)
                ->with('cantidadFinalizada', $cantidadFinalizada)
                ->with('kilosTerminados', $kilosTerminados)
                ->with('kilosObra', $kilosObra)
                ->with('terminado', $terminado);
    }

    public function productosDisponibles($data)
    {
        $productos_almacenados = Producto::where('terminado', 'false')->where('obras_id_obra')->get();

        return view('admin.obra.productos_disponibles')
                ->with('idObra', $data)
                ->with('productos_almacenados', $productos_almacenados);
    }

    public function addProducto(Request $request)
    {
        $response = json_decode($request->DATA);

        $producto = Producto::find($response[1]);
        $producto->obras_id_obra = $response[0];
        $producto->save();

        return 1;
    }

    public function deleteProducto(Request $request)
    {
        $idProducto = $request->DATA;

        $producto = Producto::find($idProducto);
        $producto->obras_id_obra = NULL;
        $producto->save();

        return 1;
    }

    public function deleteObra(Request $request)
    {
        $obra = Obra::find($request->DATA);

        if(count($obra->producto) > 0)
            return 'Debe eliminar las piezas antes de borrar la OT';

        $obra->delete();

        return 1;
    }
}
