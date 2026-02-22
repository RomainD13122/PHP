<?php
namespace models;

use config\Database;

class Showtime {
    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    public function getByMovie($movieId) {
        $stmt = $this->db->prepare("
            SELECT s.*, 
                   (s.total_seats - COALESCE(SUM(b.seats), 0)) AS available
            FROM showtimes s
            LEFT JOIN bookings b ON b.showtime_id = s.id
            WHERE s.movie_id = ?
            GROUP BY s.id
            ORDER BY s.date, s.time
        ");
        $stmt->execute([$movieId]);
        return $stmt->fetchAll();
    }

    public function getAvailableSeats($showtimeId) {
        $stmt = $this->db->prepare("
            SELECT total_seats - COALESCE(SUM(seats), 0) AS available
            FROM showtimes s
            LEFT JOIN bookings b ON b.showtime_id = s.id
            WHERE s.id = ?
            GROUP BY s.id
        ");
        $stmt->execute([$showtimeId]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (int)$row['available'] : 0;
    }

    public function getOne($id) {
        $stmt = $this->db->prepare("SELECT * FROM showtimes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($movieId, $date, $time, $room, $totalSeats, $price) {
        $stmt = $this->db->prepare("
            INSERT INTO showtimes (movie_id, date, time, room, total_seats, price)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$movieId, $date, $time, $room, $totalSeats, $price]);
        return $this->db->lastInsertId();
    }

    public function update($id, $date, $time, $room, $totalSeats, $price) {
        $stmt = $this->db->prepare("
            UPDATE showtimes 
            SET date = ?, time = ?, room = ?, total_seats = ?, price = ?
            WHERE id = ?
        ");
        $stmt->execute([$date, $time, $room, $totalSeats, $price, $id]);
    }
}