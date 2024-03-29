<table class="table">
    <thead class="thead-light">
        <tr>
            <th>Unidad</th>
            <th>Edificio</th>
            <th>Departamento</th>
            <th>Referencia</th>
            <th>Gasto Admin</th>
            <th>Importe</th>
            <th>Cargos Adicionales</th>
            <th>Total Recibos</th>
            <th>Total Pagos</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $e)
            <tr>
                <td>{{ $e->unidad }}</td>
                <td>{{ $e->edificio }}</td>
                <td>{{ $e->numero_departamento }}</td>
                <td>{{ $e->numero_referencia }}</td>
                <td>{{ number_format( round($e->total_gasto_admin), 2) }}</td>
                <td>{{ number_format( round($e->total_importe), 2) }}</td>
                <td>{{ number_format( round($e->total_cargos), 2) }}</td>
                <td>{{ number_format( round($e->total_recibos), 2) }}</td>
                <td>{{ number_format( round($e->total_pagos), 2) }}</td>
                <td>
                    @if ( ( round($e->total_recibos) - round($e->total_pagos)) < 0 )
                    <p class="text-danger"> {{ number_format( round($e->total_recibos) - round($e->total_pagos), 2) }}</p>
                    @else
                        {{ number_format( round($e->total_recibos) - round($e->total_pagos), 2) }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
