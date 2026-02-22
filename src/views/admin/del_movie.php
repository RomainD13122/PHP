<h1>Supprimer le film</h1>

<div class="alert alert-warning">
    <p>Êtes-vous vraiment sûr de vouloir supprimer ce film ?</p>
    <p><strong><?= htmlspecialchars($movie['title']) ?></strong></p>
    
    <?php if (!empty($movie['description'])): ?>
        <p>Description : <?= htmlspecialchars(substr($movie['description'], 0, 150)) ?>...</p>
    <?php endif; ?>
    
    <p>Cette action supprimera aussi toutes les séances et réservations liées à ce film.</p>
    <p>Elle est irréversible.</p>
</div>

<form method="post">
    <input type="hidden" name="confirm" value="yes">
    <button type="submit" style="background: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Oui, supprimer définitivement</button>
    <a href="/admin/movies" style="margin-left: 20px; color: #007bff; text-decoration: none;">Annuler</a>
</form>