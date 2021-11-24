<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-hand-holding-usd"></i>
            Reporte de Pagos Manual
        </h3>
        <div class="card-tools">

        </div>
    </div>
    <div class="card-body table-responsive table-striped table-sm">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>Fecha</th>
                    <th>Referencia</th>
                    <th>Importe</th>
                    <th>Departamento</th>
                    <th>Edificio</th>
                    <th>Unidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagos as $e)
                    <tr>
                        <td>{{ $e->fecha_pago }}</td>
                        <td>{{ $e->referencia }}</td>
                        <td>$ {{ number_format( $e->importe, 2 ) }}</td>
                        <td>{{ $e->Departamento->first()->numero_departamento }}</td>
                        <td>{{ $e->Departamento->first()->Condominios->nombre }}</td>
                        <td>{{ $e->Departamento->first()->Condominios->Unidades->nombre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
