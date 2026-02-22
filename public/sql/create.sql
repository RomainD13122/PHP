-- 1. Création de la base (à exécuter si la base n'existe pas encore)
CREATE DATABASE IF NOT EXISTS cinema_min 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

-- 2. Sélection de la base
USE cinema_min;

-- 3. Table users
CREATE TABLE users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50) NOT NULL UNIQUE,
    email       VARCHAR(120) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Table movies
CREATE TABLE movies (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(150) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Table showtimes (séances)
CREATE TABLE showtimes (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    movie_id    INT NOT NULL,
    date        DATE NOT NULL,
    time        TIME NOT NULL,
    room        VARCHAR(20) DEFAULT NULL,
    total_seats INT DEFAULT 120,
    
    FOREIGN KEY (movie_id) REFERENCES movies(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Table bookings (réservations)
CREATE TABLE bookings (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    showtime_id INT NOT NULL,
    seats       TINYINT UNSIGNED NOT NULL DEFAULT 1,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id)    REFERENCES users(id)
        ON DELETE CASCADE,
    FOREIGN KEY (showtime_id) REFERENCES showtimes(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================================================    
-- Données de test (facultatif mais très utile pour la démo)
-- =============================================================================

INSERT INTO movies (title, description) VALUES
('Dune: Part Two', 'Suite de l''épopée de science-fiction'),
('Oppenheimer', 'Biopic sur le physicien et la bombe atomique'),
('Poor Things', 'Comédie dramatique surréaliste');

INSERT INTO showtimes (movie_id, date, time, room, total_seats) VALUES
(1, '2025-03-10', '20:30:00', 'Salle Principale', 140),
(1, '2025-03-11', '18:15:00', 'Salle 2', 80),
(2, '2025-03-12', '21:00:00', 'Salle Principale', 120),
(3, '2025-03-13', '19:45:00', 'Salle 3', 60);

USE cinema_min;

-- Ajoute le champ prix par place dans showtimes (si pas déjà fait)
ALTER TABLE showtimes
ADD COLUMN price DECIMAL(5,2) DEFAULT 10.00 AFTER total_seats;

-- Si tu veux aussi le nombre de places déjà réservées, tu peux le calculer dynamiquement (pas besoin de colonne)

-- Exemple de données de test avec prix
INSERT INTO showtimes (movie_id, date, time, room, total_seats, price) VALUES
(1, '2025-03-15', '20:30:00', 'Salle 1', 140, 12.50),
(1, '2025-03-16', '18:00:00', 'Salle 2', 80, 11.00),
(2, '2025-03-17', '21:00:00', 'Salle Principale', 120, 13.00),
(3, '2025-03-18', '19:45:00', 'Salle 3', 100, 10.00);