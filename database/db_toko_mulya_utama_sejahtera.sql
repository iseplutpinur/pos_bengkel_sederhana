-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 05 Okt 2020 pada 08.17
-- Versi server: 10.3.15-MariaDB
-- Versi PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko_mulya_utama_sejahtera`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_data`
--

CREATE TABLE `tb_barang_data` (
  `id_barang_data` int(11) NOT NULL,
  `id_barang_kategori` int(11) NOT NULL,
  `barang_data_nama` varchar(200) COLLATE utf8_bin NOT NULL,
  `barang_data_kode` varchar(100) COLLATE utf8_bin NOT NULL,
  `barang_data_harga_beli` int(255) NOT NULL,
  `barang_data_harga_jual` int(255) NOT NULL,
  `barang_data_tanggal` date NOT NULL,
  `barang_data_warna` varchar(255) COLLATE utf8_bin NOT NULL,
  `barang_data_stok` bigint(20) NOT NULL,
  `barang_data_diskon` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_barang_data`
--

INSERT INTO `tb_barang_data` (`id_barang_data`, `id_barang_kategori`, `barang_data_nama`, `barang_data_kode`, `barang_data_harga_beli`, `barang_data_harga_jual`, `barang_data_tanggal`, `barang_data_warna`, `barang_data_stok`, `barang_data_diskon`) VALUES
(2, 1, 'Tari Kreasi Baru Sulawesi Selatan', '9786028262040', 90000, 100000, '2020-10-02', 'Putih Hijau', 50, 35),
(3, 1, 'Terjemah juz\\\'ama', '9799791247008', 20000, 25000, '2020-10-02', 'Merah Kuning', 1000, 0),
(4, 1, 'Buku Pintar Dan atlas indonesia dan dunia', '9786023650019', 20000, 25000, '2020-10-02', 'Biru - Kuning', 1000, 0),
(5, 1, 'Memahami Sains Dari Alam: GUNUNG', '9789791760935', 30000, 35000, '2020-10-01', 'Hijau Putih', 200, 0),
(6, 1, 'JURUS AMPUH MENGATASI OKNUM WARTAWAN NAKAL', '9789791724203', 50000, 55000, '2020-10-02', 'Hijau', 50, 0),
(7, 1, 'Alam dan Ekologi', '9789790291041', 10000, 11000, '2020-10-02', 'Hijau', 49, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_kategori`
--

CREATE TABLE `tb_barang_kategori` (
  `id_barang_kategori` int(11) NOT NULL,
  `barang_kategori_nama` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_barang_kategori`
--

INSERT INTO `tb_barang_kategori` (`id_barang_kategori`, `barang_kategori_nama`) VALUES
(8, 'Ban'),
(1, 'Buku'),
(10, 'Elektronik'),
(12, 'Kaca'),
(21, 'Lain-Lain'),
(23, 'Lainnya'),
(24, 'Other'),
(29, 'Pintu Mobil'),
(13, 'Spion'),
(9, 'Velg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_keluar`
--

CREATE TABLE `tb_barang_keluar` (
  `id_barang_keluar` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `barang_keluar_kode_transaksi` varchar(250) COLLATE utf8_bin NOT NULL,
  `barang_keluar_nomor` int(11) NOT NULL,
  `barang_keluar_tanggal` date NOT NULL DEFAULT current_timestamp(),
  `barang_data_waktu` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_barang_keluar`
--

INSERT INTO `tb_barang_keluar` (`id_barang_keluar`, `id_user`, `barang_keluar_kode_transaksi`, `barang_keluar_nomor`, `barang_keluar_tanggal`, `barang_data_waktu`) VALUES
(1, 2, 'TR202010030001', 1, '2020-10-03', '19:11:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_keluar_data`
--

CREATE TABLE `tb_barang_keluar_data` (
  `id_barang_keluar_data` int(11) NOT NULL,
  `id_barang_keluar` int(11) NOT NULL,
  `id_barang_data` int(11) NOT NULL,
  `barang_keluar_data_diskon` float NOT NULL,
  `barang_keluar_data_jumlah` int(11) NOT NULL,
  `barang_keluar_data_harga` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_barang_keluar_data`
--

INSERT INTO `tb_barang_keluar_data` (`id_barang_keluar_data`, `id_barang_keluar`, `id_barang_data`, `barang_keluar_data_diskon`, `barang_keluar_data_jumlah`, `barang_keluar_data_harga`) VALUES
(1, 1, 7, 50, 1, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_keluar_data_sementara`
--

CREATE TABLE `tb_barang_keluar_data_sementara` (
  `id_barang_data` int(11) NOT NULL,
  `barang_keluar_data_nama` varchar(250) COLLATE utf8_bin NOT NULL,
  `barang_data_diskon` float NOT NULL,
  `barang_keluar_data_jumlah` int(11) NOT NULL,
  `barang_keluar_data_harga` bigint(20) NOT NULL,
  `barang_keluar_data_harga_asal` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_masuk`
--

CREATE TABLE `tb_barang_masuk` (
  `id_barang_masuk` int(11) NOT NULL,
  `id_barang_data` int(11) NOT NULL,
  `id_barang_suplier` int(11) NOT NULL,
  `barang_masuk_kode` varchar(250) COLLATE utf8_bin NOT NULL,
  `barang_masuk_jumlah` int(11) NOT NULL,
  `barang_masuk_harga` bigint(20) NOT NULL,
  `barang_masuk_tanggal` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang_suplier`
--

CREATE TABLE `tb_barang_suplier` (
  `id_barang_suplier` int(11) NOT NULL,
  `barang_suplier_nama` varchar(50) CHARACTER SET latin1 NOT NULL,
  `barang_suplier_kode` varchar(50) CHARACTER SET latin1 NOT NULL,
  `barang_suplier_no_telepon` varchar(20) CHARACTER SET latin1 NOT NULL,
  `barang_suplier_tanggal_daftar` date NOT NULL,
  `barang_suplier_alamat` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_barang_suplier`
--

INSERT INTO `tb_barang_suplier` (`id_barang_suplier`, `barang_suplier_nama`, `barang_suplier_kode`, `barang_suplier_no_telepon`, `barang_suplier_tanggal_daftar`, `barang_suplier_alamat`) VALUES
(1, 'Pt. Sakti Mantra Guna Indah', '2020-09-20-5f67565585854', '089123505', '2020-09-19', 'Banceuy Jawa Utara'),
(2, 'Muhidin bin syukur', '2020-09-20-5f6757b184019', '0943438463333', '2020-09-20', 'Kabupaten Ciamis'),
(3, 'Pt. Indah Makmur Sentausa', '2020-09-20-5f675b41b734a', '085798132505', '2020-09-20', 'Nusa Tenggara Timur');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengaturan`
--

CREATE TABLE `tb_pengaturan` (
  `id_pengaturan` int(11) NOT NULL,
  `pengaturan_title` varchar(50) CHARACTER SET latin1 NOT NULL,
  `pengaturan_nilai` text CHARACTER SET latin1 NOT NULL,
  `pengaturan_deskripsi` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_pengaturan`
--

INSERT INTO `tb_pengaturan` (`id_pengaturan`, `pengaturan_title`, `pengaturan_nilai`, `pengaturan_deskripsi`) VALUES
(1, 'nama_perusahaan', 'Toko Mulya Utama Sejahtera', 'Nilai ini akan ditampilkan pada judul halaman dan coopyright'),
(2, 'tahuncopyright', '2020', 'Tahun ini ditampilkan dibawah tepatnya di footer'),
(3, 'logo', 'bg.jpg', 'Logo halaman dashboard dan login'),
(4, 'laporan', 'Toko Mulya Utama Sejahtera$Alamat: Jl. Tipar Desa. Mekarwangi Kec. Cikadu Kab. Cianjur Jawa Barat 43272$Kepala Toko$Isep Lutpi Nur', 'Pengaturan untuk laporan untuk Header Alamat Dan nama Tanda Tangan tidak boleh memasukan karakter $\r\n'),
(5, 'default_home', 'page/home.php', 'Halaman dashboard default'),
(6, 'pengembangan', '1', 'Mode pengembangan bisa menambahkan Menghapus dan mengubah Menu dan sub menu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `user_username` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_email` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_nama` varchar(200) COLLATE utf8_bin NOT NULL,
  `user_alamat` varchar(1000) COLLATE utf8_bin NOT NULL,
  `user_gender` enum('Laki-Laki','Perempuan') COLLATE utf8_bin NOT NULL,
  `user_tanggal_lahir` date NOT NULL,
  `user_nik` bigint(11) NOT NULL,
  `user_no_telepon` varchar(15) COLLATE utf8_bin NOT NULL,
  `user_foto` varchar(200) COLLATE utf8_bin NOT NULL,
  `user_tanggal_daftar` date NOT NULL,
  `user_active` enum('0','1') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `id_level`, `user_username`, `user_password`, `user_email`, `user_nama`, `user_alamat`, `user_gender`, `user_tanggal_lahir`, `user_nik`, `user_no_telepon`, `user_foto`, `user_tanggal_daftar`, `user_active`) VALUES
(2, 2, 'admin', '$2y$10$Pq.0ieUqK2NDaejBOqI2HuRH3d0gjkjZhpLeVowKGIhrU111ZStCK', 'iseplutpinur@gmail.com', 'Isep Lutpi Nur', 'Mekarwangi', 'Laki-Laki', '2000-08-10', 5345254, '085798132505', '5f70c00900fa1.jpg', '2020-09-07', '1'),
(3, 3, 'Kasir', '$2y$10$BK4K1rN9bqeGcNvoCeJ1jO2IKJID95viYE.x8FgZDxM9F4crr.N2y', '31@gmail.com', 'Kasir', '0', 'Laki-Laki', '2020-09-09', 234234, '0346546757', 'Kasir_5f65e8b08f909.jpg', '2020-09-08', '0'),
(4, 6, 'user', '$2y$10$RcXYFWVWeSHwc/O56wsvd.ndcJNsQVmWUnMTQvtTC6MkTARxFRqKu', '41@gmail.com', 'Isep Lutpi', '0', 'Laki-Laki', '2020-09-09', 3243243242342, '02465734', 'user_5f65e8b0c779e.jpg', '2020-09-08', '0'),
(10, 7, 'nurul', '$2y$10$BK4K1rN9bqeGcNvoCeJ1jO2IKJID95viYE.x8FgZDxM9F4crr.N2y', '41@gmail.comd', 'Nurul Husnul', '0', 'Perempuan', '2020-09-09', 324234234234, '056768654', 'nurul_5f65e891052f4.jpg', '2020-09-21', '0'),
(15, 2, 'user_acak_adut', '$2y$10$ZAih/WS1n0NZRguwQhz07uZdMFAqMaFw07QCKTWMzGWSge8Hyoara', 'f1@gmail.com', 'admin', '0', 'Laki-Laki', '2020-09-09', 34252452523453425, '034675342', 'user_5f65e8911d99a.jpg', '2020-09-14', '1'),
(16, 1, 'iseplutpi', '$2y$10$Cn63wWN1LKVvMumpAp0yyeyOtc95F/YhHelI4Xk3GJxKPyEbLSLIe', 'd1dgmail.com', 'Isep Lutpi Nur', '0', 'Laki-Laki', '2020-09-09', 23453253245, '0354675432', 'iseplutpi_5f67525b81b35.jpg', '2020-09-08', '0'),
(19, 2, 'dsfasdfsdf', '$2y$10$s2K1Y6ier6UnwCoO9N91qu4DZ7QXrgs15Cre5qad6Qqv8FHQW6mKi', 'sadfadsf@dafd.com', 'Isep haha', 'sdfgsdgdsfg', 'Laki-Laki', '2020-09-03', 9223372036854775807, '43253245245435', 'dsfasdfsdf_5f749bd5daa14.jpg', '2020-09-14', '1'),
(23, 6, 'coba', '$2y$10$HkmI7mlCao1LkxP6EtzeM.NV0BktKLDsTRv1WAtSYvQzbuVRw4D8G', 'sadfadsf@dafd.dsfsdf', 'Isep haha', 'adsfsadfasfas', 'Perempuan', '2020-09-02', 34523453245, '43253245245', '3253245345_5f749c9163365.jpg', '2020-09-29', '1'),
(24, 2, 'dsfasdfsdf2345', '$2y$10$djclifecYssG/5rnf28jRO9TSVQOl.QZeoHhuMlbn3TTBjRcxwc5e', 'dfsafadsfasd@gmail.comsadf', 'Isep hahafdgdf', 'dsgdsfg', 'Laki-Laki', '2020-09-16', 3425234534253453451, '345345', 'dsfasdfsdf2345_5f749cdb6db02.jpg', '2020-09-21', '0'),
(29, 2, 'ewrrqrqwedsgfsdfg', '$2y$10$g1YJESWUZGl.uRxFVENmDuYgXcaQOftIiFTkx1nTBoWJA8iY/C.b6', 'sadfadsf@dafd.comdfsg', 'Isep haha', 'dsfgsdgfsdgf', 'Laki-Laki', '2020-09-03', 1232434354565, '432532452455464', 'ewrrqrqwedsgfsdfg_5f749fdcb8cde.jpg', '2020-09-07', '0'),
(30, 2, 'sdfghjkjdfrs', '$2y$10$QCwbAVBAMHLEkHxLZlHmxOVrpAGxGdYDArLvktKM3QOx9m.OBVquW', 'sadfadsf@dafd.comdsfghjk', 'Isep haha', 'sfdghfdsadsfghjk', 'Laki-Laki', '2020-09-10', 1234567876543234567, '432532452453245', 'sdfghjkjdfrs_5f74a2f68ccb1.jpg', '2020-09-29', '0'),
(35, 3, 'sitinurlaela', '$2y$10$5RLS6jCNoQ.IGjNLKA5qHOiucpD12i6onPcNTQgz6IJUFvPuKnZhW', 'sitinurlaela@gmail.com', 'Siti Nurlaela', 'Cianjur Jawa Barat', 'Perempuan', '2001-10-21', 123456789123, '+62483953457346', '5f780687bb757.jpg', '0000-00-00', '1'),
(37, 3, 'dsgs345', '$2y$10$ljS59mMVN4RO1U36znOcLO7oesq077zpTSaB.kUxyvl4hxEYwOGo.', '25434@gmail.com', 'Isep haha', 'fdhshdgh', 'Laki-Laki', '2020-10-03', 45253247316476, '345250009988666', 'dsgs345_5f7818772c86e.jpg', '2020-10-03', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_level`
--

CREATE TABLE `tb_user_level` (
  `id_level` int(11) NOT NULL,
  `level_title` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_user_level`
--

INSERT INTO `tb_user_level` (`id_level`, `level_title`) VALUES
(2, 'Administrator'),
(3, 'Kasir'),
(7, 'Manager'),
(1, 'Pimpinan'),
(6, 'Supervisor'),
(4, 'User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_menu`
--

CREATE TABLE `tb_user_menu` (
  `id_menu` int(11) NOT NULL,
  `menu_title` varchar(128) COLLATE utf8_bin NOT NULL,
  `menu_icon` varchar(255) COLLATE utf8_bin NOT NULL,
  `menu_url` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_user_menu`
--

INSERT INTO `tb_user_menu` (`id_menu`, `menu_title`, `menu_icon`, `menu_url`) VALUES
(2, 'Data Transaksi', 'fa fa-cash-register', 'transaksi'),
(3, 'Laporan', 'fa fa-copy', 'laporan'),
(4, 'Data Master', 'fa fa-database', 'data_master'),
(5, 'Data Pengguna', 'fa fa-user', 'pengguna'),
(6, 'Menu Mnajemen', 'fa fa-folder', 'menumanagement'),
(33, 'Pengaturan', 'fa fa-cog', 'pengaturan'),
(35, 'Muhidin bin syukur', 'fa fa-copy', 'page/home.php');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_menu_access`
--

CREATE TABLE `tb_user_menu_access` (
  `id_menu` int(11) NOT NULL,
  `id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_user_menu_access`
--

INSERT INTO `tb_user_menu_access` (`id_menu`, `id_level`) VALUES
(5, 1),
(6, 2),
(4, 2),
(3, 2),
(2, 2),
(2, 1),
(3, 1),
(6, 1),
(4, 1),
(33, 1),
(5, 2),
(35, 2),
(2, 3),
(5, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_sub_menu`
--

CREATE TABLE `tb_user_sub_menu` (
  `id_submenu` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `submenu_title` varchar(128) COLLATE utf8_bin NOT NULL,
  `submenu_url` varchar(50) COLLATE utf8_bin NOT NULL,
  `submenu_file` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_user_sub_menu`
--

INSERT INTO `tb_user_sub_menu` (`id_submenu`, `id_menu`, `submenu_title`, `submenu_url`, `submenu_file`) VALUES
(1, 5, 'Data Pengguna', 'pengguna', 'page/data_pengguna/pengguna/switcher.php'),
(2, 5, 'Profile Saya', 'profile', 'page/data_pengguna/profile/profile.php'),
(3, 6, 'Menu Manajemen', 'menumanagement', 'page/menu_management/menu_management/switcher.php'),
(5, 6, 'SubMenu Manajemen', 'submenumanagement', 'page/menu_management/submenu_management/switcher.php'),
(17, 6, 'Hak Akses', 'hak_akses', 'page/menu_management/hak_akses/switcher.php'),
(20, 4, 'Data Kategori Barang', 'kategori', 'page/data_master/kategori/display.php'),
(21, 4, 'Data Barang', 'barang', 'page/data_master/barang/barang.php'),
(22, 4, 'Data Konsumen', 'konsumen', 'page/data_master/konsumen/konsumen.php'),
(24, 3, 'Laporan Barang', 'barang', 'page/data_master/barang/laporan.php'),
(25, 3, 'Laporan Konsumen', 'konsumen', 'page/data_master/konsumen/laporan.php'),
(26, 3, 'Laporan Kategori', 'kategori', 'page/data_master/kategori/laporan.php'),
(27, 3, 'Laporan Penjualan', 'penjualan', 'page/data_transaksi/barang_keluar/laporan.php'),
(34, 5, 'Data Level', 'level', 'page/data_pengguna/level/display.php'),
(37, 2, 'Data Pengadaan', 'barang_masuk', 'page/data_transaksi/barang_masuk/display.php'),
(39, 4, 'Data Suplier', 'data_suplier', 'page/data_master/suplier/switcher.php'),
(43, 33, 'Applikasi', 'app', 'page/pengaturan/aplikasi/display.php'),
(44, 33, 'Laporan', 'laporan', 'page/pengaturan/laporan/display.php'),
(45, 3, 'Laporan Pengadaan', 'pengadaan', 'page/data_transaksi/barang_masuk/laporan.php'),
(47, 2, 'Data Penjualan', 'barang_keluar', 'page/data_transaksi/barang_keluar/display.php'),
(48, 3, 'Laporan Suplier', 'suplier', 'page/data_master/suplier/laporan.php'),
(53, 6, 'Hak Akses 2', 'hak_akses_2', 'page/menu_management/hak_akses_2/switcher.php');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_sub_menu_access`
--

CREATE TABLE `tb_user_sub_menu_access` (
  `id_submenu` int(11) NOT NULL,
  `id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_user_sub_menu_access`
--

INSERT INTO `tb_user_sub_menu_access` (`id_submenu`, `id_level`) VALUES
(5, 2),
(1, 1),
(1, 2),
(17, 2),
(2, 2),
(3, 2),
(20, 2),
(21, 2),
(22, 2),
(24, 2),
(26, 2),
(27, 2),
(34, 2),
(34, 1),
(2, 1),
(27, 1),
(24, 1),
(25, 1),
(26, 1),
(3, 1),
(22, 1),
(21, 1),
(20, 1),
(17, 1),
(5, 1),
(37, 1),
(38, 2),
(38, 1),
(38, 1),
(37, 2),
(43, 1),
(44, 1),
(45, 1),
(45, 2),
(47, 1),
(48, 2),
(43, 2),
(39, 2),
(39, 4),
(39, 6),
(47, 2),
(48, 1),
(44, 2),
(25, 2),
(37, 3),
(47, 3),
(2, 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang_data`
--
ALTER TABLE `tb_barang_data`
  ADD PRIMARY KEY (`id_barang_data`),
  ADD UNIQUE KEY `barang_data_nama` (`barang_data_nama`),
  ADD UNIQUE KEY `barang_data_nama_2` (`barang_data_nama`),
  ADD UNIQUE KEY `barang_data_kode` (`barang_data_kode`),
  ADD KEY `id_barang_kategori` (`id_barang_kategori`);

--
-- Indeks untuk tabel `tb_barang_kategori`
--
ALTER TABLE `tb_barang_kategori`
  ADD PRIMARY KEY (`id_barang_kategori`),
  ADD UNIQUE KEY `barang_kategori_nama` (`barang_kategori_nama`);

--
-- Indeks untuk tabel `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tb_barang_keluar_data`
--
ALTER TABLE `tb_barang_keluar_data`
  ADD PRIMARY KEY (`id_barang_keluar_data`),
  ADD KEY `id_barang_data` (`id_barang_data`),
  ADD KEY `id_barang_keluar` (`id_barang_keluar`);

--
-- Indeks untuk tabel `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_barang_suplier` (`id_barang_suplier`),
  ADD KEY `id_barang_data` (`id_barang_data`);

--
-- Indeks untuk tabel `tb_barang_suplier`
--
ALTER TABLE `tb_barang_suplier`
  ADD PRIMARY KEY (`id_barang_suplier`),
  ADD UNIQUE KEY `barang_suplier_nama` (`barang_suplier_nama`),
  ADD UNIQUE KEY `barang_suplier_nama_2` (`barang_suplier_nama`);

--
-- Indeks untuk tabel `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`),
  ADD UNIQUE KEY `pengaturan_title` (`pengaturan_title`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`user_username`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_no_telepon` (`user_no_telepon`),
  ADD UNIQUE KEY `user_nik` (`user_nik`),
  ADD KEY `id_level` (`id_level`);

--
-- Indeks untuk tabel `tb_user_level`
--
ALTER TABLE `tb_user_level`
  ADD PRIMARY KEY (`id_level`),
  ADD UNIQUE KEY `title` (`level_title`);

--
-- Indeks untuk tabel `tb_user_menu`
--
ALTER TABLE `tb_user_menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD UNIQUE KEY `menu_url` (`menu_url`),
  ADD UNIQUE KEY `menu_title` (`menu_title`);

--
-- Indeks untuk tabel `tb_user_menu_access`
--
ALTER TABLE `tb_user_menu_access`
  ADD KEY `id_user_level` (`id_level`),
  ADD KEY `menu_id` (`id_menu`);

--
-- Indeks untuk tabel `tb_user_sub_menu`
--
ALTER TABLE `tb_user_sub_menu`
  ADD PRIMARY KEY (`id_submenu`),
  ADD UNIQUE KEY `menu_id` (`id_menu`,`submenu_url`),
  ADD UNIQUE KEY `title` (`submenu_title`),
  ADD KEY `id` (`id_submenu`);

--
-- Indeks untuk tabel `tb_user_sub_menu_access`
--
ALTER TABLE `tb_user_sub_menu_access`
  ADD KEY `id_user_level` (`id_level`),
  ADD KEY `sub_menu_id` (`id_submenu`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_barang_data`
--
ALTER TABLE `tb_barang_data`
  MODIFY `id_barang_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_barang_kategori`
--
ALTER TABLE `tb_barang_kategori`
  MODIFY `id_barang_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  MODIFY `id_barang_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  MODIFY `id_barang_masuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_barang_suplier`
--
ALTER TABLE `tb_barang_suplier`
  MODIFY `id_barang_suplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  MODIFY `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `tb_user_level`
--
ALTER TABLE `tb_user_level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_user_menu`
--
ALTER TABLE `tb_user_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `tb_user_sub_menu`
--
ALTER TABLE `tb_user_sub_menu`
  MODIFY `id_submenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_barang_data`
--
ALTER TABLE `tb_barang_data`
  ADD CONSTRAINT `tb_barang_data_ibfk_1` FOREIGN KEY (`id_barang_kategori`) REFERENCES `tb_barang_kategori` (`id_barang_kategori`);

--
-- Ketidakleluasaan untuk tabel `tb_barang_keluar`
--
ALTER TABLE `tb_barang_keluar`
  ADD CONSTRAINT `tb_barang_keluar_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_barang_keluar_data`
--
ALTER TABLE `tb_barang_keluar_data`
  ADD CONSTRAINT `tb_barang_keluar_data_ibfk_1` FOREIGN KEY (`id_barang_data`) REFERENCES `tb_barang_data` (`id_barang_data`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_barang_keluar_data_ibfk_2` FOREIGN KEY (`id_barang_keluar`) REFERENCES `tb_barang_keluar` (`id_barang_keluar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD CONSTRAINT `tb_barang_masuk_ibfk_1` FOREIGN KEY (`id_barang_suplier`) REFERENCES `tb_barang_suplier` (`id_barang_suplier`),
  ADD CONSTRAINT `tb_barang_masuk_ibfk_2` FOREIGN KEY (`id_barang_data`) REFERENCES `tb_barang_data` (`id_barang_data`);

--
-- Ketidakleluasaan untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `tb_user_level` (`id_level`);

--
-- Ketidakleluasaan untuk tabel `tb_user_menu_access`
--
ALTER TABLE `tb_user_menu_access`
  ADD CONSTRAINT `tb_user_menu_access_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `tb_user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_user_menu_access_ibfk_2` FOREIGN KEY (`id_level`) REFERENCES `tb_user_level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_user_sub_menu`
--
ALTER TABLE `tb_user_sub_menu`
  ADD CONSTRAINT `tb_user_sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `tb_user_menu` (`id_menu`);

--
-- Ketidakleluasaan untuk tabel `tb_user_sub_menu_access`
--
ALTER TABLE `tb_user_sub_menu_access`
  ADD CONSTRAINT `tb_user_sub_menu_access_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `tb_user_level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_user_sub_menu_access_ibfk_2` FOREIGN KEY (`id_level`) REFERENCES `tb_user_level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
