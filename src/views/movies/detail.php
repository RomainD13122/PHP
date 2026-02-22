<h1><?= htmlspecialchars($movie['title']) ?></h1>

<p><?= nl2br(htmlspecialchars($movie['description'] ?? 'Aucune description')) ?></p>

<h2>Séances disponibles</h2>

<?php if (empty($showtimes)): ?>
    <p>Aucune séance disponible actuellement.</p>
<?php else: ?>
    <div class="showtimes-grid">
        <?php foreach ($showtimes as $s): ?>
        <div class="showtime-card">
            <div class="card-content">
                <span class="datetime"><?= htmlspecialchars($s['date']) ?></span>
                <div class="time"><?= htmlspecialchars($s['time']) ?></div>
                <div class="room">Salle <?= htmlspecialchars($s['room'] ?? '-') ?></div>
                
                <div class="places">
                    Places restantes : <strong><?= $s['available'] ?></strong>
                </div>
                
                <div class="action">
                    <?php if ($s['available'] > 0): ?>
                        <a href="/book/<?= $s['id'] ?>">Réserver maintenant</a>
                    <?php else: ?>
                        <span>Complet</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>