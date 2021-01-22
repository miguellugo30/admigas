<table class="table">
    <thead class="thead-light">
        <tr>
            <th>Unidad</th>
            <th>Edificio</th>
            <th>Departamento</th>
            <th>Lectura Inicial</th>
            <th>Lectura Final</th>
            <th>M 3</th>
            <th>Litros</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($data as $e)
            <tr>
                <td>{{ $e->unidad }}</td>
                <td>{{ $e->condominio }}</td>
                <td>{{ $e->numero_departamento }}</td>
                <td>{{ $e->lectura_anterior }}</td>
                <td>{{ $e->lectura_actual }}</td>
                <td>{{ number_format( $e->m3, 2 ) }}</td>
                @php
                    $total = $total + ( $e->m3 * $e->factor ) * $e->precio_litro;
                @endphp
                <td>{{ number_format( ( $e->m3 * $e->factor ) * $e->precio_litro, 2) }}</td>
            </tr>
        @endforeach
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th>{{ number_format( $total, 2) }}</th>
            </tr>
    </tbody>
</table>
