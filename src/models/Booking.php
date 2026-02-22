<?php
namespace models;

use config\Database;

class Booking {
    private $db;
    public function __construct() { $this->db = Database::get(); }

    public function create($userId, $showtimeId, $seats) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
                SELECT (total_seats - COALESCE(SUM(seats),0)) AS avail
                FROM showtimes s
                LEFT JOIN bookings b ON b.showtime_id = s.id
                WHERE s.id = ?
                FOR UPDATE
            ");
            $stmt->execute([$showtimeId]);
            $row = $stmt->fetch();

            if ($row['avail'] < $seats) {
                $this->db->rollBack();
                return false;
            }

            $stmt = $this->db->prepare("INSERT INTO bookings (user_id, showtime_id, seats) VALUES (?,?,?)");
            $stmt->execute([$userId, $showtimeId, $seats]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT b.*, m.title, s.date, s.time, s.room
            FROM bookings b
            JOIN showtimes s ON s.id = b.showtime_id
            JOIN movies m ON m.id = s.movie_id
            WHERE b.user_id = ?
            ORDER BY s.date DESC, s.time
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}