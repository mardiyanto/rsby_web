<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        
        $userModel = new \App\Models\UserModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $kategoriDownloadModel = new \App\Models\KategoriDownloadModel();
        $beritaModel = new \App\Models\BeritaModel();
        $downloadModel = new \App\Models\DownloadModel();
        $slideModel = new \App\Models\SlideModel();
        $halamanModel = new \App\Models\HalamanModel();
        $galeriModel = new \App\Models\GaleriModel();
        $pesanKontakModel = new \App\Models\PesanKontakModel();
        $faqModel = new \App\Models\FaqModel();
        $statsModel = new \App\Models\StatsModel();
        
        // Statistik umum
        $jumlah_user = $userModel->countAllResults();
        $jumlah_kategori = $kategoriModel->countAllResults();
        $jumlah_kategori_download = $kategoriDownloadModel->countAllResults();
        $jumlah_berita = $beritaModel->countAllResults();
        $jumlah_download = $downloadModel->countAllResults();
        $jumlah_slide = $slideModel->countAllResults();
        $jumlah_halaman = $halamanModel->countAllResults();
        $jumlah_galeri = $galeriModel->countAllResults();
        $jumlah_pesan = $pesanKontakModel->countAllResults();
        $jumlah_faq = $faqModel->countAllResults();
        $jumlah_stats = $statsModel->countAllResults();
        
        // Statistik pesan kontak
        $pesan_statistics = $pesanKontakModel->getStatistics();
        
        // Grafik berita per bulan
        $grafik_berita = $beritaModel->select("COUNT(*) as jumlah, DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
            
        $labels_berita = [];
        $data_berita = [];
        foreach ($grafik_berita as $g) {
            $labels_berita[] = $g['bulan'];
            $data_berita[] = $g['jumlah'];
        }
        
        // Grafik download per bulan
        $grafik_download = $downloadModel->select("COUNT(*) as jumlah, DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
            
        $labels_download = [];
        $data_download = [];
        foreach ($grafik_download as $g) {
            $labels_download[] = $g['bulan'];
            $data_download[] = $g['jumlah'];
        }
        
        // Grafik pesan kontak per bulan
        $grafik_pesan = $pesanKontakModel->getPesanPerBulan();
        $labels_pesan = [];
        $data_pesan = [];
        foreach ($grafik_pesan as $g) {
            $labels_pesan[] = $g['bulan'];
            $data_pesan[] = $g['jumlah'];
        }
        
        // Statistik slide berdasarkan status
        $slide_aktif = $slideModel->where('status', 'aktif')->countAllResults();
        $slide_nonaktif = $slideModel->where('status', 'nonaktif')->countAllResults();
        
        // Download terpopuler
        $download_populer = $downloadModel->getPopularDownloads(5);
        
        // Berita terbaru
        $berita_terbaru = $beritaModel->getLatest(5);
        
        // Galeri terbaru
        $galeri_terbaru = $galeriModel->getLatest(5);
        
        // Pesan kontak terbaru
        $pesan_terbaru = $pesanKontakModel->orderBy('tanggal_kirim', 'DESC')->findAll(5);
        
        return view('backend/admin', [
            'jumlah_user' => $jumlah_user,
            'jumlah_kategori' => $jumlah_kategori,
            'jumlah_kategori_download' => $jumlah_kategori_download,
            'jumlah_berita' => $jumlah_berita,
            'jumlah_download' => $jumlah_download,
            'jumlah_slide' => $jumlah_slide,
            'jumlah_halaman' => $jumlah_halaman,
            'jumlah_galeri' => $jumlah_galeri,
            'jumlah_pesan' => $jumlah_pesan,
            'jumlah_faq' => $jumlah_faq,
            'jumlah_stats' => $jumlah_stats,
            'pesan_statistics' => $pesan_statistics,
            'slide_aktif' => $slide_aktif,
            'slide_nonaktif' => $slide_nonaktif,
            'grafik_berita_labels' => json_encode($labels_berita),
            'grafik_berita_data' => json_encode($data_berita),
            'grafik_download_labels' => json_encode($labels_download),
            'grafik_download_data' => json_encode($data_download),
            'grafik_pesan_labels' => json_encode($labels_pesan),
            'grafik_pesan_data' => json_encode($data_pesan),
            'download_populer' => $download_populer,
            'berita_terbaru' => $berita_terbaru,
            'galeri_terbaru' => $galeri_terbaru,
            'pesan_terbaru' => $pesan_terbaru,
        ]);
    }

    public function user()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'user') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        
        $beritaModel = new \App\Models\BeritaModel();
        $downloadModel = new \App\Models\DownloadModel();
        $slideModel = new \App\Models\SlideModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $kategoriDownloadModel = new \App\Models\KategoriDownloadModel();
        $halamanModel = new \App\Models\HalamanModel();
        $galeriModel = new \App\Models\GaleriModel();
        $pesanKontakModel = new \App\Models\PesanKontakModel();
        $faqModel = new \App\Models\FaqModel();
        $statsModel = new \App\Models\StatsModel();
        
        // Statistik umum untuk user
        $jumlah_berita = $beritaModel->countAllResults();
        $jumlah_download = $downloadModel->countAllResults();
        $jumlah_slide = $slideModel->countAllResults();
        $jumlah_kategori = $kategoriModel->countAllResults();
        $jumlah_kategori_download = $kategoriDownloadModel->countAllResults();
        $jumlah_halaman = $halamanModel->countAllResults();
        $jumlah_galeri = $galeriModel->countAllResults();
        $jumlah_pesan = $pesanKontakModel->countAllResults();
        $jumlah_faq = $faqModel->countAllResults();
        $jumlah_stats = $statsModel->countAllResults();
        
        // Statistik pesan kontak
        $pesan_statistics = $pesanKontakModel->getStatistics();
        
        // Grafik berita per bulan
        $grafik_berita = $beritaModel->select("COUNT(*) as jumlah, DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
            
        $labels_berita = [];
        $data_berita = [];
        foreach ($grafik_berita as $g) {
            $labels_berita[] = $g['bulan'];
            $data_berita[] = $g['jumlah'];
        }
        
        // Grafik download per bulan
        $grafik_download = $downloadModel->select("COUNT(*) as jumlah, DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
            
        $labels_download = [];
        $data_download = [];
        foreach ($grafik_download as $g) {
            $labels_download[] = $g['bulan'];
            $data_download[] = $g['jumlah'];
        }
        
        // Grafik pesan kontak per bulan
        $grafik_pesan = $pesanKontakModel->getPesanPerBulan();
        $labels_pesan = [];
        $data_pesan = [];
        foreach ($grafik_pesan as $g) {
            $labels_pesan[] = $g['bulan'];
            $data_pesan[] = $g['jumlah'];
        }
        
        // Berita terbaru
        $berita_terbaru = $beritaModel->getLatest(5);
        
        // Download terpopuler
        $download_populer = $downloadModel->getPopularDownloads(5);
        
        // Slide aktif
        $slide_aktif = $slideModel->getActiveSlides();
        
        // Galeri terbaru
        $galeri_terbaru = $galeriModel->getLatest(5);
        
        // Pesan kontak terbaru
        $pesan_terbaru = $pesanKontakModel->orderBy('tanggal_kirim', 'DESC')->findAll(5);

        return view('backend/user', [
            'jumlah_berita' => $jumlah_berita,
            'jumlah_download' => $jumlah_download,
            'jumlah_slide' => $jumlah_slide,
            'jumlah_kategori' => $jumlah_kategori,
            'jumlah_kategori_download' => $jumlah_kategori_download,
            'jumlah_halaman' => $jumlah_halaman,
            'jumlah_galeri' => $jumlah_galeri,
            'jumlah_pesan' => $jumlah_pesan,
            'jumlah_faq' => $jumlah_faq,
            'jumlah_stats' => $jumlah_stats,
            'pesan_statistics' => $pesan_statistics,
            'grafik_berita_labels' => json_encode($labels_berita),
            'grafik_berita_data' => json_encode($data_berita),
            'grafik_download_labels' => json_encode($labels_download),
            'grafik_download_data' => json_encode($data_download),
            'grafik_pesan_labels' => json_encode($labels_pesan),
            'grafik_pesan_data' => json_encode($data_pesan),
            'berita_terbaru' => $berita_terbaru,
            'download_populer' => $download_populer,
            'slide_aktif' => $slide_aktif,
            'galeri_terbaru' => $galeri_terbaru,
            'pesan_terbaru' => $pesan_terbaru,
        ]);
    }
} 