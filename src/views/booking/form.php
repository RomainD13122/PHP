<h1>Réserver une place</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<p>Film : <strong><?= htmlspecialchars($showtime['movie_title'] ?? '—') ?></strong></p>
<p>Date : <?= htmlspecialchars($showtime['date']) ?></p>
<p>Heure : <?= htmlspecialchars($showtime['time']) ?></p>
<p>Salle : <?= htmlspecialchars($showtime['room'] ?? '-') ?></p>
<p>Places restantes : <strong><?= $available ?></strong></p>

<?php if ($available <= 0): ?>
    <p class="alert alert-warning">Cette séance est complète.</p>
<?php else: ?>
    <form method="post">
        <p>
            <label>Nombre de places (1–6)<br>
                <input type="number" name="seats" min="1" max="6" value="1" required>
            </label>
        </p>
        <button type="submit">Confirmer la réservation</button>
    </form>
<?php endif; ?>