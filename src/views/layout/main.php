<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinéma</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="/" class="logo">Cinéma</a>

            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/my-bookings">Mes réservations</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="/admin/movies">Admin - Films</a>
                    <?php endif; ?>

                    <div class="profile-menu">
                        <button class="profile-btn"><i class="fas fa-user-circle fa-2x"></i></button>
                        <div class="profile-dropdown">
                            <a href="/profile">Profil (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
                            <a href="/logout">Déconnexion</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login">Connexion</a>
                    <a href="/register">Inscription</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <?php require ROOT . '/src/views/partials/messages.php'; ?>
        <?php require ROOT . "/src/views/$view.php"; ?>
    </main>
</body>
</html>