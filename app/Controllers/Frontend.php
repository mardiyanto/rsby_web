<?php

namespace App\Controllers;

class Frontend extends BaseController
{
    public function index()
    {
        try {
            $slideModel = new \App\Models\SlideModel();
            $beritaModel = new \App\Models\BeritaModel();
            $galeriModel = new \App\Models\GaleriModel();
            $profilModel = new \App\Models\ProfilModel();
            $statsModel = new \App\Models\StatsModel();
            
            $slides = $slideModel->getActiveSlides();
            $berita_terbaru = $beritaModel->getLatest(3);
            $galeri = $galeriModel->getLatest(6);
            $profilWebsite = $profilModel->getProfil();
            $stats = $statsModel->getActiveStats(4); // Ambil 4 stats aktif untuk frontend
            
            return view('frontend/home', [
                'slides' => $slides,
                'berita_terbaru' => $berita_terbaru,
                'galeri' => $galeri,
                'profilWebsite' => $profilWebsite,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Frontend home error: ' . $e->getMessage());
            
            return view('frontend/home', [
                'slides' => [],
                'berita_terbaru' => [],
                'galeri' => [],
                'profilWebsite' => null,
                'stats' => []
            ]);
        }
    }
    
    public function galeri()
    {
        try {
            $galeriModel = new \App\Models\GaleriModel();
            $profilModel = new \App\Models\ProfilModel();
            
            $search = $this->request->getGet('search');
            $sort = $this->request->getGet('sort') ?: 'latest';
            
            $galeri = $galeriModel->getAllWithSearch($search, $sort) ?: [];
            $profilWebsite = $profilModel->getProfil();
            
            return view('frontend/galeri', [
                'galeri' => $galeri,
                'search' => $search,
                'sort' => $sort,
                'profilWebsite' => $profilWebsite
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Frontend galeri error: ' . $e->getMessage());
            
            return view('frontend/galeri', [
                'galeri' => [],
                'search' => '',
                'sort' => 'latest',
                'profilWebsite' => null
            ]);
        }
    }
    
    public function berita()
    {
        try {
            $beritaModel = new \App\Models\BeritaModel();
            $kategoriModel = new \App\Models\KategoriModel();
            $profilModel = new \App\Models\ProfilModel();
            
            $search = $this->request->getGet('search');
            $kategori = $this->request->getGet('kategori');
            $page = $this->request->getGet('page') ?: 1;
            
            $berita = $beritaModel->getAllWithSearch($search, $kategori, $page) ?: [];
            $kategoris = $kategoriModel->findAll() ?: [];
            $profilWebsite = $profilModel->getProfil();
            
            return view('frontend/berita', [
                'berita' => $berita,
                'kategoris' => $kategoris,
                'search' => $search,
                'kategori' => $kategori,
                'page' => $page,
                'profilWebsite' => $profilWebsite
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Frontend berita error: ' . $e->getMessage());
            
            return view('frontend/berita', [
                'berita' => [],
                'kategoris' => [],
                'search' => '',
                'kategori' => '',
                'page' => 1,
                'profilWebsite' => null
            ]);
        }
    }
    
    public function beritaDetail($slug)
    {
        try {
            $beritaModel = new \App\Models\BeritaModel();
            $profilModel = new \App\Models\ProfilModel();
            
            $berita = $beritaModel->getBeritaBySlug($slug);
            
            if (!$berita) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
            }
            
            // Ambil berita terkait
            $berita_terkait = $beritaModel->getRelatedBerita($berita['id_berita'], $berita['id_kategori'], 3) ?: [];
            $profilWebsite = $profilModel->getProfil();
            
            return view('frontend/berita_detail', [
                'berita' => $berita,
                'berita_terkait' => $berita_terkait,
                'profilWebsite' => $profilWebsite
            ]);
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            log_message('error', 'Frontend berita detail error: ' . $e->getMessage());
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }
    }
    
    public function beritaDetailById($id)
    {
        try {
            $beritaModel = new \App\Models\BeritaModel();
            $profilModel = new \App\Models\ProfilModel();
            
            // Validasi ID
            $id = intval($id);
            if ($id <= 0) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('ID berita tidak valid');
            }
            
            $berita = $beritaModel->getBeritaById($id);
            
            if (!$berita) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
            }
            
            // Increment view count
            $beritaModel->incrementViewCount($id);
            
            // Ambil berita terkait
            $berita_terkait = $beritaModel->getRelatedBerita($berita['id_berita'], $berita['id_kategori'], 3) ?: [];
            $profilWebsite = $profilModel->getProfil();
            
            return view('frontend/berita_detail', [
                'berita' => $berita,
                'berita_terkait' => $berita_terkait,
                'profilWebsite' => $profilWebsite
            ]);
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            log_message('error', 'Frontend berita detail by ID error: ' . $e->getMessage());
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }
    }
    
    public function halaman($slug)
    {
        try {
            $halamanModel = new \App\Models\HalamanModel();
            $profilModel = new \App\Models\ProfilModel();
            
            // Validasi slug
            if (empty($slug)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Slug halaman tidak valid');
            }
            
            $halaman = $halamanModel->getHalamanBySlug($slug);
            
            if (!$halaman) {
                // Coba cari halaman dengan slug yang berbeda
                $allHalaman = $halamanModel->getActiveHalaman();
                $suggestions = [];
                
                foreach ($allHalaman as $h) {
                    if (similar_text($slug, $h['slug']) > strlen($slug) * 0.6) {
                        $suggestions[] = $h;
                    }
                }
                
                // Jika ada saran, tampilkan halaman 404 dengan saran
                if (!empty($suggestions)) {
                    return view('frontend/404', [
                        'message' => 'Halaman tidak ditemukan',
                        'suggestions' => $suggestions,
                        'profilWebsite' => $profilModel->getProfil()
                    ]);
                }
                
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
            }
            
            $profilWebsite = $profilModel->getProfil();
            
            return view('frontend/halaman', [
                'halaman' => $halaman,
                'profilWebsite' => $profilWebsite
            ]);
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            // Log error untuk debugging
            log_message('error', 'Frontend halaman 404: ' . $e->getMessage() . ' - Slug: ' . ($slug ?? 'null'));
            
            // Tampilkan halaman 404 yang lebih informatif
            return view('frontend/404', [
                'message' => 'Halaman tidak ditemukan',
                'slug' => $slug,
                'profilWebsite' => $profilModel->getProfil() ?? null
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Frontend halaman error: ' . $e->getMessage());
            
            return view('frontend/404', [
                'message' => 'Terjadi kesalahan saat memuat halaman',
                'profilWebsite' => $profilModel->getProfil() ?? null
            ]);
        }
    }
    
    public function download()
    {
        try {
            $downloadModel = new \App\Models\DownloadModel();
            $kategoriDownloadModel = new \App\Models\KategoriDownloadModel();
            $profilModel = new \App\Models\ProfilModel();
            
            $search = $this->request->getGet('search');
            $kategori = $this->request->getGet('kategori');
            $page = $this->request->getGet('page') ?: 1;
            
            // Validasi input
            $search = trim($search ?? '');
            $kategori = trim($kategori ?? '');
            $page = max(1, intval($page));
            
            $downloads = $downloadModel->getAllWithSearch($search, $kategori, $page) ?: [];
            $kategoris = $kategoriDownloadModel->findAll() ?: [];
            $profilWebsite = $profilModel->getProfil();
            
            // Debug: Log kategori data
            log_message('info', 'Kategori data: ' . json_encode($kategoris));
            
            // Validasi data downloads
            foreach ($downloads as &$download) {
                $download['judul'] = $download['judul'] ?? 'File Download';
                $download['deskripsi'] = $download['deskripsi'] ?? '';
                $download['file'] = $download['file'] ?? '';
                $download['download_count'] = intval($download['download_count'] ?? 0);
                $download['created_at'] = $download['created_at'] ?? date('Y-m-d H:i:s');
                $download['nama_kategori'] = $download['nama_kategori'] ?? 'Umum';
            }
            
            return view('frontend/download', [
                'downloads' => $downloads,
                'kategoris' => $kategoris,
                'search' => $search,
                'kategori' => $kategori,
                'page' => $page,
                'profilWebsite' => $profilWebsite
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Frontend download error: ' . $e->getMessage());
            
            return view('frontend/download', [
                'downloads' => [],
                'kategoris' => [],
                'search' => '',
                'kategori' => '',
                'page' => 1,
                'profilWebsite' => null
            ]);
        }
    }
    
    public function downloadFile($id)
    {
        try {
            $downloadModel = new \App\Models\DownloadModel();
            
            // Validasi ID
            $id = intval($id);
            if ($id <= 0) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('ID file tidak valid');
            }
            
            $download = $downloadModel->find($id);
            
            if (!$download) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
            }
            
            // Gunakan nama_file sesuai dengan Download.php
            $file_path = FCPATH . 'uploads/download/' . ($download['nama_file'] ?? $download['file']);
            
            if (!file_exists($file_path)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
            }
            
            // Update hit counter sesuai dengan Download.php
            $downloadModel->update($id, [
                'hits' => ($download['hits'] ?? 0) + 1,
                'download_count' => ($download['download_count'] ?? 0) + 1
            ]);
            
            // Cek tipe file
            $extension = strtolower(pathinfo($download['nama_file'] ?? $download['file'], PATHINFO_EXTENSION));
            
            // Jika PDF, redirect ke preview
            if ($extension === 'pdf') {
                return redirect()->to('/frontdownload/preview/' . $id);
            }
            
            // Untuk file non-PDF, download langsung
            // Generate safe filename
            $safe_filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $download['judul']);
            $extension = pathinfo($download['nama_file'] ?? $download['file'], PATHINFO_EXTENSION);
            $download_filename = $safe_filename . '.' . $extension;

            // Set content type berdasarkan ekstensi
            $content_type = 'application/octet-stream';
            switch (strtolower($extension)) {
                case 'pdf':
                    $content_type = 'application/pdf';
                    break;
                case 'doc':
                    $content_type = 'application/msword';
                    break;
                case 'docx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                    break;
                case 'xls':
                    $content_type = 'application/vnd.ms-excel';
                    break;
                case 'xlsx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                    break;
                case 'ppt':
                    $content_type = 'application/vnd.ms-powerpoint';
                    break;
                case 'pptx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                    break;
                case 'zip':
                    $content_type = 'application/zip';
                    break;
                case 'rar':
                    $content_type = 'application/x-rar-compressed';
                    break;
                case 'jpg':
                case 'jpeg':
                    $content_type = 'image/jpeg';
                    break;
                case 'png':
                    $content_type = 'image/png';
                    break;
                case 'gif':
                    $content_type = 'image/gif';
                    break;
            }

            // Clear output buffers
            while (ob_get_level()) {
                ob_end_clean();
            }

            // Set response headers
            $this->response->setContentType($content_type);
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $download_filename . '"');
            $this->response->setHeader('Content-Length', (string)filesize($file_path));
            $this->response->setHeader('Cache-Control', 'no-cache, must-revalidate');
            $this->response->setHeader('Pragma', 'no-cache');
            $this->response->setHeader('Expires', '0');

            // Read and output file content
            $file_content = file_get_contents($file_path);
            if ($file_content === false) {
                throw new \Exception('Tidak bisa membaca file');
            }

            $this->response->setBody($file_content);
            return $this->response;
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            log_message('error', 'Frontend download file error: ' . $e->getMessage());
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak dapat diunduh');
        }
    }
    
    public function previewPdf($id)
    {
        try {
            $downloadModel = new \App\Models\DownloadModel();
            
            // Validasi ID
            $id = intval($id);
            if ($id <= 0) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('ID file tidak valid');
            }
            
            $download = $downloadModel->find($id);
            
            if (!$download) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
            }
            
            // Cek apakah file PDF
            $extension = strtolower(pathinfo($download['nama_file'] ?? $download['file'], PATHINFO_EXTENSION));
            if ($extension !== 'pdf') {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('File bukan PDF');
            }
            
            $file_path = FCPATH . 'uploads/download/' . ($download['nama_file'] ?? $download['file']);
            
            if (!file_exists($file_path)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
            }
            
            // Update hit counter
            $downloadModel->update($id, [
                'hits' => ($download['hits'] ?? 0) + 1,
                'download_count' => ($download['download_count'] ?? 0) + 1
            ]);
            
            // Clear output buffers
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            // Set response untuk preview PDF di browser
            $this->response->setContentType('application/pdf');
            $this->response->setHeader('Content-Disposition', 'inline; filename="' . ($download['nama_file'] ?? $download['file']) . '"');
            $this->response->setHeader('Content-Length', (string)filesize($file_path));
            $this->response->setHeader('Cache-Control', 'no-cache, must-revalidate');
            $this->response->setHeader('Pragma', 'no-cache');
            $this->response->setHeader('Expires', '0');
            // Read and output file content
            $file_content = file_get_contents($file_path);
            if ($file_content === false) {
                throw new \Exception('Tidak bisa membaca file');
            }
            
            $this->response->setBody($file_content);
            return $this->response;
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            log_message('error', 'Frontend preview PDF error: ' . $e->getMessage());
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak dapat ditampilkan');
        }
    }
    
    public function forceDownload($id)
    {
        try {
            $downloadModel = new \App\Models\DownloadModel();
            
            // Validasi ID
            $id = intval($id);
            if ($id <= 0) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('ID file tidak valid');
            }
            
            $download = $downloadModel->find($id);
            
            if (!$download) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
            }
            
            $file_path = FCPATH . 'uploads/download/' . ($download['nama_file'] ?? $download['file']);
            
            if (!file_exists($file_path)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
            }
            
            // Update hit counter
            $downloadModel->update($id, [
                'hits' => ($download['hits'] ?? 0) + 1,
                'download_count' => ($download['download_count'] ?? 0) + 1
            ]);
            
            // Generate safe filename untuk download
            $safe_filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $download['judul']);
            $extension = pathinfo($download['nama_file'] ?? $download['file'], PATHINFO_EXTENSION);
            $download_filename = $safe_filename . '.' . $extension;
            
            // Set content type berdasarkan ekstensi
            $content_type = 'application/octet-stream';
            switch (strtolower($extension)) {
                case 'pdf':
                    $content_type = 'application/pdf';
                    break;
                case 'doc':
                    $content_type = 'application/msword';
                    break;
                case 'docx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                    break;
                case 'xls':
                    $content_type = 'application/vnd.ms-excel';
                    break;
                case 'xlsx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                    break;
                case 'ppt':
                    $content_type = 'application/vnd.ms-powerpoint';
                    break;
                case 'pptx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                    break;
                case 'zip':
                    $content_type = 'application/zip';
                    break;
                case 'rar':
                    $content_type = 'application/x-rar-compressed';
                    break;
                case 'jpg':
                case 'jpeg':
                    $content_type = 'image/jpeg';
                    break;
                case 'png':
                    $content_type = 'image/png';
                    break;
                case 'gif':
                    $content_type = 'image/gif';
                    break;
            }
            
            // Clear output buffers
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            // Set response headers
            $this->response->setContentType($content_type);
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $download_filename . '"');
            $this->response->setHeader('Content-Length', (string)filesize($file_path));
            $this->response->setHeader('Cache-Control', 'no-cache, must-revalidate');
            $this->response->setHeader('Pragma', 'no-cache');
            $this->response->setHeader('Expires', '0');
            // Read and output file content
            $file_content = file_get_contents($file_path);
            if ($file_content === false) {
                throw new \Exception('Tidak bisa membaca file');
            }
            
            $this->response->setBody($file_content);
            return $this->response;
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            log_message('error', 'Frontend force download error: ' . $e->getMessage());
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak dapat diunduh');
        }
    }
    
    public function contact()
    {
        try {
            $profilModel = new \App\Models\ProfilModel();
            $faqModel = new \App\Models\FaqModel();
            
            $profilWebsite = $profilModel->getProfil();
            $faqs = $faqModel->getFaqsForFrontend();
            
            return view('frontend/contact', [
                'profilWebsite' => $profilWebsite,
                'faqs' => $faqs
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Frontend contact error: ' . $e->getMessage());
            
            return view('frontend/contact', [
                'profilWebsite' => null,
                'faqs' => []
            ]);
        }
    }
    
    public function sendContact()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/contact')->with('error', 'Metode tidak valid.');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|max_length[255]',
            'telepon' => 'permit_empty|max_length[20]',
            'subjek' => 'required|max_length[255]',
            'pesan' => 'required|min_length[10]',
            'setuju' => 'required'
        ], [
            'nama' => [
                'required' => 'Nama harus diisi',
                'min_length' => 'Nama minimal 3 karakter',
                'max_length' => 'Nama maksimal 255 karakter'
            ],
            'email' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Format email tidak valid',
                'max_length' => 'Email maksimal 255 karakter'
            ],
            'telepon' => [
                'max_length' => 'Telepon maksimal 20 karakter'
            ],
            'subjek' => [
                'required' => 'Subjek harus diisi',
                'max_length' => 'Subjek maksimal 255 karakter'
            ],
            'pesan' => [
                'required' => 'Pesan harus diisi',
                'min_length' => 'Pesan minimal 10 karakter'
            ],
            'setuju' => [
                'required' => 'Anda harus menyetujui kebijakan privasi'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $pesanKontakModel = new \App\Models\PesanKontakModel();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'),
            'subjek' => $this->request->getPost('subjek'),
            'pesan' => $this->request->getPost('pesan'),
            'status' => 'baru'
        ];

        if ($pesanKontakModel->insert($data)) {
            return redirect()->to('/contact')->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim pesan. Silakan coba lagi.');
        }
    }
    
    public function search()
    {
        try {
            $keyword = $this->request->getGet('q');
            
            if (!$keyword || trim($keyword) === '') {
                return redirect()->to('/');
            }
            
            $keyword = trim($keyword);
            
            $beritaModel = new \App\Models\BeritaModel();
            $halamanModel = new \App\Models\HalamanModel();
            $downloadModel = new \App\Models\DownloadModel();
            $profilModel = new \App\Models\ProfilModel();
            
            $berita_results = $beritaModel->search($keyword, 5) ?: [];
            $halaman_results = $halamanModel->search($keyword, 5) ?: [];
            $download_results = $downloadModel->search($keyword, 5) ?: [];
            $profilWebsite = $profilModel->getProfil();
            
            return view('frontend/search', [
                'keyword' => $keyword,
                'berita_results' => $berita_results,
                'halaman_results' => $halaman_results,
                'download_results' => $download_results,
                'profilWebsite' => $profilWebsite
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Frontend search error: ' . $e->getMessage());
            
            return view('frontend/search', [
                'keyword' => $keyword ?? '',
                'berita_results' => [],
                'halaman_results' => [],
                'download_results' => [],
                'profilWebsite' => null
            ]);
        }
    }
} 