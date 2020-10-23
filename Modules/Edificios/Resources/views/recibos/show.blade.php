<style>
    .fondo{
        position: relative;
        display: inline-block;
        width: 100%;
        height: 810px;
    }
    @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
    }
    img{
        margin-top: 65px;
    }
    .contenido{
        position: absolute;
        top: 1px;
        left: 1px;
        width: 50%;
        height: 792px;
        background-image: url("../../storage/recibo/recibo_2G-v2.png")
    }
    .row{
        width: 100%;
    }
    .invoice{
        /*background-color: red;*/
        height: 430px;
    }
    .invoice-info{
        width: 100%;
        height: 140px;
        margin: 5px;
        /* background-color: yellow; */
        overflow: hidden;
    }
    .col-sm-6{
        width: 50%;
        height: auto;
        padding: 10px;
        float:left;
    }
    .col-sm-3{
        width: 20%;
        height: auto;
        padding: 10px;
        float:left;
    }
    .folio{
        text-align: right;
        margin-top: 128px;
        margin-right: 40px;
        /* background-color: blue; */
    }
    .data-client{
        width: 100%;
        margin-top: 23px;
        margin-left: 130px;
        font-size: 14px;
    }
   .data-client .address{
       margin-left: 18px;
       margin-top: -14px;
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
    .cie{
        margin-top: -5px;
        margin-left: 45px;
    }
    .referencia{
        margin-left: 119px;
    }
    .invoice-col-detail-legends{
        font-size: 10px;
        margin-top: -5px;
        margin-left: 165px;
        font-weight: bold;
    }
    .invoice-col-detail-digist{
        font-size: 10px;
        margin-left: -150px;
    }
    .invoice-info-history{
        padding-left: 20px;
        margin-top: 30px;
        margin-left: 40px;
        font-size: 12px;
    }
    .invoice-info-history .invoice-col-total{
        margin-left: 25px;
    }

</style>

@foreach ($recibos as $recibo)
    <div class="fondo">

    @php
        $historico = \DB::select('call SP_consumo_recibos( '.$recibo->admigas_departamentos_id.' );');
    @endphp

        <div class="contenido">
            <div class="invoice p-3 mb-3">
                <div class="col-12 folio">
                    <h5>{{-- $recibo->clave_recibo --}}</h5>
                </div>
                <div class="col data-client">
                    <p>{{ $recibo->condomino }}</p>
                    <p class="address">{{ $recibo->calle." Num. Ext.: ".$recibo->numero_exterior." Num. Int.:".$recibo->numero_interior }}</p>
                    <p class="address">{{ $recibo->colonia.", ".$recibo->delegacion.", C.P.:".$recibo->cp }}</p>
                    <legend class="cie">{{ $cie }}</legend>  <legend class="referencia">{{ $recibo->referencia }}</legend>
                </div>
                <div class="col data-total-pay">
                    <br>
                    <p><b>{{ "$ ".number_format( ( $recibo->total_pagar ),2 )  }}</b></p>
                    <p><b>{{ date('d-m-Y', strtotime($recibo->fecha_limite_pago)) }}</b></p>
                    <p><b>{{ date('d-m-Y', strtotime($recibo->fecha_lectura_anterior))." -- ".date('d-m-Y', strtotime($recibo->fecha_lectura_actual)) }}</b></p>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col-detail-legends">
                        <legend>Lectura inicial</legend><br>
                        <legend>Lectura final</legend><br>
                        <legend>Consumo en M3</legend><br>
                        <legend>Consumo en litros</legend><br>
                        <legend>Consumo del mes</legend><br>
                        <legend>Saldo a favor</legend><br>
                        <legend>Adeudo pendiente</legend><br>
                        <legend>Cargos del periodo</legend><br>
                        <legend>Cuota de Admin.</legend>
                    </div>

                    <div class="col-sm-6 invoice-col-detail-digist">
                        <legend>{{ number_format( $recibo->lectura_anterior, 2 ) }}</legend><br>
                        <legend>{{ number_format( $recibo->lectura_actual, 2 ) }}</legend><br>
                        <legend>{{ number_format( ( $recibo->lectura_actual - $recibo->lectura_anterior ), 2 ) }}</legend><br>
                        <legend>{{$recibo->importe }}</legend><br>
                        <legend>$ {{ number_format( $recibo->importe , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( 0 , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->adeduo_anterior , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->cargos_adicionales , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->gasto_admin , 2 ) }}</legend>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row invoice-info-history">
                    <div class="col-sm-3 invoice-col">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>{{  date('d-m-Y', strtotime($historico[$i]->fecha_recibo)) }}</legend><br>
                        @endfor
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>{{ number_format( $historico[$i]->litros, 2) }}</legend><br>
                        @endfor
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>$ {{ number_format( $historico[$i]->precio_litro, 2) }}</legend><br>
                        @endfor
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col-total">
                        @for ($i = 0; $i < count( $historico ); $i++)
                            <legend>$ {{ number_format( $historico[$i]->total_pagar,2 ) }}</legend><br>
                        @endfor
                    </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>

        </div>

    </div>

    @endforeach

