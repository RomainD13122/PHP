<?php
// src\views\booking\my.php

define('ROOT_PATH', realpath(dirname(__DIR__, 3)));

// Vérifie connexion
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: /login?redirect=/my-bookings');
    exit;
}

// Charge le modèle
require_once ROOT_PATH . '/src/models/Booking.php';

use models\Booking;

$userId = $_SESSION['user_id'];

// Instancie et récupère
$booking = new Booking();
$reservations = $booking->getByUser($userId);


?>

<div class="container my-5">
    <h1 class="text-center mb-5" style="color: #ff4d4d; text-shadow: 0 0 12px rgba(255,77,77,0.4);">
        Mes Réservations
    </h1>

    <?php if (empty($reservations)): ?>
        <div class="text-center py-5 bg-dark rounded-3 shadow-lg border border-secondary">
            <h3 class="text-white mb-4">Aucune réservation pour le moment</h3>
            <p class="lead text-secondary mb-4">
                Vous n'avez pas encore réservé de séance.<br>
                Découvrez nos films et réservez votre place !
            </p>
            <a href="/" class="btn btn-primary btn-lg px-5 py-3">
                Voir les films disponibles
            </a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($reservations as $res): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-dark text-white border border-secondary shadow-lg h-100 transition-hover">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-danger mb-3">
                                <?= htmlspecialchars($res['title'] ?? 'Film inconnu') ?>
                            </h5>
                            <p class="card-text mb-2">
                                <strong>Date :</strong> <?= htmlspecialchars($res['date']) ?>
                            </p>
                            <p class="card-text mb-2">
                                <strong>Heure :</strong> <?= htmlspecialchars($res['time']) ?>
                            </p>
                            <p class="card-text mb-2">
                                <strong>Salle :</strong> <?= htmlspecialchars($res['room'] ?? '-') ?>
                            </p>
                            <p class="card-text mb-3">
                                <strong>Places réservées :</strong> <?= htmlspecialchars($res['seats'] ?? 1) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
?>