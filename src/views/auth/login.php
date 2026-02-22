<h1>Connexion</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
    <p>
        <label>Email<br>
            <input type="email" name="email" required autofocus>
        </label>
    </p>
    <p>
        <label>Mot de passe<br>
            <input type="password" name="password" required>
        </label>
    </p>
    <button type="submit">Se connecter</button>
</form>

<p><a href="/register">Créer un compte</a></p>