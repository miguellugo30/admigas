<style>
 @page {
    margin: 0px 0px 0px 0px !important;
    padding: 0px 0px 0px 0px !important;
    font-size: 16px;
    font-family: Arial, Helvetica, sans-serif;
}

    body{
        background-image: url( {{\Storage::url("/\recibo/\recibo_2G-v2.png") }} )
    }

    .page-break {
        page-break-after: always;
    }
    .cols {
        width: 100%;
        overflow: auto;
        position: absolute;
        left: 0;
        top: 0;
    }
    .cols div {
        flex: 1;
    }
    .col1 {
        float: left;
        width: 100%;
        clear: both;
    }

    .data-client{
        /*width: 100%;*/
        margin-top: 100px;
        margin-left: 110px;
        font-size: 14px;
    }
    .cie{
        margin-top: 15px;
        margin-left: 45px;
    }
    .referencia{
        margin-left: 119px;
    }
    .data-client .nombre, .data-client .address{
        margin-left: 18px;
    }
    .data-client .address{
       margin-top: -15px;
    }
    .data-total-pay{
        text-align: center;
        margin-left: 145px;
        margin-top: -19px;
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
        height: 100px;
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
        margin-top: 60px;
        font-size: 12px;
    }
    </style>
    @php
        $historico = \DB::select('call SP_consumo_recibos( '.$recibos->admigas_departamentos_id.' );');
    @endphp
    <img src="{{'data:image/jpeg;base64,' . base64_encode($url_recibo)}}" alt="" width="560" height="750">
    <div class="cols">
        <div class="col1">
            <div class="col data-client">
                <p class="nombre">{{ $recibos->condomino }}</p>
                <p class="address">{{ $recibos->calle." Num. Ext.: ".$recibos->numero_exterior." Num. Int.:".$recibos->numero_interior }}</p>
                <p class="address">{{ $recibos->colonia.", ".$recibos->delegacion.", C.P.:".$recibos->cp }}</p>
                <legend class="cie">{{ $cie }}</legend>  <legend class="referencia">{{ $recibos->referencia }}</legend>
            </div>
            <div class="col data-total-pay">
                <br>
                <p><b>{{ "$ ".number_format( ( $recibos->total_pagar ),2 )  }}</b></p>
                <p><b>{{ date('d-m-Y', strtotime($recibos->fecha_limite_pago)) }}</b></p>
                <p><b>{{ date('d-m-Y', strtotime($recibos->fecha_lectura_anterior))." -- ".date('d-m-Y', strtotime($recibos->fecha_lectura_actual)) }}</b></p>
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
                        <legend>{{ number_format( $recibos->lectura_anterior, 2 ) }}</legend><br>
                        <legend>{{ number_format( $recibos->lectura_actual, 2 ) }}</legend><br>
                        <legend>{{ number_format( ( $recibos->lectura_actual - $recibos->lectura_anterior ), 2 ) }}</legend><br>
                        <legend>{{$recibos->importe }}</legend><br>
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
                        <legend>$ {{ number_format( $recibos->importe , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( 0 , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibos->adeduo_anterior , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibos->cargos_adicionales , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibos->gasto_admin , 2 ) }}</legend>
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
                        <h3>SIN FOTO</h3>
                </div>
                <div class="der" style="text-align: center;">
                        <h3>SIN FOTO</h3>
                </div>
            </div>
        </div>
    </div>
