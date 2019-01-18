@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Agregar nueva obra</h3>
      </div>
      <div class="card-body">
        <form id="form_id" action="{!! route('administrador.insertObra') !!}" method="post">
          @csrf
          <div class="form-group">
            <input type="text" name="name" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nombre de la obra" autofocus required>
            @if ($errors->has('name'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <select placeholder="hola"
             data-live-search-placeholder="Puede buscar por nombre o rut"
             data-live-search="true" name="encargado"
             class="selectpicker form-control{{ $errors->has('encargado') ? ' is-invalid' : '' }}">
              <option selected disabled>Seleccione un encargado para esta obra</option>
              @foreach ($encargados as $encargado)
                <option data-tokens="{{$encargado->trabajador->nombre}} {{$encargado->trabajador->rut}}"
                  value="{{$encargado->trabajador->rut}}">
                  {{$encargado->trabajador->nombre}}
                </option>
              @endforeach
            </select>
            @if ($errors->has('encargado'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('encargado') }}</strong>
              </span>
            @endif
          </div>
          <div class="form-group">
            <button type="submit" id="btn_submit" class="btn btn-success btn-lg btn-block">Agregar nueva obra</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $(".selectpicker").each(function () {
        $(this).selectpicker();
      });
    });

    $('#form_id').submit(function (e, params) {
      var localParams = params || {};
      if (!localParams.send) {
        e.preventDefault();
      }
      confirmMensajeSwal(MSG_INFO, 'Seguro que desea agregar esta obra?', e);
    });
  </script>
@endsection
