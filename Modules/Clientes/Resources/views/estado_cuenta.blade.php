<input type="hidden" name="id" id="id" value="{{ \Auth::user()->Departamentos->first()->id }}">
{{ csrf_field() }}
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title"><b><i class="fas fa-address-card"></i> Estado de Cuenta </b></h3>
                    </div>
                </div>
                <div class="card-body table-responsive p-0" >
                    <table class="table text-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Folio</th>
                                <th>Cargo</th>
                                <th>Abono</th>
                                <th>Saldo</th>
                                <th>Fecha Limite</th>
                                <th>Fecha Aplicación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $saldo = 0;
                                $pagos = 0;
                                $recibos = 0;
                            @endphp
                            @foreach ($estado_cuenta as $ec)
                                @if ( $ec->concepto == 'Recibo' )
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime( $ec->fecha )) }}</td>
                                        <td>{{ $ec->concepto }}</td>
                                        <td class="viewRecibo" data-id_recibo="{{ $ec->referencia_completa }}">{{ $ec->referencia_completa }}</td>
                                        <td>$ {{ number_format( round($ec->importe), 2) }}</td>
                                        <td></td>
                                        <td>
                                            @php
                                                $saldo = $saldo + round( $ec->importe );
                                                $recibos = $recibos + round( $ec->importe );
                                            @endphp
                                            $ {{ number_format( $saldo, 2 ) }}
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime( $ec->fecha_aplicacion )) }}</td>
                                        <td></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime( $ec->fecha )) }}</td>
                                        <td>{{ $ec->concepto }}</td>
                                        <td>{{ $ec->referencia_completa }}</td>
                                        <td></td>
                                        <td>$ {{ number_format( round( $ec->importe) , 2) }}</td>
                                        <td>
                                            @php
                                                $saldo = $saldo -  round( $ec->importe) ;
                                                $pagos = $pagos +  round( $ec->importe) ;
                                            @endphp
                                            $ {{ number_format( $saldo, 2 ) }}
                                        </td>
                                        <td></td>
                                        <td>{{ date('d-m-Y', strtotime( $ec->fecha_aplicacion )) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Saldo</th>
                                <th>$ {{ number_format( $recibos, 2 ) }}</th>
                                <th>$ {{ number_format( $pagos, 2 ) }}</th>
                                <th>$ {{ number_format( $saldo, 2 ) }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</div>
