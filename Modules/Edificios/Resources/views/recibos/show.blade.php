<style>
 @page {
    margin: 0px 0px 0px 0px !important;
    padding: 0px 0px 0px 0px !important;
    font-size: 16px;
    font-family: Arial, Helvetica, sans-serif;
}
</style>

@foreach ($recibos as $recibo)
    <style>
    .page-break {
        page-break-after: always;
    }
    .cols {
        width: 100%;
        overflow: auto;
    }
    .cols div {
        flex: 1;
    }
    .col1 {
        float: left;
        width: 50%;
        clear: both;
    }
    .col2 {
        width: 50%;
        float: right;
    }
    .data-client{
        /*width: 100%;*/
        margin-top: 150px;
        margin-left: 120px;
        font-size: 14px;
    }
    .cie{
        margin-top: 12px;
        margin-left: 45px;
    }
    .referencia{
        margin-left: 119px;
    }
    .data-client .nombre, .data-client .address{
        margin-left: 18px;
    }
    .data-client .address{
       margin-top: -10px;
	font-size: 11px;
    }
    .data-total-pay{
        text-align: center;
        margin-left: 145px;
        margin-top: -20px;
        height: 150px;
    }
    .data-total-pay p{
        margin-bottom: -7px;
    }
    .invoice-info-page{
        font-size: 10px;
        margin-top: 20px;
    }
    .row{
        width: 100%;
        height: 50px;
        overflow: auto;
    }
    .row div {
        flex: 1;
    }
    .izq{
        float: left;
        width: 50%;
        clear: both;
    }
    .izq div {
        flex: 1;
    }
    .der{
        width: 50%;
        float: right;
    }
    .izq .hijo-izq, .der .hijo-izq{
        float: left;
        width: 50%;
        margin-left: 120px;
        clear: both;
    }
    .izq .hijo-der, .der .hijo-der{
        width: 30%;
        float: right;
        margin: auto;
        margin-left: 160px;
    }
    .izq .hijo-izq{
        font-weight: bold;
    }
    .izq .hijo-der{
         margin-left: 220px;
     }
    .der .hijo-izq{
        margin-left: 20px !important;
        font-weight: bold;
    }
    .der .hijo-der{
        margin-left: 120px;
    }

    .invoice-col-detail-legends{
        font-size: 10px;
    }
    .invoice-info-history{
        margin-top: 100px;
        font-size: 12px;
	    height: 120px;
    }
    .invoice-info-history .izq .hijo-izq{
       text-align: left;
       margin-left: 25px;
    }
    .invoice-info-history .izq .hijo-der{
       text-align: left;
       margin-left: 145px;
    }
    .invoice-info-history .der .hijo-der{
       text-align: left;
       margin-left: 145px;
    }
    .invoice-info-images .izq{
        margin-left: -30px;
    }
    .invoice-info-images .der{
        margin-left: 285px;
    }
    </style>
    @php
        $historico = \DB::select('call SP_consumo_recibos( '.$recibo->admigas_departamentos_id.' );');
	$saldo_favor = \DB::select('call SP_saldo_favor_depto( "'.$recibo->referencia.'", "'.$recibo->fecha_recibo.'" );');

	$saldo_favor = ( round( $saldo_favor[0]->total_recibos ) -  round( $saldo_favor[0]->total_pagos ) ) - round($recibo->adeudo_anterior);

    @endphp
    <div class="cols">
        <div class="col1">
            <div class="col data-client">
                <p class="nombre">{{ $recibo->condomino }}</p>
                <p class="address">{{ $recibo->calle." Num. Ext.: ".$recibo->numero_exterior." Num. Int.:".$recibo->numero_interior }}</p>
                <p class="address">{{ $recibo->colonia.", ".$recibo->delegacion.", C.P.:".$recibo->cp }}</p>
                <legend class="cie">{{ $cie }}</legend>  <legend class="referencia">{{ $recibo->referencia }}</legend>
            </div>
            <div class="col data-total-pay">
                <br>
                <p><b>{{ "$ ".number_format( ( $recibo->total_pagar + $saldo_favor ),2 )  }}</b></p>
                <p><b>{{ date('d-m-Y', strtotime($recibo->fecha_limite_pago)) }}</b></p>
                <p><b>{{ date('d-m-Y', strtotime($recibo->fecha_lectura_anterior))." -- ".date('d-m-Y', strtotime($recibo->fecha_lectura_actual)) }}</b></p>
            </div>
            <div class="row invoice-info-page">
                <div class="izq">
                    <div class="hijo-izq">
                        <legend>Lectura inicial</legend><br>
                        <legend>Lectura final</legend><br>
                        <legend>Consumo en M3</legend><br>
                        <legend>Consumo en litros</legend><br>
                    </div>
                    <div class="hijo-der">
                        <legend>{{ number_format( $recibo->lectura_anterior, 2 ) }}</legend><br>
                        <legend>{{ number_format( $recibo->lectura_actual, 2 ) }}</legend><br>
                        <legend>{{ number_format( ( $recibo->lectura_actual - $recibo->lectura_anterior ), 2 ) }}</legend><br>
                        <legend>{{ number_format( ( $recibo->lectura_actual - $recibo->lectura_anterior ) * $recibo->Condominios->factor, 2 ) }}</legend><br>
                    </div>
                </div>
                <div class="der">
                    <div class="hijo-izq">
                        <legend>Consumo del mes</legend><br>
                        <legend>Saldo a favor</legend><br>
                        <legend>Adeudo pendiente</legend><br>
                        <legend>Cargos del periodo</legend><br>
                        <legend>Cuota de Admin.</legend>
                    </div>
                    <div class="hijo-der">
                        <legend>$ {{ number_format( $recibo->importe , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $saldo_favor , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->adeudo_anterior , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->cargos_adicionales , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->gasto_admin , 2 ) }}</legend>
                    </div>
                </div>
            </div>
            <div class="row invoice-info-history">
                <div class="izq">
                    <div class="hijo-izq">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>{{  date('d-m-Y', strtotime($historico[$i]->fecha_recibo)) }}</legend><br>
                        @endfor
                    </div>
                    <div class="hijo-der">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>{{ number_format( $historico[$i]->litros, 2) }}</legend><br>
                        @endfor
                    </div>
                </div>
                <div class="der">
                    <div class="hijo-izq">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>$ {{ number_format( $historico[$i]->precio_litro, 2) }}</legend><br>
                        @endfor
                    </div>
                    <div class="hijo-der">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>$ {{ number_format( $historico[$i]->total_pagar,2 ) }}</legend><br>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="row invoice-info-images">
                <div class="izq" style="text-align: center;">
                    @if ( \Storage::exists( $empresa_id.'/'.$recibo->admigas_condominios_id.'/'.date('m-Y', strtotime($recibo->fecha_lectura_anterior)).'/'.$recibo->admigas_departamentos_id."_".$recibo->numero_departamento.".jpeg" ) )
                        <img src="{{ public_path()."/storage/".$empresa_id.'/'.$recibo->admigas_condominios_id.'/'.date('m-Y', strtotime($recibo->fecha_lectura_anterior)).'/'.$recibo->admigas_departamentos_id."_".$recibo->numero_departamento.".jpeg" }}" alt="" width="100px">
                    @else
                        <h3>SIN FOTO</h3>
                    @endif
                </div>
                <div class="der" style="text-align: center;">
                    <img src="{{ public_path()."/storage/".$empresa_id.'/'.$recibo->admigas_condominios_id.'/'.date('m-Y', strtotime($recibo->fecha_lectura_actual)).'/'.$recibo->admigas_departamentos_id."_".$recibo->numero_departamento.".jpeg" }}" alt="" width="100px">
                </div>
            </div>
        </div>
        <div class="col2">
            <div class="col data-client">
                <p class="nombre">{{ $recibo->condomino }}</p>
                <p class="address">{{ $recibo->calle." Num. Ext.: ".$recibo->numero_exterior." Num. Int.:".$recibo->numero_interior }}</p>
                <p class="address">{{ $recibo->colonia.", ".$recibo->delegacion.", C.P.:".$recibo->cp }}</p>
                <legend class="cie">{{ $cie }}</legend>  <legend class="referencia">{{ $recibo->referencia }}</legend>
            </div>
            <div class="col data-total-pay">
                <br>
                <p><b>{{ "$ ".number_format( ( $recibo->total_pagar + $saldo_favor ),2 )  }}</b></p>
                <p><b>{{ date('d-m-Y', strtotime($recibo->fecha_limite_pago)) }}</b></p>
                <p><b>{{ date('d-m-Y', strtotime($recibo->fecha_lectura_anterior))." -- ".date('d-m-Y', strtotime($recibo->fecha_lectura_actual)) }}</b></p>
            </div>
            <div class="row invoice-info-page">
                <div class="izq">
                    <div class="hijo-izq">
                        <legend>Lectura inicial</legend><br>
                        <legend>Lectura final</legend><br>
                        <legend>Consumo en M3</legend><br>
                        <legend>Consumo en litros</legend><br>
                    </div>
                    <div class="hijo-der">
                        <legend>{{ number_format( $recibo->lectura_anterior, 2 ) }}</legend><br>
                        <legend>{{ number_format( $recibo->lectura_actual, 2 ) }}</legend><br>
                        <legend>{{ number_format( ( $recibo->lectura_actual - $recibo->lectura_anterior ), 2 ) }}</legend><br>
                        <legend>{{ number_format( ( $recibo->lectura_actual - $recibo->lectura_anterior ) * $recibo->Condominios->factor, 2 ) }}</legend><br>
                    </div>
                </div>
                <div class="der">
                    <div class="hijo-izq">
                        <legend>Consumo del mes</legend><br>
                        <legend>Saldo a favor</legend><br>
                        <legend>Adeudo pendiente</legend><br>
                        <legend>Cargos del periodo</legend><br>
                        <legend>Cuota de Admin.</legend>
                    </div>
                    <div class="hijo-der">
                        <legend>$ {{ number_format( $recibo->importe , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $saldo_favor , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->adeudo_anterior , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->cargos_adicionales , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->gasto_admin , 2 ) }}</legend>
                    </div>
                </div>
            </div>
            <div class="row invoice-info-history">
                <div class="izq">
                    <div class="hijo-izq">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>{{  date('d-m-Y', strtotime($historico[$i]->fecha_recibo)) }}</legend><br>
                        @endfor
                    </div>
                    <div class="hijo-der">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>{{ number_format( $historico[$i]->litros, 2) }} L</legend><br>
                        @endfor
                    </div>
                </div>
                <div class="der">
                    <div class="hijo-izq">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>$ {{ number_format( $historico[$i]->precio_litro, 2) }}</legend><br>
                        @endfor
                    </div>
                    <div class="hijo-der">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>$ {{ number_format( $historico[$i]->total_pagar,2 ) }}</legend><br>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="row invoice-info-images">
                <div class="izq" style="text-align: center;">
                    @if ( \Storage::exists( $empresa_id.'/'.$recibo->admigas_condominios_id.'/'.date('m-Y', strtotime($recibo->fecha_lectura_anterior)).'/'.$recibo->admigas_departamentos_id."_".$recibo->numero_departamento.".jpeg" ) )
                        <img src="{{ public_path()."/storage/".$empresa_id.'/'.$recibo->admigas_condominios_id.'/'.date('m-Y', strtotime($recibo->fecha_lectura_anterior)).'/'.$recibo->admigas_departamentos_id."_".$recibo->numero_departamento.".jpeg" }}" alt="" width="100px">
                    @else
                        <h3>SIN FOTO</h3>
                    @endif
                </div>
                <div class="der" style="text-align: center;">
                    <img src="{{ public_path()."/storage/".$empresa_id.'/'.$recibo->admigas_condominios_id.'/'.date('m-Y', strtotime($recibo->fecha_lectura_actual)).'/'.$recibo->admigas_departamentos_id."_".$recibo->numero_departamento.".jpeg" }}" alt="" width="100px">
                </div>
            </div>
        </div>
    </div>
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
