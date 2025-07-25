ERROR: <?= $code ?? 'Unknown Error' ?>

<?= $message ?? 'An error occurred' ?>

<?php if (ENVIRONMENT === 'development'): ?>
File: <?= $file ?? 'Unknown' ?>
Line: <?= $line ?? 'Unknown' ?>

Stack trace:
<?= $trace ?? 'No stack trace available' ?>
<?php endif; ?>
