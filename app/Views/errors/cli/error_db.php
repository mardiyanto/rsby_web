DATABASE ERROR: <?= $code ?? 'Unknown' ?>

<?= $message ?? 'Database connection error' ?>
 
<?php if (ENVIRONMENT === 'development'): ?>
File: <?= $file ?? 'Unknown' ?>
Line: <?= $line ?? 'Unknown' ?>
<?php endif; ?> 