{
    "error": true,
    "code": <?= $code ?? 500 ?>,
    "message": "<?= $message ?? 'Database connection error' ?>",
    "timestamp": "<?= date('Y-m-d H:i:s') ?>"
    <?php if (ENVIRONMENT === 'development'): ?>,
    "file": "<?= $file ?? 'Unknown' ?>",
    "line": <?= $line ?? 0 ?>
    <?php endif; ?>
} 