<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PaymentsController extends apiController {


    public function initpayment( Request $request ) {
        $order = now()->format('YmdHis') . mt_rand(1000, 9999);
        $order = str_pad( substr($order, -12), 12, '0', STR_PAD_LEFT );
    
        $amount = intval(floatval($request->input('amount', 0))*100);
        if ($amount <= 0) {
            return response()->json(['error' => 'El importe debe ser mayor a 0'], 400);
        }

        $key = $_ENV['REDSYS_MERCHANT_SECRET'];
        $merchantCode = $_ENV['REDSYS_MERCHANT_ID'];
        $terminal = $_ENV['REDSYS_MERCHANT_TERMINAL'];

        $currency = '978'; // Codigo de moneda euros
        $urlOK = "https://gestion.endesys.org/payments_success";
        $urlKO = "https://gestion.endesys.org/payments_failure";
        $merchantURL = "https://gestion.endesys.org/payments_callback";

        $orderedParams = [
            'DS_MERCHANT_AMOUNT' => $amount, // En céntimos
            'DS_MERCHANT_ORDER' => $order,
            'DS_MERCHANT_MERCHANTCODE' => $merchantCode,
            'DS_MERCHANT_CURRENCY' => $currency,
            'DS_MERCHANT_TRANSACTIONTYPE' => '0',
            'DS_MERCHANT_TERMINAL' => $terminal,
            'DS_MERCHANT_MERCHANTURL' => $merchantURL,
            'DS_MERCHANT_URLOK' => $urlOK,
            'DS_MERCHANT_URLKO' => $urlKO
        ];

        //$orderedParams = $this->orderRedsysParams($parameters);
        $jsonParams = json_encode($orderedParams, JSON_UNESCAPED_SLASHES);
        $parameters = base64_encode($jsonParams);
        $keyDecoded = base64_decode( $key );
        $signature = base64_encode( hash_hmac( 'sha256', $parameters, $keyDecoded, true ) );
        return response()->json( [
            'parameters' => $parameters,
            'signature' => $signature,
            'url' => $_ENV['REDSYS_URL'],
            'order' => $order,
            'amount' => $amount,
            'currency' => $currency,
            'terminal' => $terminal,
            'merchantCode' => $merchantCode,
            'urlOK' => $urlOK,
            'urlKO' => $urlKO,
            'merchantURL' => $merchantURL,

        ] );
    }

    private function orderRedsysParams(array $params): array {
        ksort($params);
        return $params;
    }

    public function success() {
        return view( 'success' );
    }

    public function failure() {
        return view( 'failure' );
    }
}