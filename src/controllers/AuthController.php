<?php
namespace controllers;

use models\User;

class AuthController extends BaseController {

    public function login() {
    $error = $_GET['msg'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';

        $userModel = new \models\User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id']       = $user['id'];
            $_SESSION['username']      = $user['username'];
            $_SESSION['role']          = $user['role']; 
            $_SESSION['last_activity'] = time();

            $this->flash('success', 'Bienvenue ' . htmlspecialchars($user['username']));
            header('Location: /');
            exit;
        } else {
            $error = "Identifiants incorrects";
        }
        }
        $this->render('auth/login', compact('error'));
    }

    public function register() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $pass     = $_POST['password'] ?? '';
            $pass2    = $_POST['password2'] ?? '';

            if ($pass !== $pass2) $error = "Les mots de passe ne correspondent pas";
            else if (strlen($pass) < 6) $error = "Mot de passe trop court (≥ 6 caractères)";

            if (!$error) {
                try {
                    (new User())->create(compact('username', 'email', 'pass'));
                    $this->flash('success', 'Compte créé. Vous pouvez vous connecter.');
                    header('Location: /login');
                    exit;
                } catch (\PDOException $e) {
                    $error = "Email ou pseudo déjà utilisé";
                }
            }
        }
        $this->render('auth/register', compact('error'));
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function profile() {
        $this->requireAuth();
        $this->render('auth/profile', ['username' => $_SESSION['username']]);
    }
}