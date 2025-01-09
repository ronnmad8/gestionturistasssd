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
            
            @foreach ($data['reservas'] as $reserva)
            <div class="details reservation">
                <h3> {{$reserva['textostraducidos']['texto_confirmada']  }}, {{$data['name']}} </h3>
                <p>{{$reserva['textostraducidos']['texto_gracias']  }} :</p>
                <p><strong>{{$reserva['textostraducidos']['visita']  }}:</strong> {{ $reserva['visita'] ?? '_' }}</p>
                <p><strong>{{$reserva['textostraducidos']['codigo']  }}:</strong> {{ $reserva['codigo'] ?? '_' }}</p>
                <p><strong>{{$reserva['textostraducidos']['idioma']  }}:</strong> {{ $reserva['idioma'] ?? '_' }}</p>
                <p><strong>{{$reserva['textostraducidos']['fecha']  }}:</strong> {{ $reserva['fecha'] ?? '_' }}</p>
                <p><strong>{{$reserva['textostraducidos']['hora']  }}:</strong> {{ $reserva['hora'] ?? '_' }}</p>
                <p><strong>{{$reserva['textostraducidos']['personas']  }}:</strong> {{ $reserva['persons'] ?? '0' }}</p>
                <p><strong>{{$reserva['textostraducidos']['precio']  }}:</strong> {{ $reserva['precio'] ?? '0' }} €</p>
            </div>
            @endforeach

        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Madguides Madrid.
        </div>
    </div>
</body>
</html>
