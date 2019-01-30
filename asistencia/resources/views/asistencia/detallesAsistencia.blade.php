@extends('layouts.navbar')

@section('main')
  <div class="container mt-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-tittle">Detalles de la asistencia de {{$trabajador->nombre}}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="rut">Rut:</label>
              <input type="text" name="rut" value="{{$trabajador->rut}}" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" value="{{$trabajador->nombre}}" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="fecha">Fecha</label>
              <input type="text" name="fecha" value="{{Date::parse($asistencia->created_at)->format('l j M Y H:i:s A')}}" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="tipo">Tipo</label>
              <input type="text" name="tipo" value="{{$asistencia->tipo}}" class="form-control" disabled>
            </div>
          </div>
          <figure class="figure">
            <img id="img" src="{{ Storage::disk('asistencia')->url($trabajador->rut.'/'.$asistencia->image) }}" class="figure-img img-fluid rounded">
            <figcaption class="figure-caption text-right">Imagen tomada el día en que se marcó la asistencia.</figcaption>
          </figure>
        </div>
      </div>
    </div>
  </div>


  <script type="text/javascript">
    function rotarImagen() {
      var value = 0
      $("#img").rotate({
        bind:
        {
          click: function(){
            value +=90;
            $(this).rotate({ animateTo:value})
          }
        }
      });
    }
  </script>
@endsection
