<?php if (isset($_SESSION['flash'])): ?>
<div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type'] ?? 'info') ?>">
    <?= htmlspecialchars($_SESSION['flash']['text'] ?? '') ?>
</div>
<?php unset($_SESSION['flash']); ?>
<?php endif; ?>