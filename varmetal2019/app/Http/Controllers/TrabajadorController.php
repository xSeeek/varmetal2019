<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Trabajador;
use Varmetal\User;
use Varmetal\Producto;
use Varmetal\Material;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Varmetal\Ayudante;
use Varmetal\ConjuntoProducto;
use Varmetal\Obra;
use Varmetal\Http\Controllers\GerenciaController;

class TrabajadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editar(Request $data)
    {
      $response = json_decode($data->DATA, true);

      $nuevoNombre = $response[0];
      $idTrabajador= $response[1];

      $trabajador = Trabajador::find($idTrabajador);

      $trabajador->nombre = $nuevoNombre;
      $trabajador->save();
    }

    public function detallesCuentaTrabajador()
    {
      $usuarioActual = Auth::user();

      if($usuarioActual->trabajador == NULL)
          return redirect()->route('/home');

      $trabajadorActual = $usuarioActual->trabajador;
      $kilosTrabajados = 0;
      $toneladas = 0;
      $date = new Carbon();
      $ayudantes = $trabajadorActual->ayudante;
      if($trabajadorActual->tipo=="Operador")
      {
        $productos_trabajador = $trabajadorActual->productoWithAtributes;
        foreach($productos_trabajador as $producto)
        {
            if($producto->fechaFin != NULL)
              if((Carbon::parse($producto->fechaFin)->format('m')) == $date->now()->format('m'))
                  $kilosTrabajados += $producto->pivot->kilosTrabajados;
            if($producto->pivot->kilosTrabajados!=0)
              $toneladas += ($producto->tipo->factorKilo*$producto->pivot->kilosTrabajados);
        }
        $toneladas /= 1000;
        $datos_trabajador = $usuarioActual->trabajador;
        $ayudantes = $datos_trabajador->ayudante;
          return view('trabajador')
                    ->with('user', $usuarioActual)
                    ->with('trabajador', $trabajadorActual)
                    ->with('kilosTrabajados', $kilosTrabajados)
                    ->with('ayudantes_almacenados',$ayudantes)
                    ->with('trabajador',$datos_trabajador)
                    ->with('toneladas', $toneladas);
      }
      if($trabajadorActual->tipo=="Soldador")
      {
        $gastoGas=0;
        $gastoAla=0;
        $materiales_gastados = $trabajadorActual->materialWithAtributes;
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
          }
        }
        $productos_soldador = $trabajadorActual->productoSoldadorWithAtributes;
        foreach($productos_soldador as $producto)
        {
              if((Carbon::parse($producto->fechaFin)->format('m')) == $date->now()->format('m'))
                if($producto->cantProducto==1)
                {
                  if(count($producto->trabajadorSoldador)!=0)
                    $kilosTrabajados += $producto->pivot->kilosTrabajados/count($producto->trabajadorSoldador);
                }
                else
                {
                  $kilosTrabajados += $producto->pivot->kilosTrabajados;
                }
            if($producto->pivot->kilosTrabajados!=0)
              $toneladas += ($producto->tipo->factorKilo*$producto->pivot->kilosTrabajados);
        }
        $fecha=NULL;
        $ultimo_material_gastado = $trabajadorActual->materialWithAtributes()->where('trabajador_id_trabajador','=',$trabajadorActual->idTrabajador)->orderBy('fechaTermino','desc')->get()->first();
        if($ultimo_material_gastado!=NULL)
          $fecha= Carbon::parse($ultimo_material_gastado->pivot->fechaTermino);



        $toneladas /= 1000;
        $datos_trabajador = $usuarioActual->trabajador;
        $ayudantes = $datos_trabajador->ayudante;
        return view('soldador')
                  ->with('user', $usuarioActual)
                  ->with('trabajador', $trabajadorActual)
                  ->with('ayudantes_almacenados', $ayudantes)
                  ->with('kilosTrabajados',$kilosTrabajados)
                  ->with('gastoAla',$gastoAla)
                  ->with('gastoGas',$gastoGas)
                  ->with('fecha',$fecha);
      }
    if($trabajadorActual->tipo=="Pintor")
            return view('pintor')
            ->with('user', $usuarioActual)
            ->with('trabajador', $trabajadorActual)
            ->with('ayudantes_almacenados', $ayudantes);
    }

    public function adminTrabajadores($type)
    {
        $trabajadores_registrados = Trabajador::join('users', 'users_id_user', 'id')->where('type', 'like', $type)->get();
        return view('admin.administracion_trabajadores')
                  ->with('trabajadores_almacenados', $trabajadores_registrados);
    }

    public function trabajadorControl($data)
    {
        if($data == 'undefined')
            return redirect()->route('adminTrabajador');

        $datos_trabajador = Trabajador::find($data);
        $userTrabajador = $datos_trabajador->user;


        $kilosTrabajados = 0;
        $toneladas = 0;
        $tiempoPausa = 0;
        $tiempoSetUp = 0;
        $horasHombre = 0;
        $date = new Carbon();
        $productos_registrados = array();
        $fechaConjunto = NULL;
        $productosAuxiliar = array();
        $j = 0;
        $k = 0;
        $array_productos = array();
        $productosAyuda = array();

        if($datos_trabajador->tipo == Trabajador::OPERADOR_TYPE)
        {
          $productos_trabajador = $datos_trabajador->productoWithAtributes;
          foreach($productos_trabajador as $producto)
          {
              if($producto->fechaFin != NULL)
                if((Carbon::parse($producto->fechaFin)->format('m')) == $date->now()->format('m'))
                    $kilosTrabajados += $producto->pivot->kilosTrabajados;
              if($producto->pivot->kilosTrabajados!=0)
                $toneladas += ($producto->tipo->factorKilo*$producto->pivot->kilosTrabajados);

              if((Carbon::parse($producto->fechaFin)->format('m')) == $date->now()->format('m'))
              {
                  if($producto->pausa !=NULL)
                  {
                      $pausas_almacenadas = $producto->pausa;
                      foreach ($pausas_almacenadas as $key => $pausa)
                          if($pausa->fechaFin!=NULL)
                              if($pausa->motivo=='Cambio de pieza')
                                  $tiempoSetUp += (new PausaController)->calcularHorasHombre(Carbon::parse($pausa->fechaInicio),Carbon::parse($pausa->fechaFin));
                              else
                                  $tiempoPausa += (new PausaController)->calcularHorasHombre(Carbon::parse($pausa->fechaInicio),Carbon::parse($pausa->fechaFin));
                  }

                  if(((new GerenciaController)->isOnArray($array_productos, $producto->conjunto_id_conjunto, 1) == -1) && ($this->hasConjunto($producto->conjunto_id_conjunto, $datos_trabajador->conjunto) == true))
                  {
                      $array_productos[$j] = array();
                      $data_trabajador = array();
                      $data_trabajador[0] = $producto->conjunto->fechaInicio;
                      $data_trabajador[1] = $producto->conjunto_id_conjunto;

                      $fechaFin = $producto->conjunto->fechaFin;
                      if($fechaFin == NULL)
                          $data_trabajador[2] = $date->now();
                      else
                          $data_trabajador[2] = $fechaFin;

                      $array_productos[$j] = $data_trabajador;
                      $j++;
                  }
                  if($producto->pivot->fechaComienzo != NULL)
                  {
                      $data_producto = array();
                      $data_producto[0] = $producto->idProducto;
                      $data_producto[1] = $datos_trabajador->idTrabajador;
                      $data_producto[2] = $producto->pivot->fechaComienzo;
                      $productosAyuda[$k] = $data_producto;
                      $k++;
                  }
              }
          }

          for($i = 0; $i < count($array_productos); $i++)
              $horasHombre += (new GerenciaController)->calcularHorasHombre(Carbon::parse($array_productos[$i][0]), Carbon::parse($array_productos[$i][2]));

          $horasHombre += (new GerenciaController)->productosEnAyuda($productosAyuda);

          $toneladas /= 1000;
          $bono = $toneladas*5500;

          if($datos_trabajador->cargo=='M1')
            $sueldo = 385000;

          $productos = $datos_trabajador->productoIncompleto;
          $productosCompletos = $datos_trabajador->productosCompletosMesActual;
          return view('admin.trabajador.trabajador_control')
                                  ->with('trabajador', $datos_trabajador)
                                  ->with('usuario_trabajador', $userTrabajador)
                                  ->with('productos_trabajador', $productos)
                                  ->with('bono', $bono)
                                  ->with('kilosTrabajados',$kilosTrabajados)
                                  ->with('sueldo',$sueldo)
                                  ->with('tiempoPausa', $tiempoPausa)
                                  ->with('tiempoSetUp', $tiempoSetUp)
                                  ->with('horasHombre', $horasHombre)
                                  ->with('productosCompletos', $productosCompletos);
        }
        if($datos_trabajador->tipo=="Soldador")
        {
          if($userTrabajador->trabajador == NULL)
              return redirect()->route('/home');

          $trabajadorActual = $datos_trabajador;
          $usuarioActual = $trabajadorActual->user;

          $kilosTrabajados = 0;
          $toneladas = 0;
          $date = new Carbon();

          $gastoGas=0;
          $gastoAla=0;
          $materiales_gastados = $trabajadorActual->materialWithAtributes;
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
            }
          }
          $productos_soldador = $trabajadorActual->productoSoldadorWithAtributes;
          foreach($productos_soldador as $producto)
          {
                if((Carbon::parse($producto->fechaFin)->format('m')) == $date->now()->format('m'))
                  if($producto->cantProducto==1)
                  {
                    if(count($producto->trabajadorSoldador)!=0)
                      $kilosTrabajados += $producto->pivot->kilosTrabajados/count($producto->trabajadorSoldador);
                  }
                  else
                  {
                    $kilosTrabajados += $producto->pivot->kilosTrabajados;
                  }
              if($producto->pivot->kilosTrabajados!=0)
                $toneladas += ($producto->tipo->factorKilo*$producto->pivot->kilosTrabajados);
          }
          $fecha=NULL;
          $ultimo_material_gastado = $trabajadorActual->materialWithAtributes()->where('trabajador_id_trabajador','=',$trabajadorActual->idTrabajador)->orderBy('fechaTermino','desc')->get()->first();
          if($ultimo_material_gastado!=NULL)
            $fecha= Carbon::parse($ultimo_material_gastado->pivot->fechaTermino);



          $toneladas /= 1000;
          $datos_trabajador = $usuarioActual->trabajador;
          $ayudantes = $datos_trabajador->ayudante;
          return view('admin.trabajador.soldador_control')
                                  ->with('productos_soldador', $productos_soldador)
                                  ->with('horasHombre', $horasHombre)
                                  ->with('usuario_trabajador', $usuarioActual)
                                  ->with('trabajador', $trabajadorActual)
                                  ->with('kilosTrabajados',$kilosTrabajados)
                                  ->with('gastoAla',$gastoAla)
                                  ->with('gastoGas',$gastoGas)
                                  ->with('fecha',$fecha);
        }
        if($datos_trabajador->tipo == Trabajador::PINTOR_TYPE)
        {
            $date = new Carbon();
            $diasPintado = $datos_trabajador->piezasPintadas()->whereMonth('dia', $date->now()->month)->get();

            $pinturaGastada = 0;
            $superficiePintada = 0;
            $piezasPintadasMes = 0;
            foreach($diasPintado as $dia)
                if($dia->revisado == true)
                {
                    $pinturaGastada += $dia->litrosGastados;
                    $superficiePintada += $dia->areaPintada;
                    $piezasPintadasMes += $dia->piezasPintadas;
                }

            $piezasPintadas = Array();
            $indexPiezasPintadas = 0;
            $dataPintor = $datos_trabajador->piezasPintadas;
            foreach($dataPintor as $data)
            {
                $piezasPintadas[$indexPiezasPintadas][0] = Producto::find($data->producto_id_producto);
                $piezasPintadas[$indexPiezasPintadas][1] = Carbon::parse($data->dia);
                $indexPiezasPintadas++;
            }

            return view('admin.trabajador.pintor_control')
                                    ->with('trabajador', $datos_trabajador)
                                    ->with('usuario_trabajador', $userTrabajador)
                                    ->with('pinturaGastada', $pinturaGastada)
                                    ->with('superficiePintada', $superficiePintada)
                                    ->with('cantPiezasPintadas', $piezasPintadasMes)
                                    ->with('piezasPintadas', $piezasPintadas);
        }
    }

    private function hasConjunto($idConjunto, $array)
    {
        if($array != NULL)
            foreach($array as $conjunto)
                if($conjunto->idConjunto == $idConjunto)
                    return true;
        return false;
    }

    public function addTrabajador()
    {
        return view('admin.trabajador.addTrabajador');
    }

    public function createPassword()
    {
        $pass = User::createPassword(8);
        return $pass;
    }

    public function insertTrabajador(Request $data)
    {
        $newUserTrabajador = new User;
        $newUserTrabajador->email = $data->email;
        $newUserTrabajador->password = bcrypt($data->password);

        if($data->type == 1)
            $newUserTrabajador->type = User::ADMIN_TYPE;
        elseif($data->type == 2)
            $newUserTrabajador->type = User::SUPERVISOR_TYPE;
        elseif($data->type == 0)
            $newUserTrabajador->type = User::DEFAULT_TYPE;
        elseif($data->type == 3)
            $newUserTrabajador->type = User::GERENCIA_TYPE;
        else
            return 'Debe seleccionar el tipo del empleado';

        $verify = User::where('email', '=', $data->email)
                                ->get();

        if(count($verify))
            return "Correo ya registrado en el sistema, ingrese otro correo.";

        if($newUserTrabajador->validateData($data->email) == false)
            return "Tiene que ingresar un email para el usuario.";
        if($newUserTrabajador->validateData($data->password) == false)
            return "Tiene que ingresar o generar una contraseña para el usuario.";

        $newTrabajador = new Trabajador;
        $newTrabajador->nombre = $data->nameTrabajador;
        $newTrabajador->rut = $data->rutTrabajador;
        $newTrabajador->estado = true;
        if($data->class == 0)
          $newTrabajador->tipo = 'Administrador';
        if($data->class == 1)
          $newTrabajador->tipo = 'Operador';
        if($data->class == 2)
          $newTrabajador->tipo = 'Soldador';
        if($data->class == 3)
          $newTrabajador->tipo = 'Gerente';
        if($data->class == 4)
          $newTrabajador->tipo = 'Pintor';

        if($newTrabajador->validateData($data->nameTrabajador) == false)
            return "Tiene que ingresar el nombre para el trabajador.";
        if($newTrabajador->validateData($data->rutTrabajador) == false)
            return "Tiene que ingresar el RUT del trabajador.";
        if((Rut::parse($data->rutTrabajador)->validate()) == false)
            return "RUT no válido.";

        $search = Trabajador::where('rut', $data->rutTrabajador)->first();
        if($search != NULL)
            return 'El RUT ingresado ya está registrado en el sistema.';

        $newUserTrabajador->save();
        $newUserTrabajador->trabajador()->save($newTrabajador);

        return 1;
    }

    public function deleteTrabajador(Request $request)
    {
        $trabajador = Trabajador::find($request->DATA);
        $trabajador->delete();
        $trabajador->user->delete();
        return 1;
    }

    public function equipoTrabajador()
    {
      $usuarioActual = Auth::user();

      if($usuarioActual->trabajador == NULL)
        return redirect()->route('/home');

      $datos_trabajador = $usuarioActual->trabajador;
      $ayudantes = Ayudante::where('lider_id_trabajador')->get();

      return view('trabajador.equipo')
              ->with('ayudantes_almacenados', $ayudantes)
              ->with('trabajador', $datos_trabajador);
    }

    public function productosTrabajador()
    {
        $usuarioActual = Auth::user();

        if($usuarioActual->trabajador == NULL)
            return redirect()->route('/home');

        $datos_trabajador = $usuarioActual->trabajador;
        $productos = $datos_trabajador->productoWithAtributes;

        return view('trabajador.productos_trabajador')
                ->with('productos', $productos)
                ->with('trabajador', $datos_trabajador);
    }

    public function asignarTrabajo($data)
    {
        $trabajador = Trabajador::find($data);
        $productos_almacenados = Producto::where('terminado', '=', 'false')->get();
        $productos = $trabajador->producto;

        $productos_disponibles = null;
        $i = 0;
        $cont = 0;

        $obras = Obra::get();

        foreach($productos_almacenados as $p_saved)
        {
            foreach($productos as $p_asig)
                if($p_saved->idProducto == $p_asig->idProducto)
                    $cont++;
            if($cont == 0)
            {
                $productos_disponibles[$i] = $p_saved;
                $i++;
            }
            $cont = 0;
        }

        return view('admin.trabajador.productos_disponibles')
                ->with('productos_almacenados', $productos_disponibles)
                ->with('idTrabajador', $data)
                ->with('obras', $obras);
    }

    public function terminarProducto(Request $request)
    {
      $materiales = Material::get();
      $usuarioActual = Auth::user();
      $trabajadorActual = $usuarioActual->trabajador;

      $fecha=NULL;
      $ultimo_material_gastado = $trabajadorActual->materialWithAtributes()->where('trabajador_id_trabajador','=',$trabajadorActual->idTrabajador)->orderBy('fechaTermino','desc')->get()->first();
      if($ultimo_material_gastado!=NULL)
        $fecha= Carbon::parse($ultimo_material_gastado->pivot->fechaTermino)->day;
      $fechaActual=now();
      return view('trabajador.terminarProducto')
                ->with('user',$usuarioActual)
                ->with('materiales',$materiales)
                ->with('fecha',$fecha)
                ->with('fechaActual',$fechaActual->day);
    }

    public function setStartTime(Request $request)
    {
        $usuarioActual = Auth::user();

        if($usuarioActual->trabajador == NULL)
            return redirect()->route('/home');

        $conjunto = new ConjuntoProducto;
        $date = new Carbon();

        $data = json_decode($request->DATA);
        $productos = array();

        $datos_trabajador = $usuarioActual->trabajador;

        if(is_array($data))
        {
            $conjunto->fechaInicio = $date->now();
            $conjunto->save();
            $datos_trabajador->conjunto()->attach($conjunto->idConjunto);
            $data_conjunto = $datos_trabajador->conjuntoWithAtributtes()->where('conjunto_id_conjunto', '=', $conjunto->idConjunto)->get()->first();
            $data_conjunto->pivot->fechaComienzo = $date->now();
            $data_conjunto->pivot->save();

            foreach($data as $idProductos)
            {
                $producto = Producto::find($idProductos);
                $producto->conjunto_id_conjunto = $conjunto->idConjunto;

                $productos = $datos_trabajador->productoWithAtributes()->where('producto_id_producto', '=', $idProductos)->get()->first();
                $productos->pivot->fechaComienzo = $date->now();
                $productos->pivot->save();
                $producto->save();
            }
        }
        else
        {
            $productos = $datos_trabajador->productoWithAtributes()->where('producto_id_producto', '=', $data)->get()->first();
            $productos->pivot->fechaComienzo = $date->now();
            $productos->pivot->save();
        }

        return 1;
    }
}
