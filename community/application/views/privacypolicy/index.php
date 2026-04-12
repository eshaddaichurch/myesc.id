<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - mydc+</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            color: #333;
            line-height: 1.7;
        }
        .header {
            background: #FF5008;
            color: #fff;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 { font-size: 28px; font-weight: 700; }
        .header p { font-size: 14px; margin-top: 8px; opacity: 0.85; }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        h2 {
            font-size: 18px;
            font-weight: 700;
            color: #FF5008;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        p { margin-bottom: 12px; font-size: 15px; }
        ul { padding-left: 20px; margin-bottom: 12px; }
        ul li { margin-bottom: 6px; font-size: 15px; }
        .footer {
            text-align: center;
            padding: 30px;
            color: #999;
            font-size: 13px;
        }
        .badge {
            display: inline-block;
            background: #FFF0EB;
            color: #FF5008;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            margin-top: 8px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Privacy Policy</h1>
    <p>mydc+ — Disciples Community Mobile App</p>
    <span class="badge">Terakhir diperbarui: <?= date('d F Y') ?></span>
</div>

<div class="container">

    <p>
        Selamat datang di <strong>mydc+</strong>, aplikasi mobile resmi untuk komunitas
        Disciples Community (DC) yang dikembangkan oleh <strong>EscIntech</strong>.
        Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan,
        dan melindungi informasi Anda saat menggunakan aplikasi ini.
    </p>

    <h2>1. Informasi yang Kami Kumpulkan</h2>
    <p>Kami mengumpulkan informasi berikut saat Anda menggunakan aplikasi:</p>
    <ul>
        <li><strong>Data Akun:</strong> Username dan password untuk autentikasi login</li>
        <li><strong>Data Profil:</strong> Nama lengkap dan foto profil</li>
        <li><strong>Data Komunitas:</strong> Informasi keanggotaan DC, absensi, dan progres</li>
        <li><strong>Data Perangkat:</strong> Token notifikasi untuk pengiriman push notification</li>
        <li><strong>Foto Dokumentasi:</strong> Foto yang diunggah saat mencatat absensi</li>
    </ul>

    <h2>2. Cara Kami Menggunakan Informasi</h2>
    <p>Informasi yang dikumpulkan digunakan untuk:</p>
    <ul>
        <li>Autentikasi dan keamanan akun pengguna</li>
        <li>Menampilkan data komunitas DC dan anggota</li>
        <li>Mengirimkan notifikasi terkait aktivitas komunitas</li>
        <li>Mencatat dan mengelola absensi pertemuan DC</li>
        <li>Memproses permohonan bergabung komunitas</li>
        <li>Mengelola booking ruangan</li>
    </ul>

    <h2>3. Penyimpanan Data</h2>
    <p>
        Semua data disimpan secara aman di server kami yang berlokasi di Indonesia.
        Data tidak akan dijual, disewakan, atau dibagikan kepada pihak ketiga
        tanpa persetujuan Anda, kecuali diwajibkan oleh hukum yang berlaku.
    </p>

    <h2>4. Izin Aplikasi</h2>
    <p>Aplikasi mydc+ memerlukan izin berikut:</p>
    <ul>
        <li><strong>Kamera:</strong> Untuk mengambil foto dokumentasi absensi</li>
        <li><strong>Galeri/Penyimpanan:</strong> Untuk memilih foto dari galeri</li>
        <li><strong>Notifikasi:</strong> Untuk menerima pemberitahuan aktivitas komunitas</li>
        <li><strong>Internet:</strong> Untuk mengakses data dari server</li>
    </ul>

    <h2>5. Keamanan Data</h2>
    <p>
        Kami menggunakan enkripsi dan langkah-langkah keamanan standar industri
        untuk melindungi data Anda dari akses yang tidak sah, perubahan,
        pengungkapan, atau penghapusan yang tidak diinginkan.
    </p>

    <h2>6. Data Pihak Ketiga</h2>
    <p>Aplikasi ini menggunakan layanan pihak ketiga berikut:</p>
    <ul>
        <li><strong>Expo Push Notification Service:</strong> Untuk pengiriman notifikasi</li>
        <li><strong>Firebase Cloud Messaging:</strong> Untuk push notification Android</li>
    </ul>

    <h2>7. Hak Pengguna</h2>
    <p>Anda memiliki hak untuk:</p>
    <ul>
        <li>Mengakses data pribadi yang kami simpan</li>
        <li>Meminta koreksi data yang tidak akurat</li>
        <li>Meminta penghapusan akun dan data Anda</li>
        <li>Menonaktifkan notifikasi kapan saja melalui pengaturan perangkat</li>
    </ul>

    <h2>8. Perubahan Kebijakan</h2>
    <p>
        Kami dapat memperbarui kebijakan privasi ini sewaktu-waktu.
        Perubahan akan diberitahukan melalui aplikasi atau website resmi kami.
        Dengan terus menggunakan aplikasi setelah perubahan, Anda menyetujui
        kebijakan yang telah diperbarui.
    </p>

    <h2>9. Hubungi Kami</h2>
    <p>
        Jika Anda memiliki pertanyaan mengenai kebijakan privasi ini, silakan hubungi kami:
    </p>
    <ul>
        <li><strong>Email:</strong> connect@myesc.id</li>
        <li><strong>Website:</strong> https://myesc.id</li>
        <li><strong>Aplikasi:</strong> mydc+ by EscIntech</li>
    </ul>

</div>

<div class="footer">
    © <?= date('Y') ?> mydc+ by EscIntech. All rights reserved.
</div>

</body>
</html>