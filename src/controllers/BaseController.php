<?php
namespace controllers;

class BaseController {
    protected function render($view, $data = []) {
        extract($data);
        require ROOT . '/src/views/layout/main.php';
    }

    protected function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?msg=Connexion+requise');
            exit;
        }
    }

    protected function flash($type, $text) {
        $_SESSION['flash'] = compact('type', 'text');
    }

    public function show404($message = 'Page non trouvée') {
        http_response_code(404);
        $this->render('errors/404', ['message' => $message]);
        exit;
    }
}