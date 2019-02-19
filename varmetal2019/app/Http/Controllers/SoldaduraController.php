<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Varmetal\Trabajador;
use Varmetal\Producto;
use Varmetal\User;
use Varmetal\Material;


class SoldaduraController extends Controller
{
    public function soldaduraControl($data)
    {
        $pieza = Producto::find($data);
        $gastoAla=0;
        $gastoGas=0;
        $cantidadProducida=0;
        $fechaTermino=NULL;
        $materiales_gastados = $pieza->materialWithAtributes;
        $soldadores = $pieza->trabajadorSoldadorWithAtributtes;
        foreach ($soldadores as $key => $trabajadorActual)
        {
          $cantidadProducida += $trabajadorActual->pivot->productosRealizados;
          foreach ($materiales_gastados as $key => $materiales)
          {
            if($materiales!=NULL)
            {
              $material = Material::find($materiales->pivot->material_id_material);
              if($material->tipo=='Soldador' && $material->nombre=='Gas')
              {
                if($materiales->pivot->trabajador_id_trabajador==$trabajadorActual->idTrabajador)
                {
                    $gastoGas+=$materiales->pivot->gastado;
                }
              }
              if($material->tipo=='Soldador' && $material->nombre=='Alambre')
              {
                if($materiales->pivot->trabajador_id_trabajador==$trabajadorActual->idTrabajador)
                {
                    $gastoAla+=$materiales->pivot->gastado;
                }
              }
              if($fechaTermino==NULL)
              {
                $fechaTermino=$materiales->pivot->fechaTermino;
              }else{
                if($materiales->pivot->fechaTermino!=NULL && $fechaTermino<$materiales->pivot->fechaTermino);
                  $fechaTermino=$materiales->pivot->fechaTermino;
              }
            }
          }
        }
        return view('admin.soldadura.soldadura_control')
                ->with('producto', $pieza)
                ->with('gas', $gastoGas)
                ->with('alambre',$gastoAla)
                ->with('soldadores',$soldadores)
                ->with('fechaTermino',$fechaTermino)
                ->with('cantidadProducida',$cantidadProducida);
    }
    public function removeWorker(Request $request)
    {
        $response = json_decode($request->DATA);

        $trabajador = Trabajador::find($response[0]);
        $trabajador->productoSoldador()->detach($response[1]);
        $producto = Producto::find($response[1]);
        $trabajadores_producto = $producto->trabajadorSoldador;
        $productosRealizados=0;

        if($producto->trabajadorSoldadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first()!=NULL)
        {
          $trabajadores = $producto->trabajadorSoldadorWithAtributtes;

          foreach($trabajadores as $worker)
              if($worker->tipo=="Soldador")
                $productosRealizados += $worker->pivot->productosRealizados;
        }

        if(($trabajadores_producto == NULL) || (count($trabajadores_producto) <= 0))
        {
            if($productosRealizados==0)
              $producto->estado = 0;
            else
              $producto->estado = 2;
            if($productosRealizados>=$producto->cantProducto)
              $producto->zona = 2;
            else
              $producto->zona = 1;
            $producto->save();
        }
        return 1;
    }

    public function reiniciarWorker(Request $request)
    {
        $response = json_decode($request->DATA);

        $trabajador = Trabajador::find($response[0]);
        $trabajador->productoSoldador()->detach($response[1]);
        $productosRealizados=0;

        $producto = Producto::find($response[1]);
        $trabajadores_producto = $producto->trabajadorSoldador;

        if($producto->trabajadorSoldadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first()!=NULL)
        {
          $trabajadores = $producto->trabajadorSoldadorWithAtributtes;

          foreach($trabajadores as $worker)
              if($worker->tipo=="Soldador")
                $productosRealizados += $worker->pivot->productosRealizados;
        }

        if(($trabajadores_producto == NULL) || (count($trabajadores_producto) <= 0))
        {
            $trabajador->productoSoldador()->attach($producto->idProducto);
            if($producto->cantProducto<=$productosRealizados)
              $producto->zona=2;
            else
              $producto->zona=1;
            $producto->estado = 2;
            $producto->save();
        }
        return 1;
    }

    public function asignarTrabajo($data)
    {
        $producto = Producto::find($data);
        $trabajadores_almacenados = Trabajador::join('users', 'users_id_user', 'id')->where('type', 'like', User::DEFAULT_TYPE)->where('tipo','like','Soldador')->get();
        $trabajadores = $producto->trabajadorSoldador;

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
        return view('admin.producto.soldadores_disponibles')
                ->with('trabajadores_almacenados', $trabajador_disponibles)
                ->with('trabajadores_producto', $trabajadores)
                ->with('idProducto', $data);
    }
    public function addWorker(Request $request)
    {
        $response = json_decode($request->DATA);

        $trabajador = Trabajador::find($response[1]);
        $producto = Producto::find($response[0]);
        $productos_trabajador = $trabajador->productoSoldador;
        foreach ($productos_trabajador as $key => $productos) {
          if($productos->pivot->trabajador_id_trabajador==$trabajador->idTrabajador)
            return 2;
        }
        $trabajador->productoSoldador()->attach($producto->idProducto);
        $producto->estado = 2;
        $producto->save();
        return 1;
    }

    public function añadirPiezas(Request $request)
    {
      $response = json_decode($request->DATA);

      $nuevaCantidad=$response[2];
      $idTrabajador=$response[0];
      $codigo=$response[1];

      $cantidad = 0;
      $cantidad += $nuevaCantidad;
      $cont=0;
      $productosRealizados = 0;

      $trabajador = Trabajador::find($idTrabajador);
      $user = $trabajador->user;
      $productos = Producto::get();

      if($trabajador==NULL)
        return 'No existe el trabajador';

      if($productos==NULL)
        return 'No existe el producto';

      if($trabajador->productoSoldador!=NULL)
      {
        foreach ($trabajador->productoSoldador as $key => $producto)
        {
          if($producto->codigo == $codigo)
          {
            if($producto->zona==1)
            {
              $cont=1;
              $dataProducto = $producto->trabajadorSoldadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first();
              $trabajadores = $producto->trabajadorSoldadorWithAtributtes;

              foreach($trabajadores as $worker)
                  if($worker->tipo=="Soldador")
                    $productosRealizados += $worker->pivot->productosRealizados;

              if($producto->cantProducto <= $productosRealizados)
              {
                echo $producto->cantProducto;
                echo '-';
                echo $productosRealizados;
                return '| La pieza ya fue finalizada';
              }

              if(($productosRealizados + $cantidad) > ($producto->cantProducto))
              {
                echo 'La cantidad ingresada supera a la cantidad requerida actual: ';
                echo $productosRealizados;
                echo ' de ';
                echo $producto->cantProducto;
                return;
              }
              $dataProducto->pivot->productosRealizados = ($dataProducto->pivot->productosRealizados) + $cantidad;
              $dataProducto->pivot->kilosTrabajados = ($dataProducto->pivot->productosRealizados) * $producto->pesoKg;
              if($dataProducto->pivot->productosRealizados >= $producto->cantProducto)
              {
                $producto->zona = 2;
                $producto->save();
                $dataProducto->pivot->fechaComienzo = now();
              }else {
                $producto->zona = 1;
                $producto->save();
              }
              $dataProducto->pivot->save();
              $dataProducto->save();
              return 1;
            }else {
              return 2;
            }
          }
        }
      }
      if($cont==0)
      {
        foreach ($productos as $key => $producto)
        {
          if($producto !=NULL)
          {
            if($producto->codigo == $codigo)
            {
              $cont=1;
              $trabajador->productoSoldador()->attach($producto->idProducto, ['fechaComienzo' => now()]);
              $dataProducto = $producto->trabajadorSoldadorWithAtributtes()->where('trabajador_id_trabajador', '=', $trabajador->idTrabajador)->get()->first();
              $trabajadores = $producto->trabajadorSoldadorWithAtributtes;

              foreach($trabajadores as $worker)
                  if($worker->user->type=="Soldador")
                    $productosRealizados += $worker->pivot->productosRealizados;

              if($producto->cantProducto <= $productosRealizados)
              return 'La pieza ya fue finalizada';

              if(($productosRealizados + $cantidad) > ($producto->cantProducto))
              {
                echo 'La cantidad ingresada supera a la cantidad requerida actual: ';
                echo $dataProducto->pivot->productosRealizados;
                echo ' de: ';
                echo $producto->cantProducto;
                return;
              }
                  $dataProducto->pivot->productosRealizados = ($dataProducto->pivot->productosRealizados) + $cantidad;
                  $dataProducto->pivot->kilosTrabajados = ($dataProducto->pivot->productosRealizados) * $producto->pesoKg;
                  if($dataProducto->pivot->productosRealizados == $producto->cantProducto)
                  {
                    $producto->zona = 2;
                    $producto->save();
                    $dataProducto->pivot->fechaComienzo = now();
                  }else {
                    $producto->zona = 1;
                    $producto->save();
                  }
                  $dataProducto->pivot->save();
                  $dataProducto->save();
                  return 1;
            }
          }
        }
      }
      return 'No se encontró el producto';
    }
}
