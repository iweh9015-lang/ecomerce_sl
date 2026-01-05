{{-- ======================================== FILE:
resources/views/tentang.blade.php FUNGSI: Halaman tentang toko online
======================================== --}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    {{-- ↑ Encoding karakter --}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- ↑ Responsive untuk mobile --}}

    <title>Tentang Kami</title>

    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        h1 {
            color: #4f46e5;
            /* Warna indigo */
        }
    </style>
</head>

<body>
    <h1>Tentang Toko Online</h1>
    <p>Selamat datang di toko online kami.</p>
    <p>Dibuat dengan ❤️ menggunakan Laravel.</p>

    {{-- ================================================ BLADE SYNTAX: {{ }}
    ================================================ Kurung kurawal ganda
    digunakan untuk menampilkan data PHP Data otomatis di-escape untuk mencegah
    XSS attack ================================================ --}}
    <p>Waktu saat ini: {{ now()->format('d M Y, H:i:s') }}</p>
    {{-- ↑ now() = Fungsi Laravel untuk waktu sekarang ↑ ->format() = Format
    tanggal sesuai pattern ↑ d M Y, H:i:s = 11 Dec 2024, 14:30:00 --}}
    <a href="{{ route('produk.detail', ['id' => 1]) }}">Lihat Produk 1</a>
    <a href="{{ route('produk.detail', ['id' => 2]) }}">Lihat Produk 2</a>
    <a href="/">← Kembali ke Home</a>
    {{-- ↑ Link biasa ke halaman utama --}}
</body>

</html>