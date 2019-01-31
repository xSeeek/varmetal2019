<?php

namespace Varmetal\Http\Controllers;

use Illuminate\Http\Request;
use Varmetal\Trabajador;
use Varmetal\User;
use Varmetal\Producto;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Varmetal\Ayudante;
use Varmetal\ConjuntoProducto;

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

      $productos_trabajador = $trabajadorActual->productoWithAtributes;
      foreach($productos_trabajador as $producto)
      {
          //if($producto->fechaFin != NULL)
            if((Carbon::parse($producto->fechaFin)->format('m')) == $date->now()->format('m'))
                $kilosTrabajados += $producto->pivot->kilosTrabajados;
          if($producto->pivot->kilosTrabajados!=0)
            $toneladas += ($producto->tipo->factorKilo*$producto->pivot->kilosTrabajados);
      }
      $toneladas /= 1000;
      $datos_trabajador = $usuarioActual->trabajador;
      $ayudantes = $datos_trabajador->ayudante;

      if($trabajadorActual->tipo=="Operador")
      {
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
        return view('soldador')
                  ->with('user', $usuarioActual)
                  ->with('trabajador', $trabajadorActual)
                  ->with('ayudantes_almacenados', $ayudantes);
      }

    }

    public function adminTrabajadores($type)
    {
        $trabajadores_registrados = Trabajador::join('users', 'users_id_user', 'id')->where('type', 'like', $type)->get();
        return view('admin.administracion_trabajadores')
                  ->with('trabajadores_almacenados', $trabajadores_registrados);
    }

    public function convertToHoursMins($time)
    {
        $format = '%d horas con %d minutos';

        if ($time < 1) {
            return;
        }
        $hours = floor($time/60);
        $minutes = ($time%60);
        return sprintf($format, $hours, $minutes);
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
        $date = new Carbon();

        $productos_trabajador = $datos_trabajador->productoWithAtributes;
        foreach($productos_trabajador as $producto)
        {
            if($producto->fechaFin != NULL)
              if((Carbon::parse($producto->fechaFin)->format('m')) == $date->now()->format('m'))
                  $kilosTrabajados += $producto->pivot->kilosTrabajados;
            if($producto->pivot->kilosTrabajados!=0)
              $toneladas += ($producto->tipo->factorKilo*$producto->pivot->kilosTrabajados);

              if($producto->pausa !=NULL)
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
        }
        $toneladas /= 1000;
        $bono = $toneladas*5500;

        if($datos_trabajador->cargo=='M1')
          $sueldo = 385000;

        $tiempoPausa = $this->convertToHoursMins($tiempoPausa);
        $tiempoSetUp = $this->convertToHoursMins($tiempoSetUp);

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
                                ->with('productosCompletos', $productosCompletos);
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

        if($newTrabajador->validateData($data->nameTrabajador) == false)
            return "Tiene que ingresar el nombre para el trabajador.";
        if($newTrabajador->validateData($data->rutTrabajador) == false)
            return "Tiene que ingresar el RUT del trabajador.";
        if((Rut::parse($data->rutTrabajador)->validate()) == false)
            return "RUT no válido.";

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
                ->with('idTrabajador', $data);
    }

    public function terminarProducto()
    {
      return view('trabajador.terminarProducto');
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
