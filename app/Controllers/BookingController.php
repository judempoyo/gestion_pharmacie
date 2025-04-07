<?php
namespace App\Controllers;

use App\Models\Booking;
use App\Core\ViewRenderer;

class BookingController
{
    use ViewRenderer;
    protected $basePath;

    public function __construct()
    {
        $this->basePath = '/Projets/KongB/public';
    }

    public function index()
    {
        $bookings = Booking::all();
        $this->render('app', 'bookings/index', [
            'bookings' => $bookings,
            'title' => 'Liste des réservations'
        ]);
    }

    public function create()
    {
        $this->render('app', 'bookings/create', [
            'title' => 'Créer une réservation'
        ]);
    }

    public function store()
    {
        $data = [
            'customer_name' => trim($_POST['customer_name']),
            'customer_phone' => trim($_POST['customer_phone']),
            'session_type' => trim($_POST['session_type']),
            'start_time' => trim($_POST['start_time']),
            'end_time' => trim($_POST['end_time']),
            'status' => 'en attente'
        ];

        if (empty($data['customer_name'])) {
            http_response_code(400);
            echo "Le nom du client est obligatoire";
            return;
        }
        if (empty($data['customer_phone'])) {
            http_response_code(400);
            echo "Le numéro de téléphone du client est obligatoire";
            return;
        }
        if (empty($data['session_type'])) {
            http_response_code(400);
            echo "Le type de session est obligatoire";
            return;
        }
        if (empty($data['start_time'])) {
            http_response_code(400);
            echo "L'heure de début est obligatoire";
            return;
        }
        if (empty($data['end_time'])) {
            http_response_code(400);
            echo "L'heure de fin est obligatoire";
            return;
        }

        Booking::create($data);
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Réservation créée avec succès'
        ];
        header('Location: ' . $this->basePath . '/booking');
    }

    public function edit($id)
    {
        $booking = Booking::where('id', $id)->first();
        if (!$booking) {
            http_response_code(404);
            echo "Réservation non trouvée";
            return;
        }

        $this->render('app', 'bookings/edit', [
            'booking' => $booking,
            'title' => 'Modifier la réservation'
        ]);
    }

    public function update($id)
    {
        $booking = Booking::where('id', $id)->first();

        if (!$booking) {
            http_response_code(404);
            echo "Réservation non trouvée";
            return;
        }

        $data = [
            'customer_name' => trim($_POST['customer_name']),
            'customer_phone' => trim($_POST['customer_phone']),
            'session_type' => trim($_POST['session_type']),
            'start_time' => trim($_POST['start_time']),
            'end_time' => trim($_POST['end_time']),
            'status' => trim($_POST['status'])
        ];

        if (empty($data['customer_name'])) {
            http_response_code(400);
            echo "Le nom du client est obligatoire";
            return;
        }
        if (empty($data['customer_phone'])) {
            http_response_code(400);
            echo "Le numéro de téléphone du client est obligatoire";
            return;
        }
        if (empty($data['session_type'])) {
            http_response_code(400);
            echo "Le type de session est obligatoire";
            return;
        }
        if (empty($data['start_time'])) {
            http_response_code(400);
            echo "L'heure de début est obligatoire";
            return;
        }
        if (empty($data['end_time'])) {
            http_response_code(400);
            echo "L'heure de fin est obligatoire";
            return;
        }

        $booking->update($data);
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Réservation modifiée avec succès'
        ];
        header('Location: ' . $this->basePath . '/booking');
 }

    public function delete($id)
    {
        $booking = Booking::where('id', $id)->first();
        
        if (!$booking) {
            http_response_code(404);
            echo "Réservation non trouvée";
            return;
        }

        $booking->delete();
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Réservation supprimée avec succès'
        ];
        header('Location: ' . $this->basePath . '/booking');
    }
}