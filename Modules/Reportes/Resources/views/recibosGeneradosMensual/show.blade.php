<table class="table">
    <thead class="thead-light">
        <tr class="text-center">
            <th>Unidad</th>
            <th>Edificio</th>
            <th>Departamento</th>
            <th>Referencia</th>
            <th>Gasto de Admin</th>
            <th>Adeudo Anterior</th>
            <th>Cargos Adicionales</th>
            <th>Importe</th>
            <th>Total a pagar</th>
            <th>Fecha Recibo</th>
            <th>Fecha Limite Pago</th>
            <th>Pago</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalGA = 0;
            $totalAA = 0;
            $totalCA = 0;
            $totalI = 0;
            $totalTP = 0;
            $totalTPA = 0;
        @endphp
        @foreach ($data as $e)
            <tr>
                <td>{{ $e->unidad }}</td>
                <td>{{ $e->condominio }}</td>
                <td>{{ $e->numero_departamento }}</td>
                <td>{{ $e->referencia }}</td>
                <td>$ {{ number_format($e->gasto_admin,2) }}</td>
                <td>$ {{ number_format($e->adeudo_anterior,2) }}</td>
                <td>$ {{ number_format($e->cargos_adicionales,2) }}</td>
                <td>$ {{ number_format($e->importe,2) }}</td>
                <td>$ {{ number_format($e->total_pagar ,2) }}</td>
                <td>{{ $e->fecha_recibo  }}</td>
                <td>{{ $e->fecha_limite_pago  }}</td>
                <td>$ {{ number_format($e->pago ,2) }}</td>
                @php
                    $totalGA = $totalGA + $e->gasto_admin;
                    $totalAA = $totalAA + $e->adeudo_anterior;
                    $totalCA = $totalCA + $e->cargos_adicionales;
                    $totalI = $totalI + $e->importe;
                    $totalTP = $totalTP + $e->total_pagar;
                    $totalTPA = $totalTPA + $e->pago;
                @endphp
            </tr>
        @endforeach
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th>$ {{ number_format( $totalGA ,2) }}</th>
                <th>$ {{ number_format( $totalAA ,2) }}</th>
                <th>$ {{ number_format( $totalCA ,2) }}</th>
                <th>$ {{ number_format( $totalI ,2) }}</th>
                <th>$ {{ number_format( $totalTP ,2) }}</th>
                <th></th>
                <th></th>
                <th>$ {{ number_format( $totalTPA ,2) }}</th>
            </tr>
    </tbody>
</table>
