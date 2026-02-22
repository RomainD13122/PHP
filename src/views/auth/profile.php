<?php


if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}


require_once __DIR__ . '/../../config/Database.php';
use config\Database;

require_once __DIR__ . '/../../models/User.php';
use models\User;

$db = Database::get();

$stmt = $db->prepare(
    "SELECT id, email, role AS 'rank' FROM users WHERE id = ?"
);

$userId = (int) $_SESSION['user_id'];
$stmt->execute([$userId]);

$currentUser = $stmt->fetch(\PDO::FETCH_ASSOC);

if (!$currentUser) {
    session_destroy();
    header('Location: /login');
    exit;
}

$isAdmin = $currentUser['rank'] === 'admin';

// =======================
// Changement mot de passe
// =======================
$passwordSuccess = $passwordError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $oldPass = $_POST['old_password'] ?? '';
    $newPass = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$currentUser['id']]);
    $dbUser = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($dbUser && password_verify($oldPass, $dbUser['password'])) {
        if ($newPass === $confirm && strlen($newPass) >= 8) {
            $hashed = password_hash($newPass, PASSWORD_DEFAULT);

            $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed, $currentUser['id']]);

            $passwordSuccess = "Mot de passe modifié avec succès !";
        } else {
            $passwordError = "Les nouveaux mots de passe ne correspondent pas ou sont trop courts (min 8).";
        }
    } else {
        $passwordError = "Ancien mot de passe incorrect.";
    }
}

// =======================
// Suppression compte
// =======================
$deleteSuccess = $deleteError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userIdToDelete = (int) ($_POST['user_id'] ?? 0);

    if ($isAdmin || $userIdToDelete === (int)$currentUser['id']) {
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userIdToDelete]);

        if ($userIdToDelete === (int)$currentUser['id']) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        $deleteSuccess = "Utilisateur supprimé.";
    } else {
        $deleteError = "Action non autorisée.";
    }
}

// =======================
// Liste utilisateurs (admin)
// =======================
$users = [];

if ($isAdmin) {
    $stmt = $db->prepare(
        "SELECT id, email, role AS `rank` FROM users"
    );
    $stmt->execute();
    $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
?>

<div class="profile-container">
    <h1>Mon Profil</h1>

    <div class="profile-info">
        <p><strong>Email :</strong> <?= htmlspecialchars($currentUser['email'] ?? 'Non défini') ?></p>
        <p><strong>Rang :</strong>
            <span class="rank <?= htmlspecialchars($currentUser['rank'] ?? 'user') ?>">
                <?= ucfirst(htmlspecialchars($currentUser['rank'] ?? 'Utilisateur')) ?>
            </span>
        </p>
    </div>

    <div class="section">
        <h2>Changer mon mot de passe</h2>

        <?php if ($passwordSuccess): ?>
            <div class="alert success"><?= htmlspecialchars($passwordSuccess) ?></div>
        <?php endif; ?>

        <?php if ($passwordError): ?>
            <div class="alert danger"><?= htmlspecialchars($passwordError) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="change_password" value="1">

            <label>Ancien mot de passe</label>
            <input type="password" name="old_password" required>

            <label>Nouveau mot de passe</label>
            <input type="password" name="new_password" required minlength="8">

            <label>Confirmer</label>
            <input type="password" name="confirm_password" required minlength="8">

            <button type="submit" class="btn-primary">Modifier</button>
        </form>
    </div>

    <div class="section danger-zone">
        <h2>Supprimer mon compte</h2>
        <p class="warning">Attention : cette action est irréversible.</p>

        <form method="post" onsubmit="return confirm('Vraiment supprimer votre compte ?');">
            <input type="hidden" name="delete_user" value="1">
            <input type="hidden" name="user_id" value="<?= (int)$currentUser['id'] ?>">

            <button type="submit" class="btn-danger">Supprimer mon compte</button>
        </form>
    </div>

    <?php if ($isAdmin): ?>
        <div class="section">
            <h2>Gestion des utilisateurs</h2>

            <?php if ($deleteSuccess): ?>
                <div class="alert success"><?= htmlspecialchars($deleteSuccess) ?></div>
            <?php endif; ?>

            <?php if ($deleteError): ?>
                <div class="alert danger"><?= htmlspecialchars($deleteError) ?></div>
            <?php endif; ?>

            <?php if (empty($users)): ?>
                <p>Aucun autre utilisateur.</p>
            <?php else: ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Rang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <?php if ((int)$u['id'] === (int)$currentUser['id']) continue; ?>
                            <tr>
                                <td><?= (int)$u['id'] ?></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td class="rank <?= htmlspecialchars($u['rank']) ?>">
                                    <?= ucfirst(htmlspecialchars($u['rank'])) ?>
                                </td>
                                <td>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                        <input type="hidden" name="delete_user" value="1">
                                        <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">

                                        <button type="submit" class="btn-danger small">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
