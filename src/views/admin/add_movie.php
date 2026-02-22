<h1>Ajouter un film</h1>

<?php if (isset($error) && $error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
    <p>
        <label>Titre *<br>
            <input type="text" name="title" required autofocus>
        </label>
    </p>
    <p>
        <label>Description<br>
            <textarea name="description" rows="6" style="width:100%"></textarea>
        </label>
    </p>
    <button type="submit">Ajouter</button>
</form>