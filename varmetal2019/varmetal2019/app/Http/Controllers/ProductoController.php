<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Producto;
use Varmetal\Trabajador;
use Varmetal\User;
use Varmetal\Obra;
use Varmetal\Tipo;
use Carbon\Carbon;
use Varmetal\Ayudante;
use Varmetal\TrabajosAyudante;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{

    public function editar(Request $data)
    {
      $response = json_decode($data->DATA, true);

      $nombre = $response[0];
      $peso = $response[1];
      $prioridad = $response[2];
      $cantidad = $response[3];
      $idProducto = $response[4];

      $producto = Producto::find($idProducto);

      $producto->nombre = $nombre;
      $producto->pesoKg = $peso;
      $producto->prioridad = $prioridad;
      if($cantidad!=NULL)
        $producto->cantProducto = $cantidad;
      $producto->save();
    }

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
        $trabajadores = $producto->trabajadorWithAtributtes;
        $obra = $producto->obra;
        $tipo = $producto->tipo;

        $cantidadProducida = 0;
        foreach($trabajadores as $trabajador)
            $cantidadProducida += $trabajador->pivot->productosRealizados;

        return view('admin.producto.detalle_producto')
                ->with('producto', $producto)
                ->with('trabajadores', $trabajadores)
                ->with('cantidadProducida', $cantidadProducida)
                ->with('obra', $obra)
                ->with('tipo', $tipo);
    }

    public function detalleProducto($id)
    {
        $usuarioActual= Auth::user();
        $producto = Producto::find($id);
        $trabajadores = $producto->trabajadorWithAtributtes;

        $cantidadProducida = 0;
        foreach($trabajadores as $trabajador)
            $cantidadProducida += $trabajador->pivot->productosRealizados;

        $obra = $producto->obra;

        $trabajador = $usuarioActual->trabajador;

        return view('producto.detalle_producto')
                ->with('producto', $producto)
                ->with('trabajadores', $trabajadores)
                ->with('cantidadProducida', $cantidadProducida)
                ->with('obra', $obra)
                ->with('usuarioActual',$usuarioActual)
                ->with('trabajador', $trabajador);
    }

    public function addProducto()
    {
        $obras = Obra::get();
        $tipos = Tipo::get();

        return view('admin.producto.addProducto')
                ->with('obras', $obras)
                ->with('tipos', $tipos);
    }

    public function insertProducto(Request $request)
    {
        if($request->pesoProducto == NULL)
            return 'Tiene que ingresar el peso del producto.';;
        if($request->cantidadProducto == NULL)
            return 'Tiene que ingresar una cantidad para el producto';
        if($request->cantidadProducto < 0)
            return 'La cantidad tiene que ser mayor a 0';
        if($request->pesoProducto < 0)
            return 'La cantidad tiene que ser mayor a 0';
        if($request->codigoProducto == NULL)
            return 'El código del producto no puede estar en blanco.';

        $busqueda = Producto::where('codigo', $request->codigoProducto)->get();

        if(count($busqueda) > 0)
            return 'Ya existe una pieza con el código ingresado';

        $producto = new Producto;
        $producto->nombre = $request->nombreProducto;
        $producto->codigo = $request->codigoProducto;
        $producto->pesoKg = $request->pesoProducto;
        $producto->cantPausa = 0;
        $producto->prioridad = $request->inputPrioridad;
        $producto->fechaInicio = $request->fechaInicio;
        $producto->cantProducto = $request->cantidadProducto;
        $producto->fechaFin = NULL;
        $producto->obras_id_obra = $request->obraProducto;
        $producto->tipo_id_tipo = $request->tipoProducto;

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
        $trabajadores_almacenados = Trabajador::join('users', 'users_id_user', 'id')->where('type', 'like', User::DEFAULT_TYPE)->get();
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

    public function markAsFinished(Request $request)
    {
        $producto = Producto::findOrFail($request)->first();

        if($producto->terminado == false)
        {
            if($producto->estado == 1)
                return 'El producto fue marcado como finalizado por otro trabajador';

            $date = new Carbon();

            if($producto->fechaInicio > $date->now())
                return 'Se debe esperar hasta la hora de inicio para poder detener la producción.';

            $producto->estado = 1;
            $producto->fechaFin = $date->now();

            $producto->save();
            return 1;
        }
        return 'El producto fue finalizado por el supervisor';
    }

    public function unmarkAsFinished(Request $request)
    {
        $producto = Producto::findOrFail($request)->first();

        if($producto->terminado == false)
        {
            if($producto->estado == 2)
                return 'El desarrollo del producto fue reiniciado por otro trabajador';

            $producto->estado = 2;
            $producto->fechaFin = NULL;

            $producto->save();
            return 1;
        }
        return 'El producto fue finalizado por el supervisor';
    }

    public function finishProducto(Request $request)
    {
        $producto = Producto::findOrFail($request)->first();

        if($producto->terminado == false)
        {
            $date = new Carbon();
            $producto->estado = 1;
            $producto->fechaFin = $date->now();
            $producto->terminado = true;

            $producto->save();
            return 1;
        }

        return 'Este producto finalizó su desarrollo';
    }

    public function resetProducto(Request $request)
    {
        $producto = Producto::findOrFail($request)->first();
        $trabajadores = $producto->trabajadorWithAtributtes;

        $producto->estado = 2;
        $producto->fechaFin = NULL;
        $producto->terminado = false;

        foreach($trabajadores as $trabajador)
        {
            $trabajador->pivot->productosRealizados = 0;
            $trabajador->pivot->save();
        }

        $producto->save();
        return 1;
    }

    public function updateCantidadProducto(Request $request)
    {
        $response = json_decode($request->DATA);

        $usuarioActual = Auth::user();

        if($this->is_decimal($response[1]) == true)
            return 'La cantidad ingresada no puede tener puntos ni comas';

        if($usuarioActual->trabajador == NULL)
            return redirect()->route('/home');

        $datos_trabajador = $usuarioActual->trabajador;
        $producto = Producto::find($response[0]);
        $productosRealizados = 0;

        $dataProducto = $producto->trabajadorWithAtributtes()->where('trabajador_id_trabajador', '=', $datos_trabajador->idTrabajador)->get()->first();
        $trabajador = $producto->trabajadorWithAtributtes;

        foreach($trabajador as $worker)
            $productosRealizados += $worker->pivot->productosRealizados;

        if(($productosRealizados + $response[1]) > ($producto->cantProducto))
            return 'La cantidad ingresada supera a la cantidad requerida del producto';

        $dataProducto->pivot->productosRealizados = ($dataProducto->pivot->productosRealizados) + $response[1];
        $dataProducto->pivot->kilosTrabajados = ($dataProducto->pivot->productosRealizados) * $producto->pesoKg;

        $date = new Carbon();



        foreach($trabajador as $worker)
            foreach($worker->ayudante as $ayudantes)
            {
                continue;
            }

        $dataProducto->pivot->save();
        $dataProducto->save();

        return 1;
    }

    private function is_decimal( $val )
    {
        return is_numeric( $val ) && floor( $val ) != $val;
    }

    public function asignarObra($data)
    {
        $obras_disponibles = Obra::get();

        return view('admin.producto.obras_disponibles')
            ->with('obras_disponibles', $obras_disponibles)
            ->with('idProducto', $data);
    }
}
