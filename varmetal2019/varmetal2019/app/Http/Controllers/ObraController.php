<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Obra;
use Carbon\Carbon;
use Varmetal\Producto;
use Varmetal\Http\Controllers\GerenciaController;

class ObraController extends Controller
{

    public function editar(Request $data)
    {
      $response = json_decode($data->DATA, true);

      $nombre = $response[0];
      $idObra = $response[1];

      $obra = Obra::find($idObra);

      $obra->proyecto = $nombre;
    }

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
            return 'Tiene que ingresar un nombre para la OT';

        if($request->nameProyecto == NULL)
            return 'Tiene que ingresar un nombre para el proyecto';

        $obra_find = Obra::where('codigo', '=', $request->nameListado)->first();
        if($obra_find != NULL)
            return 'Ya existe una OT con el código ingresado';

        $obra = new Obra;
        $date = new Carbon();
        $obra->codigo = $request->nameListado;
        $obra->proyecto = $request->nameProyecto;
        $obra->fechaInicio = $date->now();
        $obra->save();

        return 1;
    }

    public function obraControl($data)
    {
        $obra = Obra::find($data);
        $carbon = new Carbon();
        $productos_obra = $obra->producto()->orderBy('idProducto', 'DESC')->get();
        $cantidadFinalizada = 0;
        $kilosTerminados = 0;
        $kilosObra = 0;
        $tiempoFinalizado = 0;
        $tiempoPausa = 0;
        $tiempoSetUp = 0;
        $fechaFin = NULL;
        $fechaHH = NULL;

        foreach($productos_obra as $producto)
        {
            if($producto->terminado == true)
                $cantidadFinalizada++;
            if((($fechaFin == NULL) && ($producto->fechaFin != NULL)) || (($fechaFin != NULL) && ($producto->fechaFin > $fechaFin)))
                $fechaFin = $producto->fechaFin;
            $kilosObra += ($producto->pesoKg * $producto->cantProducto);
            $trabajadores = $producto->trabajadorWithAtributtes;
            if($producto->pausa != NULL)
            {
              $pausas_almacenadas = $producto->pausa;
              foreach ($pausas_almacenadas as $key => $pausa)
              {
                if($pausa->fechaFin!=NULL)
                {
                  if($pausa->motivo=='Cambio de pieza')
                  {
                    $tiempoSetUp += (new PausaController)->calcularHorasHombre(Carbon::parse($pausa->fechaInicio),Carbon::parse($pausa->fechaFin));
                  }
                  else
                    $tiempoPausa += (new PausaController)->calcularHorasHombre(Carbon::parse($pausa->fechaInicio),Carbon::parse($pausa->fechaFin));
                }
              }
            }

            foreach($trabajadores as $trabajador)
                $kilosTerminados += $trabajador->pivot->kilosTrabajados;
        }

        if($cantidadFinalizada == count($productos_obra))
        {
            $terminado = true;
            if($obra->$fechaFin == NULL)
                $obra->fechaFin = $fechaFin;
        }
        else
            $terminado = false;

        $obra->terminado = $terminado;
        $obra->save();

        if(count($productos_obra) > 0)
            if($terminado == true)
                $tiempoFinalizado = (new GerenciaController)->calcularHorasHombre(Carbon::parse($obra->fechaInicio), Carbon::parse($obra->fechaFin));
            else
                $tiempoFinalizado = (new GerenciaController)->calcularHorasHombre(Carbon::parse($obra->fechaInicio), (new Carbon())->now());
        else
            $tiempoFinalizado = -1;

        return view('admin.obra.detalle_obra')
                ->with('obra', $obra)
                ->with('productos_obra', $productos_obra)
                ->with('cantidadFinalizada', $cantidadFinalizada)
                ->with('kilosTerminados', $kilosTerminados)
                ->with('kilosObra', $kilosObra)
                ->with('terminado', $terminado)
                ->with('tiempoFinalizado', $tiempoFinalizado)
                ->with('tiempoPausa', $tiempoPausa)
                ->with('tiempoSetUp', $tiempoSetUp);
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
