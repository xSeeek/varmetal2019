@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">Varmetal</div>
              <div class="card-body">
                @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
                @endif
                <table id="tableGerencia" style="width:90%; margin:20px;" align="center">
                  <thead>
                    <tr>
                        <th>OT:</th>
                        <th>Kgr. Totales</th>
                        <th>Kgr. Actuales</th>
                        <th>Horas Hombre</th>
                        <th>Horas en Pausa</th>
                        <th>Horas en SetUp</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($obras as $key => $obra)
                    <tr id="id_obra{{ $obra->idObra }}">
                      <td scope="col"></td>
                      <td scope="col"></td>
                      <td scope="col"></td>
                      <td scope="col"></td>
                      <td scope="col"></td>
                      <td scope="col"></td>
                    </tr>
                    @endforeach
                  </tbody>
              </div>
            </div>
            </br>
            <div class="card">
              <a class="btn btn-outline-success my-2 my-sm-0" href="{{url('/descargarObras')}}" role="button" style="cursor: pointer;">Descargar</a>
            </div>
        </div>
    </div>
</div>
@endsection
