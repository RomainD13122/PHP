<?php
namespace controllers;

use models\Movie;
use models\Showtime;

class AdminController extends BaseController {

    public function __construct() {
        $this->requireAuth();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $this->flash('danger', "Accès réservé aux administrateurs.");
            header('Location: /');
            exit;
        }
    }

    public function movies() {
        $movies = (new Movie())->getAll();
        $this->render('admin/movies', compact('movies'));
    }

    public function addMovie() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($title)) {
                $error = "Le titre est obligatoire";
            } else {
                (new Movie())->create($title, $description);
                $this->flash('success', "Film ajouté !");
                header('Location: /admin/movies');
                exit;
            }
        }
        $this->render('admin/add_movie', compact('error'));
    }

    public function editMovie($id) {
        $movieModel = new Movie();
        $movie = $movieModel->getById($id);

        if (!$movie) {
            $this->render('errors/404', ['message' => 'Film introuvable']);
            exit;
        }

        $showtimeModel = new Showtime();
        $showtimes = $showtimeModel->getByMovie($id);

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_movie'])) {
                $title = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');

                if (empty($title)) {
                    $error = "Le titre est obligatoire";
                } else {
                    $movieModel->update($id, $title, $description);
                    $this->flash('success', "Film modifié !");
                    header("Location: /admin/movies/edit/$id");
                    exit;
                }
            } elseif (isset($_POST['update_showtime'])) {
                $showtimeId = (int)$_POST['showtime_id'];
                $date = $_POST['date'] ?? '';
                $time = $_POST['time'] ?? '';
                $room = trim($_POST['room'] ?? '');
                $totalSeats = (int)($_POST['total_seats'] ?? 100);
                $price = (float)($_POST['price'] ?? 10.00);

                if (empty($date) || empty($time)) {
                    $error = "Date et heure obligatoires";
                } elseif ($totalSeats < 1) {
                    $error = "Nombre de places invalide";
                } elseif ($price < 0) {
                    $error = "Prix invalide";
                } else {
                    $showtimeModel->update($showtimeId, $date, $time, $room, $totalSeats, $price);
                    $this->flash('success', "Séance modifiée !");
                    header("Location: /admin/movies/edit/$id");
                    exit;
                }
            } elseif (isset($_POST['add_showtime'])) {
                $date = $_POST['date'] ?? '';
                $time = $_POST['time'] ?? '';
                $room = trim($_POST['room'] ?? '');
                $totalSeats = (int)($_POST['total_seats'] ?? 100);
                $price = (float)($_POST['price'] ?? 10.00);

                if (empty($date) || empty($time)) {
                    $error = "Date et heure obligatoires";
                } elseif ($totalSeats < 1) {
                    $error = "Nombre de places invalide";
                } elseif ($price < 0) {
                    $error = "Prix invalide";
                } else {
                    $showtimeModel->create($id, $date, $time, $room, $totalSeats, $price);
                    $this->flash('success', "Séance ajoutée !");
                    header("Location: /admin/movies/edit/$id");
                    exit;
                }
            }
        }

        $this->render('admin/edit_movie', compact('movie', 'showtimes', 'error'));
    }

    public function delMovie($id) {
        $id = (int)$id;
        if ($id <= 0) {
            $this->flash('danger', "ID invalide.");
            header('Location: /admin/movies');
            exit;
        }

        $movieModel = new Movie();
        $movie = $movieModel->getById($id);

        if (!$movie) {
            $this->flash('danger', "Film introuvable.");
            header('Location: /admin/movies');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
            $movieModel->delete($id);
            $this->flash('success', "Le film a été supprimé.");
            header('Location: /admin/movies');
            exit;
        }

        $this->render('admin/del_movie', compact('movie', 'id'));
    }
}