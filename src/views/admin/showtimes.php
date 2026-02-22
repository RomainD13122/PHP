<h1>Séances pour : <?= htmlspecialchars($movie['title']) ?></h1>

<p><a href="/admin/showtimes/add/<?= $movie['id'] ?>" class="btn btn-primary">+ Ajouter une séance</a></p>

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
        </tr>
        <?php foreach ($showtimes as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['date']) ?></td>
            <td><?= htmlspecialchars($s['time']) ?></td>
            <td><?= htmlspecialchars($s['room'] ?? '-') ?></td>
            <td><?= $s['total_seats'] ?></td>
            <td><?= $s['available'] ?></td>
            <td><?= number_format($s['price'], 2) ?> €</td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>