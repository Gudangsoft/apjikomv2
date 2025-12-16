<!DOCTYPE html>
<html>
<head>
    <title>Add Journal Dummy Data</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 12px 24px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 16px; }
        .btn:hover { background: #45a049; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 5px; margin: 10px 0; }
        .item { padding: 8px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎉 Add Journal Dummy Data</h1>
        
        <?php
        if (isset($_GET['run']) && $_GET['run'] == 'yes') {
            require __DIR__.'/vendor/autoload.php';
            $app = require_once __DIR__.'/bootstrap/app.php';
            $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

            use App\Models\Journal;

            try {
                $journals = [
                    ['title' => 'Implementasi Machine Learning untuk Prediksi Cuaca di Indonesia', 'authors' => 'Dr. Ahmad Fadli, M.Kom., Prof. Siti Nurhaliza, Ph.D., Dr. Budi Santoso, M.T.', 'abstract' => 'Penelitian ini membahas implementasi algoritma machine learning untuk memprediksi cuaca di Indonesia. Menggunakan data historis dari BMKG selama 10 tahun terakhir, kami mengembangkan model prediksi yang dapat memberikan akurasi hingga 87%.', 'volume' => '12', 'issue' => '3', 'year' => 2025, 'pages' => '145-162', 'doi' => '10.1234/jti.2025.12.3.145', 'keywords' => 'Machine Learning, Prediksi Cuaca, Random Forest', 'published_date' => '2025-09-15', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Teknologi Informasi'],
                    ['title' => 'Analisis Keamanan Sistem Informasi Berbasis Cloud Computing', 'authors' => 'Dr. Rina Wati, M.Sc., Ahmad Yani, S.Kom., M.T.', 'abstract' => 'Makalah ini menganalisis berbagai aspek keamanan dalam sistem informasi berbasis cloud computing. Penelitian mencakup evaluasi terhadap berbagai protokol keamanan, enkripsi data, dan manajemen akses.', 'volume' => '11', 'issue' => '2', 'year' => 2025, 'pages' => '78-94', 'doi' => '10.1234/jsi.2025.11.2.78', 'keywords' => 'Cloud Computing, Keamanan Sistem, Enkripsi', 'published_date' => '2025-06-20', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Keamanan Siber'],
                    ['title' => 'Pengembangan Aplikasi Mobile untuk Monitoring Kesehatan Lansia', 'authors' => 'Siti Rahmawati, S.Kom., M.Kom., Dr. Hendra Wijaya, Sp.PD', 'abstract' => 'Aplikasi mobile yang dikembangkan dalam penelitian ini bertujuan untuk memudahkan monitoring kesehatan lansia secara real-time. Aplikasi terintegrasi dengan wearable devices untuk mengumpulkan data vital signs.', 'volume' => '8', 'issue' => '1', 'year' => 2025, 'pages' => '23-41', 'doi' => '10.1234/jkm.2025.8.1.23', 'keywords' => 'Mobile Health, Monitoring Kesehatan, Lansia', 'published_date' => '2025-03-10', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Kesehatan Digital'],
                    ['title' => 'Optimasi Algoritma Routing pada Jaringan Sensor Nirkabel', 'authors' => 'Prof. Dr. Bambang Sutrisno, M.T., Andi Prasetyo, S.T., M.T.', 'abstract' => 'Penelitian ini mengusulkan algoritma routing yang dioptimasi untuk jaringan sensor nirkabel (WSN) dengan tujuan meningkatkan efisiensi energi dan memperpanjang masa pakai jaringan.', 'volume' => '15', 'issue' => '4', 'year' => 2024, 'pages' => '201-218', 'doi' => '10.1234/jjn.2024.15.4.201', 'keywords' => 'WSN, Routing Algorithm, Energy Efficiency', 'published_date' => '2024-11-25', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Jaringan Komputer'],
                    ['title' => 'Implementasi Blockchain untuk Traceability Produk Pertanian', 'authors' => 'Dr. Dewi Kartika, M.Sc., Ir. Supriyadi, M.Agr.', 'abstract' => 'Makalah ini membahas implementasi teknologi blockchain untuk meningkatkan traceability produk pertanian dari hulu ke hilir. Sistem yang dikembangkan memungkinkan konsumen untuk melacak asal-usul produk.', 'volume' => '9', 'issue' => '2', 'year' => 2024, 'pages' => '112-130', 'doi' => '10.1234/jap.2024.9.2.112', 'keywords' => 'Blockchain, Traceability, Pertanian', 'published_date' => '2024-08-05', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Blockchain'],
                    ['title' => 'Analisis Sentimen Media Sosial Menggunakan Deep Learning', 'authors' => 'Rina Susanti, S.Kom., M.T., Dr. Faisal Rahman, M.Kom.', 'abstract' => 'Penelitian ini mengembangkan model analisis sentimen untuk media sosial menggunakan teknik deep learning, khususnya LSTM dan BERT. Model dilatih menggunakan dataset lebih dari 1 juta tweet.', 'volume' => '13', 'issue' => '1', 'year' => 2025, 'pages' => '45-63', 'doi' => '10.1234/jdl.2025.13.1.45', 'keywords' => 'Sentiment Analysis, Deep Learning, LSTM', 'published_date' => '2025-02-14', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Artificial Intelligence'],
                    ['title' => 'Sistem Rekomendasi E-Learning Berbasis Collaborative Filtering', 'authors' => 'Dr. Hadi Santoso, M.Pd., Nurul Hidayah, S.Kom., M.Kom.', 'abstract' => 'Sistem rekomendasi yang dikembangkan menggunakan metode collaborative filtering untuk memberikan rekomendasi konten pembelajaran yang dipersonalisasi.', 'volume' => '10', 'issue' => '3', 'year' => 2024, 'pages' => '167-185', 'doi' => '10.1234/jel.2024.10.3.167', 'keywords' => 'E-Learning, Recommender System', 'published_date' => '2024-10-18', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Pendidikan'],
                    ['title' => 'Deteksi Dini Penyakit Tanaman Menggunakan Computer Vision', 'authors' => 'Ir. Yusuf Habibi, M.Sc., Dr. Linda Wijaya, S.P., M.Si.', 'abstract' => 'Penelitian ini mengembangkan sistem deteksi dini penyakit tanaman menggunakan teknik computer vision dan deep learning. Model CNN yang dikembangkan mampu mengidentifikasi 15 jenis penyakit tanaman.', 'volume' => '7', 'issue' => '2', 'year' => 2024, 'pages' => '89-107', 'doi' => '10.1234/jpt.2024.7.2.89', 'keywords' => 'Computer Vision, Plant Disease, CNN', 'published_date' => '2024-06-30', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Pertanian Digital'],
                    ['title' => 'Pengembangan Smart City Platform untuk Manajemen Lalu Lintas', 'authors' => 'Dr. Ir. Agus Setiawan, M.T., Ratna Sari, S.T., M.T.', 'abstract' => 'Platform smart city yang dikembangkan mengintegrasikan berbagai sensor dan kamera untuk monitoring lalu lintas real-time. Sistem menggunakan AI untuk memprediksi kemacetan.', 'volume' => '14', 'issue' => '2', 'year' => 2025, 'pages' => '134-156', 'doi' => '10.1234/jsc.2025.14.2.134', 'keywords' => 'Smart City, Traffic Management, IoT', 'published_date' => '2025-05-22', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Smart City'],
                    ['title' => 'Keamanan Data pada Sistem Internet of Things (IoT)', 'authors' => 'Prof. Dr. Muhammad Iqbal, M.T., Sari Wulandari, S.Kom., M.Kom.', 'abstract' => 'Penelitian ini menganalisis berbagai aspek keamanan data pada sistem IoT dan mengusulkan framework keamanan yang komprehensif. Framework mencakup enkripsi end-to-end.', 'volume' => '11', 'issue' => '4', 'year' => 2025, 'pages' => '223-245', 'doi' => '10.1234/jiot.2025.11.4.223', 'keywords' => 'IoT Security, Data Protection, Encryption', 'published_date' => '2025-08-12', 'views' => rand(100, 500), 'downloads' => rand(50, 200), 'is_published' => true, 'category' => 'Internet of Things'],
                ];

                echo '<div class="success"><strong>✅ Sukses!</strong> Menambahkan jurnal dummy...</div>';
                
                $count = 0;
                foreach ($journals as $journalData) {
                    Journal::create($journalData);
                    $count++;
                    echo "<div class='item'>✅ #{$count}. {$journalData['title']}</div>";
                }

                echo "<div class='success'><strong>🎉 Selesai!</strong> Berhasil menambahkan {$count} jurnal dummy!</div>";
                echo "<p><a href='/admin/journals' class='btn'>Lihat Jurnal di Admin</a> ";
                echo "<a href='/jurnal' class='btn' style='background: #2196F3;'>Lihat Jurnal di Website</a></p>";
                
            } catch (Exception $e) {
                echo "<div class='error'><strong>❌ Error:</strong> " . $e->getMessage() . "</div>";
            }
        } else {
            echo '<p>Klik tombol di bawah untuk menambahkan 10 data jurnal dummy ke database.</p>';
            echo '<a href="?run=yes" class="btn">🚀 Tambahkan Jurnal Dummy</a>';
        }
        ?>
    </div>
</body>
</html>
