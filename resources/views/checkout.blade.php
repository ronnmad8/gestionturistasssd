<!DOCTYPE html>
<html lang="en">
<head>
    <title>Redirigiendo al TPV...</title>
</head>
<body>
    <h1>Redirigiendo al TPV...</h1>
    <form id="tpv-form" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST">
        <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1">
        <input type="hidden" name="Ds_MerchantParameters" value="{{ $parameters }}">
        <input type="hidden" name="Ds_Signature" value="{{ $signature }}">
        <button type="submit">Pagar</button>
    </form>
    <script>
        document.getElementById('tpv-form').submit();
    </script>
</body>
</html>