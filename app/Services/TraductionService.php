<?php

namespace App\Services;

use Illuminate\Support\Str;

class TraductionService
{
    public static function getTraduction($language_id)
    {
        
        $textos_es = [
            'visita' => 'Visita',
            'nueva_reserva' => 'Reserva',
            'cliente' => 'Cliente',
            'guia' => 'Guía',
            'codigo' => 'Código',
            'idioma' => 'Idioma',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'personas' => 'Personas',
            'precio' => 'Precio',
            'texto_confirmada' => 'Reserva confirmada',
            'texto_gracias' => 'Gracias por realizar tu reserva. Aquí tienes los detalles de tu pedido'
        ];
        
        $textos_en = [
            'visita' => 'Visit',
            'nueva_reserva' => 'Reservation',
            'cliente' => 'Client',
            'guia' => 'Guide',
            'codigo' => 'Code',
            'idioma' => 'Language',
            'fecha' => 'Date',
            'hora' => 'Time',
            'personas' => 'People',
            'precio' => 'Price',
            'texto_confirmada' => 'Reservation confirmed',
            'texto_gracias' => 'Thank you for making your reservation. Here are the details of your order'
        ];
        
        $textos_fr = [
            'visita' => 'Visite',
            'nueva_reserva' => 'Réservation',
            'cliente' => 'Client',
            'guia' => 'Guide',
            'codigo' => 'Code',
            'idioma' => 'Langue',
            'fecha' => 'Date',
            'hora' => 'Heure',
            'personas' => 'Personnes',
            'precio' => 'Prix',
            'texto_confirmada' => 'Réservation confirmée',
            'texto_gracias' => 'Merci d\'avoir effectué votre réservation. Voici les détails de votre commande'
        ];
        
        $textos_de = [
            'visita' => 'Besuch',
            'nueva_reserva' => 'Reservierung',
            'cliente' => 'Kunde',
            'guia' => 'Führer',
            'codigo' => 'Code',
            'idioma' => 'Sprache',
            'fecha' => 'Datum',
            'hora' => 'Zeit',
            'personas' => 'Personen',
            'precio' => 'Preis',
            'texto_confirmada' => 'Reservierung bestätigt',
            'texto_gracias' => 'Vielen Dank für Ihre Reservierung. Hier sind die Details Ihrer Bestellung'
        ];
        
        $textos_it = [
            'visita' => 'Visita',
            'nueva_reserva' => 'Prenotazione',
            'cliente' => 'Cliente',
            'guia' => 'Guida',
            'codigo' => 'Codice',
            'idioma' => 'Lingua',
            'fecha' => 'Data',
            'hora' => 'Ora',
            'personas' => 'Persone',
            'precio' => 'Prezzo',
            'texto_confirmada' => 'Prenotazione confermata',
            'texto_gracias' => 'Grazie per aver effettuato la tua prenotazione. Ecco i dettagli del tuo ordine'
        ];
        
        $textos_pt = [
            'visita' => 'Visita',
            'nueva_reserva' => 'Reserva',
            'cliente' => 'Cliente',
            'guia' => 'Guia',
            'codigo' => 'Código',
            'idioma' => 'Idioma',
            'fecha' => 'Data',
            'hora' => 'Hora',
            'personas' => 'Pessoas',
            'precio' => 'Preço',
            'texto_confirmada' => 'Reserva confirmada',
            'texto_gracias' => 'Obrigado por fazer a sua reserva. Aqui estão os detalhes do seu pedido'
        ];
        
        $textos_el = [
            'visita' => 'Επίσκεψη',
            'nueva_reserva' => 'Νέα κράτηση',
            'cliente' => 'Πελάτης',
            'guia' => 'Ξεναγός',
            'codigo' => 'Κωδικός',
            'idioma' => 'Γλώσσα',
            'fecha' => 'Ημερομηνία',
            'hora' => 'Ώρα',
            'personas' => 'Άτομα',
            'precio' => 'Τιμή',
            'texto_confirmada' => 'Επιβεβαιωμένη κράτηση',
            'texto_gracias' => 'Ευχαριστούμε που κάνατε την κράτησή σας. Εδώ είναι οι λεπτομέρειες της παραγγελίας σας'
        ];
        
        $textos_pl = [
            'visita' => 'Wizyta',
            'nueva_reserva' => 'Rezerwacja',
            'cliente' => 'Klient',
            'guia' => 'Przewodnik',
            'codigo' => 'Kod',
            'idioma' => 'Język',
            'fecha' => 'Data',
            'hora' => 'Godzina',
            'personas' => 'Osoby',
            'precio' => 'Cena',
            'texto_confirmada' => 'Rezerwacja potwierdzona',
            'texto_gracias' => 'Dziękujemy za dokonanie rezerwacji. Oto szczegóły twojego zamówienia'
        ];
        

        switch($language_id){
            case 1:
                $textostraducidos = $textos_es;
                break;
            case 2:
                $textostraducidos = $textos_en;
                break;
            case 3:
                $textostraducidos = $textos_fr;
                break;
            case 4:
                $textostraducidos = $textos_de;
                break;
            case 5:
                $textostraducidos = $textos_it;
                break;
            case 6:
                $textostraducidos = $textos_pt;
                break;
            case 7:
                $textostraducidos = $textos_el;
                break;
            case 8:
                $textostraducidos = $textos_pl;
                break;
            default:
                $textostraducidos = $textos_es;
                break;

        };


        return $textostraducidos;
    }
}

