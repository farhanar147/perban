-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2023 at 05:57 PM
-- Server version: 8.0.34-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farhanp1_perban`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(225) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nik`, `nama`, `no_hp`, `email`, `password`) VALUES
(1, '34560909897867', 'admin 1', '0812980973', 'admin@perban.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bencana`
--

CREATE TABLE `tb_bencana` (
  `id_bencana` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_akhir` date NOT NULL,
  `bencana` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_regional` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_bencana`
--

INSERT INTO `tb_bencana` (`id_bencana`, `tanggal`, `waktu_akhir`, `bencana`, `id_regional`) VALUES
(1, '2023-09-01', '2023-11-08', 'Banjir X', 1),
(2, '2023-09-03', '2023-09-10', 'Longsor Xy', 1),
(3, '2023-09-03', '2023-09-08', 'Gempa Xv', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_donasi`
--

CREATE TABLE `tb_donasi` (
  `id_donasi` int NOT NULL,
  `id_donatur` int NOT NULL,
  `id_bencana` int NOT NULL,
  `kode_donasi` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `waktu_donasi` date NOT NULL,
  `beras` int NOT NULL,
  `sembako` int NOT NULL,
  `pakaian_perempuan` int NOT NULL,
  `pakaian_laki_laki` int NOT NULL,
  `popok_bayi` int NOT NULL,
  `makanan_bayi` int NOT NULL,
  `susu_bayi` int NOT NULL,
  `lainnya` int NOT NULL,
  `gambar_donasi` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` int NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_donasi`
--

INSERT INTO `tb_donasi` (`id_donasi`, `id_donatur`, `id_bencana`, `kode_donasi`, `waktu_donasi`, `beras`, `sembako`, `pakaian_perempuan`, `pakaian_laki_laki`, `popok_bayi`, `makanan_bayi`, `susu_bayi`, `lainnya`, `gambar_donasi`, `keterangan`, `status`) VALUES
(1, 4, 1, 'GZ5I6', '2023-09-03', 30, 100, 20, 20, 52, 52, 108, 10, '1.jpg', 2, 2),
(36, 4, 2, 'BUGSI', '2023-09-03', 88, 220, 110, 110, 30, 30, 120, 100, '2.jpg', 1, 2),
(37, 4, 3, 'ZA2S6', '2023-09-03', 20, 50, 20, 30, 40, 40, 160, 100, '3.jpg', 1, 2),
(38, 7, 1, 'E2SR9', '2023-09-03', 40, 100, 100, 30, 20, 20, 200, 100, '4.jpg', 2, 2),
(39, 9, 1, 'UWZBQ', '2023-09-03', 50, 100, 100, 30, 30, 30, 100, 30, '1.jpg', 2, 2),
(40, 4, 3, 'BEDWI', '2023-09-05', 10, 10, 0, 0, 10, 10, 0, 0, 'IMG-20230905-WA0000.jpg', 2, 2),
(41, 4, 2, 'FOBQO', '2023-09-07', 10, 10, 10, 10, 0, 0, 150, 0, 'IMG-20230906-WA0000.jpg', 1, 2),
(42, 4, 2, 'VCLCM', '2023-09-08', 10, 10, 100, 100, 10, 10, 10, 0, '3.jpg', 1, 1),
(43, 4, 3, '2AGRP', '2023-09-08', 100, 100, 100, 100, 100, 100, 100, 100, '2.jpg', 2, 2);

--
-- Triggers `tb_donasi`
--
DELIMITER $$
CREATE TRIGGER `donasi_masuk` AFTER INSERT ON `tb_donasi` FOR EACH ROW BEGIN
   UPDATE tb_tdonasi SET beras = beras + NEW.beras
   WHERE id_bencana = NEW.id_bencana;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_donatur`
--

CREATE TABLE `tb_donatur` (
  `id_donatur` int NOT NULL,
  `NIK` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_donatur`
--

INSERT INTO `tb_donatur` (`id_donatur`, `NIK`, `nama`, `email`, `password`) VALUES
(1, '317509876765', 'aldy', 'farhan@gmail.com', '12345'),
(2, '23233', 'coba', 'rumahkomputer55@gmail.com', '12345'),
(3, '31548249248', 'Rehwa', 'rehwa@gmail.com', '12345'),
(4, '317595045405', 'farhan', 'farhanarrasyid08@gmail.com', 'aangar147'),
(5, '65231556154652', 'Novi', 'novitas@gmail.con', 'awan1204'),
(7, '12131415161718', 'Joseph Victorio', 'joseph.victoriob@gmail.com', 'maumasuk'),
(8, '123456789101112', 'Satria Fikasih', 'satriafikasih922@gmail.com', 'satria1234'),
(9, '3124561075491', 'Sultan', 'sultananjay@gmail.com', 'sultanaku'),
(10, '128424827', 'Firman', 'firman@gmail.com', '1234'),
(18, '314569852358', 'Budi', 'budi@gmail.com', '12345'),
(19, '123564957954', 'Rasyid', 'rasyid@gmail.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `tb_news`
--

CREATE TABLE `tb_news` (
  `id_news` int NOT NULL,
  `gambar` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `judul` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `news` text COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `penulis` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `referensi` varchar(225) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_news`
--

INSERT INTO `tb_news` (`id_news`, `gambar`, `judul`, `news`, `date`, `penulis`, `referensi`) VALUES
(1, 'banjir.jpg', 'Penyaluran Bantuan untuk Korban Gempa Cianjur Tidak Merata', 'BUPATI Cianjur Herman Suherman mengakui, penyaluran bantuan di posko pengungsian Cianjur belum merata. Hal itu disebabkan banyak bantuan yang tidak disalurkan melalui posko terpadu yang telah disediakan oleh pemerintah daerah Cianjur. \"Sebagai evaluasi kami di lapangan, sekarang pembagian bantuan-bantuan tidak merata. Ada di posko-posko penumpukan bantuan. Ada juga di posko yang di dalam tidak optimal menerima bantuan tersebut,\" kata Herman dalam konferensi pers, Rabu (30/11). Untuk itu, ia menyampaikan agar warga ataupun relawan yang hendak memberikan donasi kepada korban bencan Cianjur agar menyalurkannya kepada posko-posko yang telah dibentuk oleh pemerintah daeraah ataupun Kodim 0608 Cianjur. \"Segingga penyampaian secara pribadi dari organsiasi lembaga tidak langsung ke lokasi-lokasi bencana alam,\" imbuh dia.\r\n', '2023-05-26', 'Atalya Puspa', 'https://mediaindonesia.com/nusantara/541287/penyaluran-bantuan-untuk-korban-gempa-cianjur-tidak-merata'),
(2, 'palu.png', 'Mengenang Dahsyatnya Gempa Palu di Kampung Jateng', 'PALU – Gubernur Jawa Tengah Ganjar Pranowo, Selasa (17/9/2019) mengunjungi Kota Palu yang tengah berbenah pasca dilanda gempa, likuifaksi dan tsunami dahsyat satu tahun silam. Di Kampung Jateng, Ganjar bersua dengan warga yang masih trauma pada bencana yang menelan korban ribuan jiwa.\r\n\r\nKampung Jateng merupakan kawasan hunian sementara yang dibangun oleh Pemprov dan masyarakat Jawa Tengah di Petobo untuk korban gempa. Ada 100 KK yang menempati 100 Huntara itu. Saat kali pertama berkunjung ke Palu usai bencana tersebut, Ganjar mengatakan lahan tersebut masih berupa tanah lapang tanpa hunian.\r\n\r\n“Waktu itu temen-temen dari Jawa Tengah menyumbangkan tenaga pikiran dan material untuk saudara-saudara di sini. Waktu saya datang ini masih kosong kemudian dibangunlah Huntara dan alhamdulilah bisa dipakai,” kata Ganjar.\r\n\r\nGanjar mengatakan saat ini pemerintah Sulawesi Tengah sedang menyelesaikan proses pembangunan hunian tetap untuk warga korban gempa dan tsunami. Dia berharap pembangunan yang dilakukan di daerah Tondo Kecamatan Mantikulore, Kota Palu segera rampung.', '2023-05-29', 'ANDI', 'https://jatengprov.go.id/publik/mengenang-dahsyatnya-gempa-palu-di-kampung-jateng/');

-- --------------------------------------------------------

--
-- Table structure for table `tb_posko`
--

CREATE TABLE `tb_posko` (
  `id_posko` int NOT NULL,
  `kode_posko` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `perempuan` int NOT NULL,
  `laki_laki` int NOT NULL,
  `balita` int NOT NULL,
  `total` int NOT NULL,
  `id_bencana` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_posko`
--

INSERT INTO `tb_posko` (`id_posko`, `kode_posko`, `perempuan`, `laki_laki`, `balita`, `total`, `id_bencana`) VALUES
(1, 'Posko 1 Banjir X', 125, 35, 55, 215, 1),
(2, 'Posko 2 Banjir X', 100, 50, 50, 200, 1),
(3, 'Posko 1 Longsor Xy', 10, 10, 10, 30, 2),
(4, 'Posko 2 Longsor Xy', 100, 100, 20, 220, 2),
(5, 'Posko 1 Gempa Xv', 30, 20, 40, 90, 3),
(10, 'Posko 2 Gempa Xv', 0, 0, 0, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_regional`
--

CREATE TABLE `tb_regional` (
  `id_regional` int NOT NULL,
  `provinsi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `kota` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `kecamatan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `kelurahan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_regional`
--

INSERT INTO `tb_regional` (`id_regional`, `provinsi`, `kota`, `kecamatan`, `kelurahan`) VALUES
(1, 'DKI Jakarta', 'Jakarta Timur', 'Pasar Rebo', 'Pekayon'),
(2, 'Jawa Barat', 'Depok', 'Cipayung', 'Pondok terong'),
(3, 'Riau', 'Dumai', 'Bukit Kapur', 'Gurun Panjang'),
(5, 'DKI Jakarta', 'Jakarta Timur', 'Pasar Rebo', 'Cijantung');

-- --------------------------------------------------------

--
-- Table structure for table `tb_relawan`
--

CREATE TABLE `tb_relawan` (
  `id_relawan` int NOT NULL,
  `nik` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_general_ci NOT NULL,
  `id_posko` int NOT NULL,
  `email` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(225) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_relawan`
--

INSERT INTO `tb_relawan` (`id_relawan`, `nik`, `nama`, `no_hp`, `id_posko`, `email`, `password`) VALUES
(1, '317509898898', 'Rasyid', '081298009878', 5, 'rasyid@perban.id', '12345'),
(2, '317278190990', 'relawan 1', '081234090989', 2, 'relawan@perban.com', 'relawan123'),
(6, '2562512516521', 'Tiwi', '0845678998', 10, 'tiwi@gmail.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tdonasi`
--

CREATE TABLE `tb_tdonasi` (
  `id_tdonasi` int NOT NULL,
  `id_bencana` int NOT NULL,
  `id_posko` int NOT NULL,
  `waktu` date NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `beras` int NOT NULL,
  `sembako` int NOT NULL,
  `pakaianp` int NOT NULL,
  `pakaianl` int NOT NULL,
  `popokb` int NOT NULL,
  `makananb` int NOT NULL,
  `susub` int NOT NULL,
  `lain` int NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_tdonasi`
--

INSERT INTO `tb_tdonasi` (`id_tdonasi`, `id_bencana`, `id_posko`, `waktu`, `kode`, `beras`, `sembako`, `pakaianp`, `pakaianl`, `popokb`, `makananb`, `susub`, `lain`, `status`) VALUES
(3, 1, 2, '2023-09-03', 'ZFJZM', 60, 150, 100, 50, 51, 51, 204, 280, 2),
(4, 3, 5, '2023-09-08', 'SIDTC', 130, 160, 120, 130, 150, 150, 260, 200, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tb_bencana`
--
ALTER TABLE `tb_bencana`
  ADD PRIMARY KEY (`id_bencana`),
  ADD KEY `id_regional` (`id_regional`);

--
-- Indexes for table `tb_donasi`
--
ALTER TABLE `tb_donasi`
  ADD PRIMARY KEY (`id_donasi`),
  ADD KEY `id_bencana` (`id_bencana`),
  ADD KEY `id_donatur` (`id_donatur`);

--
-- Indexes for table `tb_donatur`
--
ALTER TABLE `tb_donatur`
  ADD PRIMARY KEY (`id_donatur`);

--
-- Indexes for table `tb_news`
--
ALTER TABLE `tb_news`
  ADD PRIMARY KEY (`id_news`);

--
-- Indexes for table `tb_posko`
--
ALTER TABLE `tb_posko`
  ADD PRIMARY KEY (`id_posko`),
  ADD KEY `id_bencana` (`id_bencana`);

--
-- Indexes for table `tb_regional`
--
ALTER TABLE `tb_regional`
  ADD PRIMARY KEY (`id_regional`);

--
-- Indexes for table `tb_relawan`
--
ALTER TABLE `tb_relawan`
  ADD PRIMARY KEY (`id_relawan`),
  ADD KEY `id_posko` (`id_posko`);

--
-- Indexes for table `tb_tdonasi`
--
ALTER TABLE `tb_tdonasi`
  ADD PRIMARY KEY (`id_tdonasi`),
  ADD KEY `id_bencana` (`id_bencana`),
  ADD KEY `id_posko` (`id_posko`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_bencana`
--
ALTER TABLE `tb_bencana`
  MODIFY `id_bencana` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_donasi`
--
ALTER TABLE `tb_donasi`
  MODIFY `id_donasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tb_donatur`
--
ALTER TABLE `tb_donatur`
  MODIFY `id_donatur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_news`
--
ALTER TABLE `tb_news`
  MODIFY `id_news` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_posko`
--
ALTER TABLE `tb_posko`
  MODIFY `id_posko` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_regional`
--
ALTER TABLE `tb_regional`
  MODIFY `id_regional` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_relawan`
--
ALTER TABLE `tb_relawan`
  MODIFY `id_relawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_tdonasi`
--
ALTER TABLE `tb_tdonasi`
  MODIFY `id_tdonasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_bencana`
--
ALTER TABLE `tb_bencana`
  ADD CONSTRAINT `tb_bencana_ibfk_1` FOREIGN KEY (`id_regional`) REFERENCES `tb_regional` (`id_regional`);

--
-- Constraints for table `tb_donasi`
--
ALTER TABLE `tb_donasi`
  ADD CONSTRAINT `tb_donasi_ibfk_1` FOREIGN KEY (`id_bencana`) REFERENCES `tb_bencana` (`id_bencana`),
  ADD CONSTRAINT `tb_donasi_ibfk_2` FOREIGN KEY (`id_donatur`) REFERENCES `tb_donatur` (`id_donatur`);

--
-- Constraints for table `tb_posko`
--
ALTER TABLE `tb_posko`
  ADD CONSTRAINT `tb_posko_ibfk_1` FOREIGN KEY (`id_bencana`) REFERENCES `tb_bencana` (`id_bencana`);

--
-- Constraints for table `tb_relawan`
--
ALTER TABLE `tb_relawan`
  ADD CONSTRAINT `tb_relawan_ibfk_1` FOREIGN KEY (`id_posko`) REFERENCES `tb_posko` (`id_posko`);

--
-- Constraints for table `tb_tdonasi`
--
ALTER TABLE `tb_tdonasi`
  ADD CONSTRAINT `tb_tdonasi_ibfk_1` FOREIGN KEY (`id_bencana`) REFERENCES `tb_bencana` (`id_bencana`),
  ADD CONSTRAINT `tb_tdonasi_ibfk_2` FOREIGN KEY (`id_posko`) REFERENCES `tb_posko` (`id_posko`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
