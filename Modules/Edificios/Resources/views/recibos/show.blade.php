<style>
    .fondo{
        position: relative;
        display: inline-block;
    }
    @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
    }
    .contenido{
        position: absolute;
    top: 10px;
    left: 10px;
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
    .folio{
        text-align: right;
        margin-top: 52px;
        margin-right: 50px;
        /* background-color: blue; */
    }
    .data-client{
        width: 100%;
        margin-top: -35px;
        margin-left: 90px;
        font-size: 14px;
    }
   .data-client .address{
       margin-left: 18px;
       margin-top: -14px;
   }
    .data-total-pay{
        text-align: center;
        margin-left: 175px;
        margin-top: -19px;
        height: 150px;
    }
    .data-total-pay p{
        margin-bottom: -7px;
    }
    .cie{
        margin-top: -10px;
        margin-left: 45px;
    }
    .referencia{
        margin-left: 119px;
    }
    .invoice-col-detail-legends{
        font-size: 10px;
        margin-left: 150px;
        font-weight: bold;
    }
    .invoice-col-detail-digist{
        font-size: 10px;
        margin-left: -150px;
    }


</style>
<div class="fondo">

    @foreach ($recibos as $recibo)

        <img src="{{'data:image/jpeg;base64,' . base64_encode($url_recibo)}}" alt="" width="560" height="750">
        <div class="contenido">
            <div class="invoice p-3 mb-3">
                <div class="col-12 folio">
                    <h4>{{ $recibo->clave_recibo }}</h4>
                </div>
                <div class="col data-client">
                    <p>{{ $recibo->condomino }}</p>
                    <p class="address">{{ $recibo->calle." Num. Ext.: ".$recibo->numero_exterior." Num. Int.:".$recibo->numero_interior }}</p>
                    <p class="address">{{ $recibo->colonia.", ".$recibo->delegacion.", C.P.:".$recibo->cp }}</p>
                    <legend class="cie">{{ $cie }}</legend>  <legend class="referencia">{{ $recibo->referencia }}</legend>
                </div>
                <div class="col data-total-pay">
                    <br>
                    <p><b>{{ "$ ".number_format( ( $recibo->importe + $recibo->adeduo_anterior + $recibo->cargos_adicionales + $recibo->gasto_admin ),2 )  }}</b></p>
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
                        <legend>{{ $recibo->lectura_final }}</legend><br>
                        <legend>$ {{ number_format( $recibo->importe , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( 0 , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->adeduo_anterior , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->cargos_adicionales , 2 ) }}</legend><br>
                        <legend>$ {{ number_format( $recibo->gasto_admin , 2 ) }}</legend>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        METODOS DE PAGO
                        <address>
                        <strong>Admin, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                        Email: info@almasaeedstudio.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6 invoice-col">
                        <b>TOTAL A PAGAR</b><br>
                        <br>
                        <b>Order ID:</b> 4F3S8J<br>
                        <b>Payment Due:</b> 2/22/2014<br>
                        <b>Account:</b> 968-34567
                    </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>

        </div>


    @endforeach

</div>
