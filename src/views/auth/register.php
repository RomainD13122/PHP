<h1>Inscription</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
    <p>
        <label>Pseudo<br>
            <input type="text" name="username" required autofocus>
        </label>
    </p>
    <p>
        <label>Email<br>
            <input type="email" name="email" required>
        </label>
    </p>
    <p>
        <label>Mot de passe<br>
            <input type="password" name="password" required>
        </label>
    </p>
    <p>
        <label>Confirmation<br>
            <input type="password" name="password2" required>
        </label>
    </p>
    <button type="submit">Créer mon compte</button>
</form>