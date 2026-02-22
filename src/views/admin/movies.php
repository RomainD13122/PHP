<h1>Gestion des films</h1>

<p><a href="/admin/movies/add" style="padding: 8px 16px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;">+ Ajouter un film</a></p>

<?php if (empty($movies)): ?>
    <p>Aucun film pour le moment.</p>
<?php else: ?>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr style="background: #f2f2f2;">
            <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Titre</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Description</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Actions</th>
        </tr>
        <?php foreach ($movies as $m): ?>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;"><?= $m['id'] ?></td>
            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($m['title']) ?></td>
            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars(substr($m['description'] ?? '', 0, 100)) ?>…</td>
            <td style="padding: 10px; border: 1px solid #ddd;">
                <a href="/admin/movies/edit/<?= $m['id'] ?>" style="color: #007bff;">Modifier</a> |
                <a href="/admin/movies/del/<?= $m['id'] ?>" style="color: #dc3545;">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>