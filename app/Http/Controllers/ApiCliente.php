<?php

namespace App\Http\Controllers;

use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\Payer;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

use Illuminate\Http\Request;
use DB;
use MercadoPago;
/**
 * Modelos
 */
use App\User;
use App\AdmigasRecibos;

class ApiCliente extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        \Log::info('Datos recibidos en el pago:', $request->all());

        /*
        SDK::setAccessToken('TEST-1495019703472479-041121-203a86ae6a9b55d25a59af3e25756145-290931909');
        /*
        $payment = new Payment();
        $payment->transaction_amount = (float)$request->amount;
        $payment->token = $request->token;
        $payment->description = $request->description;
        $payment->payment_method_id = $request->payment_method_id;
        $payment->payer = [
            "email" => $request->email
        ];

        $payment->save();


       // Crear el cliente de pagos
       $client = new PaymentClient();

       // Crear el pago
       $payment = $client->create([
           'transaction_amount' => (float) $request->amount,
           'token' => $request->token,
           'description' => $request->description,
           'installments' => 1,
           'payment_method_id' => $request->payment_method_id,
           'payer' => [
               'email' => $request->email
           ]
       ]);

        \Log::info('Datos despues realizar  el pago:', $payment->all());

        if ($payment->status == "approved") {
            return response()->json(["status" => "success", "message" => "Pago exitoso"]);
        } else {
            return response()->json(["status" => "error", "message" => $payment->status_detail]);
        }
        */

        try {
            SDK::setAccessToken('TEST-1495019703472479-041121-203a86ae6a9b55d25a59af3e25756145-290931909');

            $payment = new Payment();
            $payment->transaction_amount = (float)$request->amount;
            $payment->token = $request->token;
            $payment->description = $request->description;
            $payment->installments = 1;
            $payment->payment_method_id = $request->payment_method_id;

            $payment->payer = [
                'email' => $request->email
            ];

            // Guardar pago
            $payment->save();

            \Log::info('Datos despues realizar  el pago:', $payment->all());

            return response()->json([
                'status' => $payment->status,
                'status_detail' => $payment->status_detail,
                'id' => $payment->id,
                'error' => $payment->error ?? 'Sin errores en el SDK'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en el pago:', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Excepción: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $departoId = $user->Departamentos->first()->id;

        $dataCliente = DB::select("call SP_DataCliente('".$departoId."')");

        $dataRecibo = AdmigasRecibos::where('admigas_departamentos_id', $departoId)
                                    ->select('clave_recibo', 'total_pagar', 'fecha_limite_pago', 'admigas_departamentos_id')
                                    ->active()
                                    ->orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();

        $consumoReciente = DB::select("call SP_consumo_recibos('".$departoId."')");

        $data = [
            'cliente' => $dataCliente,
            'recibo' => $dataRecibo,
            'consumo' => $consumoReciente
        ];

        return response()->json([
            'message' => '',
            'data' => $data,
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function estado_cuenta($id)  {

        $dataEdoCuenta = DB::select("call SP_estado_cuenta_cliente('".$id."')");

        return response()->json([
            'message' => '',
            'data' => $dataEdoCuenta,
            'success' => true
        ]);


    }


    function webhook()  {
        return response()->json([
            'message' => '',
            'data' => 'webhook',
            'success' => true
        ]);
    }
}
