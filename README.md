
# 🎬 Cinéma-Min : Application de Réservation de Places

Une application web robuste de gestion de cinéma développée en **PHP natif** suivant l'architecture **MVC** (Modèle-Vue-Contrôleur). Ce projet a été réalisé dans le cadre du module PHP.

## 👥 Auteurs

* **Romain Daniel**
* **Ilan Oudor**

---

## 🚀 Fonctionnalités

### 🔐 Authentification & Comptes

* **Inscription & Connexion sécurisée** : Gestion des sessions PHP.
* **Option "Se souvenir de moi"** : Connexion persistante via cookies sécurisés (`selector/token`).
* **Gestion de profil** : Possibilité de modifier ou supprimer son compte utilisateur.
* **Déconnexion** : Destruction propre de la session et des cookies associés.

### 🎟️ Réservations

* **Catalogue** : Affichage des films à l'affiche.
* **Séances** : Consultation des dates et horaires par film.
* **Réservation** : Système de réservation de places avec vérification de la disponibilité en temps réel.
* **Historique** : Espace utilisateur pour consulter ses réservations passées.

### 🛡️ Sécurité (Points clés)

* **Injections SQL** : Utilisation systématique de requêtes préparées avec  **PDO** .
* **Attaques XSS** : Échappement des données en sortie via `htmlspecialchars()`.
* **Mots de passe** : Stockage sécurisé via l'algorithme `password_hash()`.
* **Accès** : Middleware de contrôle d'accès (obligation d'être connecté pour réserver).

---

## 🏗️ Architecture du Projet

Le projet respecte une architecture **MVC** stricte sans framework pour une séparation claire des responsabilités :

* `public/` : Point d'entrée de l'application (`index.php`), fichiers CSS, images et JS.
* `src/models/` : Logique de données et requêtes SQL (PDO).
* `src/controllers/` : Logique métier et lien entre modèles et vues.
* `src/views/` : Fichiers d'affichage (HTML/PHP),  **aucune requête SQL ici** .
* `config/` : Configuration de la base de données.

---

## 🛠️ Installation (Laragon / WAMP)

1. **Cloner le dépôt** :
   **Bash**

   ```
   git clone https://github.com/RomainD13122/PHP.git
   ```
2. **Configurer la base de données** :

   * Ouvrez votre gestionnaire de base de données (HeidiSQL, phpMyAdmin).
   * Créez une base de données nommée `cinema_min` (ou celle définie dans votre config).
   * Importez le fichier `database.sql` situé à la racine du projet.
3. **Configuration PHP** :

   * Modifiez le fichier de configuration (ex: `src/models/Database.php` ou `config.php`) avec vos identifiants de connexion locaux.
4. **Lancer le projet** :

   * Placez le dossier dans `C:\laragon\www\`.
   * Accédez à `http://cinema-min.test` ou `http://localhost/PHP/public/`.

---

## 📊 Stack Technique

---

### 💡 Note pour le correcteur

Le projet inclut la gestion des rôles (Admin/Utilisateur) en tant que  **bonus** , permettant à un administrateur de gérer les films et les séances via une interface dédiée.
