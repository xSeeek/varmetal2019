@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Cambiar supervisor obra: {{$obra->nombre}}</h3>
      </div>
      <div class="card-body">
        <form id="form_id_cambiar" method="post" action="{!! route('administrador.cambiarSupervisor', ['idObra'=>$obra->idObra]) !!}">
          @csrf
          <div class="form-group">
            <select placeholder="hola"
             data-live-search-placeholder="Puede buscar por nombre o rut"
             data-live-search="true" name="encargado"
             class="selectpicker form-control{{ $errors->has('encargado') ? ' is-invalid' : '' }}">
              <option selected disabled>Seleccione un encargado para esta obra</option>
                @foreach ($encargados as $encargado)
                  <option data-tokens="{{$encargado->nombre}} {{$encargado->rut}}"
                    value="{{$encargado->rut}}">
                    {{$encargado->nombre}}
                @endforeach
              </option>
            </select>
            @if ($errors->has('encargado'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('encargado') }}</strong>
              </span>
            @endif
          </div>

          <div class="form-group">
            <button class="btn btn-success" type="submit">Cambiar</button>
          </div>

      </form>

      </div>
    </div>
  </div>

  <script type="text/javascript">
    $('#form_id_cambiar').submit(function (e, params) {
      var localParams = params || {};
      if (!localParams.send) {
        e.preventDefault();
      }
      confirmMensajeSwal(MSG_INFO, 'Seguro que desea cambiar el supervisor de esta obra?', e);
    });
  </script>
@endsection
