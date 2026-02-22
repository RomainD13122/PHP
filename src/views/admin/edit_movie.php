<h1>Modifier le film : <?= htmlspecialchars($movie['title']) ?></h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="update_movie" value="1">
    <p>
        <label>Titre *</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required>
    </p>
    <p>
        <label>Description</label><br>
        <textarea name="description" rows="5"><?= htmlspecialchars($movie['description'] ?? '') ?></textarea>
    </p>
    <button type="submit" class="btn-primary">Enregistrer le film</button>
</form>

<hr>

<h2>Séances actuelles</h2>

<?php if (empty($showtimes)): ?>
    <p>Aucune séance pour ce film.</p>
<?php else: ?>
    <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
        <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Salle</th>
            <th>Places totales</th>
            <th>Places restantes</th>
            <th>Prix par place</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($showtimes as $s): ?>
        <tr>
            <form method="post">
                <input type="hidden" name="update_showtime" value="1">
                <input type="hidden" name="showtime_id" value="<?= $s['id'] ?>">
                <td><input type="date" name="date" value="<?= htmlspecialchars($s['date']) ?>" required></td>
                <td><input type="time" name="time" value="<?= htmlspecialchars($s['time']) ?>" required></td>
                <td><input type="text" name="room" value="<?= htmlspecialchars($s['room'] ?? '') ?>"></td>
                <td><input type="number" name="total_seats" value="<?= $s['total_seats'] ?>" min="1" required></td>
                <td><?= $s['available'] ?></td>
                <td><input type="number" name="price" value="<?= $s['price'] ?>" step="0.01" min="0" required></td>
                <td><button type="submit">Modifier</button></td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<hr>

<h2>Ajouter une nouvelle séance</h2>

<form method="post">
    <input type="hidden" name="add_showtime" value="1">
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