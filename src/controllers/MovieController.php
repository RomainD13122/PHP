<?php
namespace controllers;

use models\Movie;
use models\Showtime;

class MovieController extends BaseController {

    public function list() {
        $movies = (new Movie())->getAll();
        $this->render('movies/list', compact('movies'));
    }

    public function detail($id) {
        $movie = (new Movie())->getById($id);
        if (!$movie) {
            $this->render('errors/404', ['message' => 'Film introuvable']);
            exit;
        }
        $showtimes = (new Showtime())->getByMovie($id);
        $this->render('movies/detail', compact('movie', 'showtimes'));
    }
}