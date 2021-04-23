<style>
    @page {
       margin: 0px 0px 0px 0px !important;
       padding: 0px 0px 0px 0px !important;
       font-size: 14px;
       font-family: Arial, Helvetica, sans-serif;
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
           margin-top: 105px;
	   margin-bottom: 5px;
           margin-left: 110px;
           font-size: 12px;
       }
       .cie{
           margin-top: 12px;
           margin-left: 45px;
       }
       .referencia{
           margin-left: 135px;
       }
       .data-client .nombre, .data-client .address{
           margin-left: 18px;
       }
       .data-client .address{
          margin-top: -10px;
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
           margin-top: 55px;
           margin-bottom: 30px;
           font-size: 12px;
       }
	.invoice-info-history .izq .hijo-izq{
       text-align: left;
       margin-left: 35px;
    }
    .invoice-info-history .izq .hijo-der{
       text-align: left;
       margin-left: 175px;
    }
    .invoice-info-history .der .hijo-der{
       text-align: left;
       margin-left: 145px;
    }
       </style>
       @php
            $historico = \DB::select('call SP_consumo_recibos( '.$recibos->admigas_departamentos_id.' );');
	        $saldo_favor = \DB::select('call SP_saldo_favor_depto( "'.$recibos->referencia.'", "'.$recibos->fecha_recibo.'" );');

            $saldo_favor = ( round( $saldo_favor[0]->total_recibos) - round( $saldo_favor[0]->total_pagos ) ) - round($recibos->adeudo_anterior);

            if ($saldo_favor > 0) {
                $saldo_favor = 0;
            }

       @endphp
	<img src="{{'data:image/jpeg;base64,' . base64_encode($url_recibo)}}" alt="" width="560" height="750">
       <!--img src="https://administradora.2gadmin.com.mx/storage/recibo/recibo_2G-v2.png" alt="imagen_recibo" width="560" height="750"-->
       <div class="cols">
           <div class="col1">
               <div class="col data-client">
                   <p class="nombre">{{ $recibos->condomino }}</p>
                   @if ($recibo->admigas_condominios_id == 7 || $recibo->admigas_condominios_id == 8)
                        <p class="address">{{ $recibos->calle." ".$recibos->condominio." Num. Ext.: ".$recibos->numero_exterior." Num. Int.:".$recibos->numero_interior }}</p>
                    @else
                        <p class="address">{{ $recibos->calle." Num. Ext.: ".$recibos->numero_exterior." Num. Int.:".$recibos->numero_interior }}</p>
                    @endif
                   <p class="address">{{ $recibos->colonia.", ".$recibos->delegacion.", C.P.:".$recibos->cp }}</p>
                   <legend class="cie">{{ $cie }}</legend>  <legend class="referencia">{{ $recibos->referencia }}</legend>
               </div>
               <div class="col data-total-pay">
                   <br>
                   <p><b>{{ "$ ".number_format( round( $recibos->total_pagar + $saldo_favor ),2 )  }}</b></p>
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
                           <legend>{{ number_format( ( $recibos->lectura_actual - $recibos->lectura_anterior ) * $recibos->Condominios->factor, 2 ) }}</legend><br>
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
                           <legend>$ {{ number_format( $saldo_favor , 2 ) }}</legend><br>
                           <legend>$ {{ number_format( $recibos->adeudo_anterior , 2 ) }}</legend><br>
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
                        @if ( \Storage::exists( $empresa_id.'/'.$recibos->admigas_condominios_id.'/'.date('m-Y', strtotime($recibos->fecha_lectura_anterior)).'/'.$recibos->admigas_departamentos_id."_".$recibos->numero_departamento.".jpeg" ) )
				<img src="{{'data:image/jpeg;base64,' . base64_encode($foto_anterior)}}" alt="" width="100px" >
                        @else
                            <h3>SIN FOTO</h3>
                        @endif
                    </div>
                    <div class="der" style="text-align: center;">

                        @if ( \Storage::exists( $empresa_id.'/'.$recibos->admigas_condominios_id.'/'.date('m-Y', strtotime($recibos->fecha_lectura_actual)).'/'.$recibos->admigas_departamentos_id."_".$recibos->numero_departamento.".jpeg" ) )
				<img src="{{'data:image/jpeg;base64,' . base64_encode($foto_actual)}}" alt="" width="100px" >
			@else
				<h3>SIN FOTO</h3>
			@endif
                    </div>
                </div>
           </div>
       </div>
