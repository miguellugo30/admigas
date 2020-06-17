<table class="table table-sm  table-bordered table-striped">
    <thead>
        <tr class="text-center">
            <th>Servicios</th>
            <th>Costo</th>
            <th>Mensualidades</th>
            <th>Aplicadas</th>
            <th>Eliminar</th>
    </thead>
    <tbody>
        @foreach ($cargos as $cargo)
            <tr id="tr_{{ $cargo->id }}">
                <td>{{ $cargo->Servicios->nombre }}</td>
                <td class="text-right">$ {{ number_format( $cargo->Servicios->costo, 2 ) }}</td>
                <td class="text-center">{{ $cargo->plazo }}</td>
                <td class="text-center">{{ $cargo->periodo }}</td>
                <td class="text-center">
                    @if ( $cargo->periodo == 0 )
                        <button type="button" data-id-cargo="{{ $cargo->id }}" class="btn btn-danger btn-sm deleteCargoAdicional"><i class="fas fa-minus"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
