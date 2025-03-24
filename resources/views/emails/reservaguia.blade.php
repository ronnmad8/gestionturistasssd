<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Reserva Confirmada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-header {
            background: #efefef;
            color: #656565;
            padding: 10px 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
        }
        .email-footer {
            background: #f8f9fa;
            text-align: center;
            padding: 10px 20px;
            font-size: 12px;
            color: #666;
        }
        .logo {
            max-width: 150px;
            margin: 0 auto 20px;
            display: block;
        }
        .details {
            margin-top: 10px;
            padding: 10px;
            background: #f1f1f1;
            border-radius: 5px;
        }
        .details p {
            margin: 5px 0;
        }
        .reservation {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .reservation:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://madguidesmadrid.com/assets/images/logo-madguides.svg" alt="Madguides Logo" class="logo">
        </div>
        <div class="email-body">
            
            <div class="details reservation">

                <p><strong>{{$data['textostraducidos']['visita']  }}:</strong> {{ $data['visita'] ?? '_' }}</p>
                <p><strong>{{$data['textostraducidos']['codigo']  }}:</strong> {{ $data['codigo'] ?? '_' }}</p>
                <p><strong>{{$data['textostraducidos']['idioma']  }}:</strong> {{ $data['idioma'] ?? '_' }}</p>
                <p><strong>{{$data['textostraducidos']['fecha']  }}:</strong> {{ $data['fecha'] ?? '_' }}</p>
                <p><strong>{{$data['textostraducidos']['hora']  }}:</strong> {{ $data['hora'] ?? '_' }}</p>
                <p><strong>{{$data['textostraducidos']['personas']  }}:</strong> {{ $data['persons'] ?? '0' }}</p>
                <p><a href="{{$data['puntoencuentro']}}" > {{$data['puntoencuentrotext'] ?? '_'}}  </a></p>
            
                @foreach ($data['reservas'] as $reserva)
                    <h3> {{ $reserva['cliente']['name'] ?? '_' }} </h3>
                    <p><strong> {{$reserva['persons'] ?? '0' }}</strong></p>
                    <p><strong> {{$reserva['uuid'] ?? '_' }}</strong></p>
                    <p><strong> {{$reserva['pedidoi_d'] ?? '_' }}</strong></p>
                    <br>
                @endforeach

            </div>

        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Madguides Madrid.
        </div>
    </div>
</body>
</html>
