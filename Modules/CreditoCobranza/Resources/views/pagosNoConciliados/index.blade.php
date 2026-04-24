<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-desktop"></i>
            Pagos No Conciliados
          </h3>
          <div class="card-tools">
                <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
        </div>
    </div>
    <div class="card-body table-responsive">
        <table id="table-pagos-portal" class="table table-sm">
            <thead class="thead-light">
                <th class="buscar">Fecha Pago</th>
                <th class="buscar">Referencia</th>
                <th class="buscar">Importe</th>
                <th>Autorizacion</th>
                <th>Medio Pago</th>
            </thead>
            <tbody>
                @foreach ($pagos as $pago)
                    <tr>
                        <td>{{ date('d-m-Y', strtotime( $pago->fecha_pago )) }}</td>
                        <td>{{ $pago->referencia }}</td>
                        <td>$ {{ number_format( $pago->importe, 2) }}</td>
                        <td>{{ $pago->autorizacion }}</td>
                        <td>{{ $pago->medio_pago }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="thead-light">
                <th>Fecha Pago</th>
                <th>Referencia</th>
                <th>Importe</th>
                <th>Autorizacion</th>
                <th>Medio Pago</th>
            </tfoot>
        </table>
    </div>
</div>

<script>
    $(function() {

        $('#table-pagos-portal thead tr th.buscar').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
        });

        var table = $('#table-pagos-portal').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                        },
                        "ordering": false,
                        "searching": false,
                        "lengthChange": false,
                        "pageLength": 20
                    });
        $('#table-pagos-portal thead tr th.buscar').on( 'keyup', "input",function () {
            table.column( $(this).parent().index() )
                .search( this.value )
                .draw();
        } );
    });
    </script>
