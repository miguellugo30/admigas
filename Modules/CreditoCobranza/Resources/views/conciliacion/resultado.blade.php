<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-hand-holding-usd"></i>
            Conciliación Bancaria
          </h3>
          <div class="card-tools">

        </div>
    </div>
    <div class="card-body table-responsive">
        <div class="alert alert-success" role="alert">
            Pagos conciliados correctamente: {{ $data->where('conciliado', 1)->count() }}
        </div>
        <table class="table table-striped table-sm mb-3">
            <thead class="thead-light">
                <tr>
                    <th>Fecha</th>
                    <th>Forma de Pago</th>
                    <th>Pago CIE</th>
                    <th>Referencia</th>
                    <th>Concepto</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @if ( $data->where('conciliado', 1)->count() > 0 )
                    @foreach ($data->where('conciliado', 1) as $item)
                        <tr>
                            <td>{{ $item['fecha'] }}</td>
                            <td>{{ $item['tipo_pago'] }}</td>
                            <td>{{ $item['guia_cie'] }}</td>
                            <td>{{ $item['referencia'] }}</td>
                            <td>{{ $item['concepto'] }}</td>
                            <td>$ {{ number_format( $item['importe'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="6">No hay informacion</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="alert alert-warning" role="alert">
            Pagos no conciliados: {{ $data->where('conciliado', 0)->count() }}
        </div>
        <table class="table table-striped table-sm  mb-3">
            <thead class="thead-light">
                <tr>
                    <th>Fecha</th>
                    <th>Forma de Pago</th>
                    <th>Pago CIE</th>
                    <th>Referencia</th>
                    <th>Concepto</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @if ( $data->where('conciliado', 0)->count() > 0 )
                    @foreach ($data->where('conciliado', 0) as $item)
                        <tr>
                            <td>{{ $item['fecha'] }}</td>
                            <td>{{ $item['tipo_pago'] }}</td>
                            <td>{{ $item['guia_cie'] }}</td>
                            <td>{{ $item['referencia'] }}</td>
                            <td>{{ $item['concepto'] }}</td>
                            <td>$ {{ number_format( $item['importe'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="6">No hay informacion</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="alert alert-danger" role="alert">
            Pagos no ingresados al sistema: {{ $data->where('conciliado', 2)->count() }}
        </div>
        <table class="table table-striped table-sm  mb-3">
            <thead class="thead-light">
                <tr>
                    <th>Fecha</th>
                    <th>Forma de Pago</th>
                    <th>Pago CIE</th>
                    <th>Referencia</th>
                    <th>Concepto</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @if ( $data->where('conciliado', 2)->count() > 0 )
                    @foreach ($data->where('conciliado', 2) as $item)
                        <tr>
                            <td>{{ $item['fecha'] }}</td>
                            <td>{{ $item['tipo_pago'] }}</td>
                            <td>{{ $item['guia_cie'] }}</td>
                            <td>{{ $item['referencia'] }}</td>
                            <td>{{ $item['concepto'] }}</td>
                            <td>$ {{ number_format( $item['importe'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="6">No hay informacion</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
