<?php
namespace controllers;

use models\Showtime;
use models\Booking;

class BookingController extends BaseController {

    public function form($showtimeId) {
        $this->requireAuth();

        $showtimeModel = new Showtime();
        $showtime = $showtimeModel->getOne($showtimeId);

        if (!$showtime) {
            $this->render('errors/404', ['message' => 'Séance introuvable']);
            exit;
        }

        $available = $showtimeModel->getAvailableSeats($showtimeId);

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seats = max(1, min(6, (int)($_POST['seats'] ?? 1)));

            if ((new Booking())->create($_SESSION['user_id'], $showtimeId, $seats)) {
                $this->flash('success', "Réservation de $seats place(s) effectuée !");
                header('Location: /my-bookings');
                exit;
            }
            $error = "Plus assez de places disponibles";
            $available = $showtimeModel->getAvailableSeats($showtimeId);
        }

        $this->render('booking/form', compact('showtime', 'available', 'error'));
    }

    public function my() {
        $this->requireAuth();
        $bookings = (new Booking())->getByUser($_SESSION['user_id']);
        $this->render('booking/my', compact('bookings'));
    }
}