ERROR: 404

<?= $message ?? 'Page Not Found' ?>

The page you requested was not found.

<?php if (ENVIRONMENT === 'development'): ?>
File: <?= $file ?? 'Unknown' ?>
Line: <?= $line ?? 'Unknown' ?>
<?php endif; ?>
