<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-hand-holding-usd"></i>
            Reporte de Antiguedad de Saldos
        </h3>
        <div class="card-tools">

        </div>
    </div>
    <div class="card-body table-responsive table-striped table-sm">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>Unidad</th>
                    <th>Edificio</th>
                    <th>Departamento</th>
                    <th>Referencia</th>
                    <th>Fecha limite de pago</th>
                    <th>Al corriente</th>
                    <th>1 - 30 Dias</th>
                    <th>31 - 60 Dias</th>
                    <th>61 - 90 Dias</th>
                    <th>Mas 90 Dias</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $e)
                    @if ( round( $e->total_recibos - $e->total_pagos ) > 0 )
                        <tr>
                            <td>{{ $e->unidad }}</td>
                            <td>{{ $e->edificio }}</td>
                            <td class="text-center">{{ $e->numero_departamento }}</td>
                            <td>{{ $e->numero_referencia }}</td>
                            <td>{{ $e->fecha_limite_pago }}</td>
                            <td>
                                @if ( $e->diferencia_dias == 0 )
                                    {{ number_format( round($e->total_recibos - $e->total_pagos), 2) }}
                                @endif
                            </td>
                            <td>
                                @if ( ( $e->diferencia_dias > 1 ) && ( $e->diferencia_dias <= 30 ) )
                                    {{ number_format( round($e->total_recibos - $e->total_pagos), 2) }}
                                @endif
                            </td>
                            <td>
                                @if ( ( $e->diferencia_dias > 31 ) && ( $e->diferencia_dias <= 60 ) )
                                    {{ number_format( round($e->total_recibos - $e->total_pagos), 2) }}
                                @endif
                            </td>
                            <td>
                                @if ( ( $e->diferencia_dias > 61 ) && ( $e->diferencia_dias <= 90 ) )
                                    {{ number_format( round($e->total_recibos - $e->total_pagos), 2) }}
                                @endif
                            </td>
                            <td>
                                @if ( $e->diferencia_dias > 91 )
                                    {{ number_format( round($e->total_recibos - $e->total_pagos), 2) }}
                                @endif
                            </td>
                            <td>
                                @if ( ($e->total_recibos - $e->total_pagos) < 0 )
                                <p class="text-danger"> {{ number_format( round($e->total_recibos - $e->total_pagos), 2) }}</p>
                                @else
                                    {{ number_format( round($e->total_recibos - $e->total_pagos), 2) }}
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

