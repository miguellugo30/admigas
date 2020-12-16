<table class="table">
    <thead class="thead-light">
        <tr>
            <th>Unidad</th>
            <th>Edificio</th>
            <th>Departamento</th>
            <th>Referencia</th>
            <th>Servicio</th>
            <th>Periodo</th>
            <th>Plazos</th>
            <th>Importe</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $e)
            <tr>
                <td>{{ $e->unidad }}</td>
                <td>{{ $e->edificio }}</td>
                <td>{{ $e->numero_departamento }}</td>
                <td>{{ $e->numero_referencia }}</td>
                <td>{{ $e->nombre }}</td>
                <td>{{ $e->periodo }}</td>
                <td>{{ $e->plazo }}</td>
                <td>$ {{ number_format( round($e->costo), 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
