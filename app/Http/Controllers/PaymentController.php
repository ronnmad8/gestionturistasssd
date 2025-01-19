<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
    $amount = $request->input('amount'); // Cantidad enviada desde Angular
    $key = '1z3H904Q1I1Qaa7m';
    $merchantCode = '175651959';
    $terminal = '1';
    $order = time(); // Número único de pedido
    $currency = '978';
    $urlOK = route('redsys.success');
    $urlKO = route('redsys.failure');
    $merchantURL = route('redsys.callback');
    $productDescription = 'Reserva en MadGuides';

    $parameters = base64_encode(json_encode([
        'DS_MERCHANT_AMOUNT' => $amount * 100, // En céntimos
        'DS_MERCHANT_ORDER' => str_pad($order, 12, "0", STR_PAD_LEFT),
        'DS_MERCHANT_MERCHANTCODE' => $merchantCode,
        'DS_MERCHANT_CURRENCY' => $currency,
        'DS_MERCHANT_TRANSACTIONTYPE' => '0',
        'DS_MERCHANT_TERMINAL' => $terminal,
        'DS_MERCHANT_MERCHANTURL' => $merchantURL,
        'DS_MERCHANT_URLOK' => $urlOK,
        'DS_MERCHANT_URLKO' => $urlKO,
        'DS_MERCHANT_PRODUCTDESCRIPTION' => $productDescription,
    ]));

    $keyDecoded = base64_decode($key);
    $keyEncrypted = openssl_encrypt($order, 'DES-EDE3', $keyDecoded, OPENSSL_RAW_DATA);
    $signature = base64_encode(hash_hmac('sha256', $parameters, $keyEncrypted, true));

    return response()->json([
        'parameters' => $parameters,
        'signature' => $signature,
        'url' => 'https://sis-t.redsys.es:25443/sis/realizarPago',
    ]);
    }

    public function callback(Request $request)
    {
        $key = '1z3H904Q1I1Qaa7m';
        $keyDecoded = base64_decode($key);

        $data = $request->input('Ds_MerchantParameters');
        $receivedSignature = $request->input('Ds_Signature');

        $decodedData = json_decode(base64_decode($data), true);
        $order = $decodedData['Ds_Order'];

        // Validar firma
        $keyEncrypted = openssl_encrypt($order, 'DES-EDE3', $keyDecoded, OPENSSL_RAW_DATA);
        $expectedSignature = base64_encode(hash_hmac('sha256', $data, $keyEncrypted, true));

        if ($receivedSignature === $expectedSignature) {
            $response = $decodedData['Ds_Response'];

            if ((int) $response < 100) {
                // Pago exitoso
                return response()->json(['status' => 'success']);
            } else {
                // Pago rechazado
                return response()->json(['status' => 'failure']);
            }
        }

        return response()->json(['status' => 'invalid_signature'], 400);
    }

    public function success()
    {
        return view('success');
    }

    public function failure()
    {
        return view('failure');
    }
}