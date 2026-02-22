<h1>Ajouter une séance pour : <?= htmlspecialchars($movie['title']) ?></h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
    <p>
        <label>Date *</label><br>
        <input type="date" name="date" required>
    </p>
    <p>
        <label>Heure *</label><br>
        <input type="time" name="time" required>
    </p>
    <p>
        <label>Salle (optionnel)</label><br>
        <input type="text" name="room">
    </p>
    <p>
        <label>Nombre de places totales *</label><br>
        <input type="number" name="total_seats" min="1" value="100" required>
    </p>
    <p>
        <label>Prix par place (€) *</label><br>
        <input type="number" name="price" step="0.01" min="0" value="10.00" required>
    </p>
    <button type="submit" class="btn-primary">Ajouter la séance</button>
</form>