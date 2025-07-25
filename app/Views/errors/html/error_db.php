<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error - Kesalahan Database | Biddokkes POLRI</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --secondary-navy: #1e40af;
            --accent-blue: #3b82f6;
            --light-blue: #60a5fa;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
        }
        
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--secondary-navy) 100%);
        }
        
        .error-content {
            background: var(--white);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 90%;
        }
        
        .error-icon {
            font-size: 4rem;
            color: #fd7e14;
            margin-bottom: 1rem;
        }
        
        .error-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }
        
        .error-description {
            color: var(--gray-600);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .error-details {
            background: var(--gray-100);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
            text-align: left;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: var(--gray-700);
            max-height: 200px;
            overflow-y: auto;
        }
        
        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-navy), var(--accent-blue));
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 58, 138, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-navy);
            color: var(--primary-navy);
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-navy);
            color: var(--white);
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .error-content {
                padding: 2rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .error-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="error-content" data-aos="zoom-in">
            <div class="error-icon">
                <i class="fas fa-database"></i>
            </div>
            
            <h1 class="error-title">Kesalahan Database</h1>
            
            <p class="error-description">
                Maaf, terjadi kesalahan dalam mengakses database. 
                Tim kami sedang bekerja untuk memperbaiki masalah ini.
                Silakan coba lagi beberapa saat kemudian.
            </p>
            
            <?php if (ENVIRONMENT === 'development'): ?>
            <div class="error-details">
                <strong>Error:</strong> <?= $message ?? 'Database connection error' ?><br>
                <strong>Code:</strong> <?= $code ?? 'Unknown' ?><br>
                <strong>File:</strong> <?= $file ?? 'Unknown file' ?><br>
                <strong>Line:</strong> <?= $line ?? 'Unknown line' ?>
            </div>
            <?php endif; ?>
            
            <div class="error-actions">
                <a href="<?= base_url() ?>" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Kembali ke Beranda
                </a>
                <a href="<?= base_url('contact') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-envelope me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>
</body>
</html> 