@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                  <div class="card-header">Varmetal</div>
                  <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(($obras != NULL) && (count($obras)))
                        <table id="tablaGerencia" style="width:100%" align="center">
                          <thead>
                                <tr>
                                    <th>OT</th>
                                    <th>Kg Totales</th>
                                    <th>Kg Realizados</th>
                                    <th>Kg Restantes</th>
                                    <th>Horas Hombre </th>
                                    <th>Horas en Pausa</th>
                                    <th>Horas en SetUp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obras as $obra)
                                <tr id="id_obra{{ $obra[0] }}">
                                    <td scope="col" align="center">{{ $obra[1] }}</td>
                                    <td scope="col" align="center">{{ $obra[2] }}</td>
                                    <td scope="col" align="center">{{ $obra[3] }}</td>
                                    <td scope="col" align="center">{{ $obra[4] }}</td>
                                    <td scope="col" align="center">{{ $obra[5] }}</td>
                                    <td scope="col" align="center">{{ $obra[6] }}</td>
                                    <td scope="col" align="center">{{ $obra[7] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <br>
                            <h4 align="center">No hay OT registradas en el sistema.</h4>
                        <br>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function formatTable()
    {
        var table = $('#tablaGerencia').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: 'Varmetal',
                    filename: 'Reporte Varmetal {{now()}}',
                },
                {
                    extend: 'excelHtml5',
                    messageTop: 'Solicitado por {{Auth::user()->trabajador->nombre}}',
                    message: 'Correo: {{Auth::user()->email}}',
                    message: 'Fecha de solicitud del reporte: {{now()}}.',
                    customize: function ( xlsx ){
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row c[r]', sheet).attr( 's', '25' );
                    },
                    title: 'Reporte Varmetal',
                    filename: 'Reporte Varmetal {{now()}}'
                },
                {
                    extend: 'pdfHtml5',
                    pageSize: 'LETTER',
                    filename: 'Reporte Varmetal {{now()}}',
                    title: '',
                    customize: function ( doc ) {
                        doc.content.splice( 1, 0, {
                            margin: [ 0, 0, 0, 12 ],
                            alignment: 'center',
                            fit: [125, 125],
                            image: 'data:image/png;base64,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'
                        } );
                    },
                message: 'Solicitado por {{Auth::user()->trabajador->nombre}}\nCorreo: {{Auth::user()->email}}\nFecha de solicitud del reporte: {{now()}}.'
                }
            ],
            "language":{
                "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "scrollX": true,
       });
       $(function () {
           $('[data-toggle="tooltip"]').tooltip();
       });
    }
</script>
@endsection
