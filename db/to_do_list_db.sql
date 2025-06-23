-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2025 at 10:11 PM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mgr12t_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `informasi_kuliah`
--

CREATE TABLE `informasi_kuliah` (
  `id` int(11) NOT NULL,
  `teks` text NOT NULL,
  `warna` varchar(20) NOT NULL DEFAULT '#000000',
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `urutan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `informasi_kuliah`
--

INSERT INTO `informasi_kuliah` (`id`, `teks`, `warna`, `tanggal`, `urutan`) VALUES
(3, 'INI PALING BAWAH', '#0d6efd', '2025-06-22 21:20:30', 3),
(5, '<p><strong>TEST 123 - INI PALING ATAS</strong></p>', '#000000', '2025-06-22 21:28:07', 0),
(7, '<ul><li><strong>ASDAWDAWDAWDWAD</strong></li></ul>', '#0d6efd', '2025-06-22 22:03:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kuliah`
--

CREATE TABLE `jadwal_kuliah` (
  `id` int(11) NOT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `mata_kuliah` varchar(100) DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `ruang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jadwal_kuliah`
--

INSERT INTO `jadwal_kuliah` (`id`, `hari`, `mata_kuliah`, `waktu`, `ruang`) VALUES
(1, 'Senin', 'PABD', '08.00 - 10.00', 'F4'),
(2, 'Selasa', 'PDW', '12.00 - 13.00', 'F5'),
(3, 'Senin', 'Pancasila', '07.00 - 09.00', 'F4.001'),
(4, 'Jumat', 'Inggris', '07.00 - 09.00', 'F4.002');

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_tugas` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_tugas` enum('belum','selesai') DEFAULT 'belum',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_deadline` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `id_user`, `nama_tugas`, `deskripsi`, `status_tugas`, `tanggal_dibuat`, `tanggal_deadline`) VALUES
(43, 26, 'Test', '123', 'belum', '2025-04-17 07:03:53', '2025-04-16 17:00:00'),
(49, 31, 'y', 'hewjb3dbjjbjb3db3wnbenbnbenbnnnnnbnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', 'selesai', '2025-04-29 04:44:19', '2025-04-28 17:00:00'),
(51, 28, 'stqa', 'asikk', 'belum', '2025-04-30 05:42:07', '2025-05-01 17:00:00'),
(54, 37, 'Bahsa Inggris', 'Membuat video kelompok 5', 'belum', '2025-05-07 02:28:27', '2025-08-04 17:00:00'),
(56, 37, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam fringilla, magna vitae sagittis cursus, diam sem feugiat mi, nec vehicula justo justo at turpis. Aenean pharetra ligula vel posuere pulvinar. Vivamus felis mauris, sollicitudin in orci id, co', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam fringilla, magna vitae sagittis cursus, diam sem feugiat mi, nec vehicula justo justo at turpis. Aenean pharetra ligula vel posuere pulvinar. Vivamus felis mauris, sollicitudin in orci id, convallis vehicula libero. Quisque tristique ligula lorem, a malesuada metus ultrices vitae. Sed sodales ligula non est viverra, et placerat ex tristique. Maecenas scelerisque tortor sed magna tincidunt lobortis. Duis cursus convallis sem in accumsan. Nullam bibendum finibus nibh ac semper. Mauris consequat, orci non elementum tempus, libero nulla lacinia turpis, nec dictum justo nisi quis felis. Curabitur quam sem, blandit a est non, tincidunt iaculis ante. Pellentesque efficitur vehicula egestas. Suspendisse ultricies purus quis tortor ullamcorper, a consectetur ante tempus. Donec imperdiet lectus elementum metus convallis dapibus. Phasellus egestas facilisis lacus at porttitor.\r\n\r\nDonec eget orci iaculis, convallis turpis ut, tempus libero. Aliquam luctus tortor sed est pulvinar finibus in vitae orci. Duis interdum at quam quis semper. Etiam bibendum nulla nibh, vitae gravida lacus pretium viverra. Donec at euismod neque, sit amet tempus magna. Ut nibh sem, malesuada sed convallis ullamcorper, facilisis sit amet mi. Aliquam hendrerit nulla lacus, a pellentesque ipsum pretium vestibulum. Quisque porta at turpis at semper. In ac leo ultricies, rutrum leo ut, malesuada magna. Vestibulum volutpat urna auctor tellus placerat, sit amet volutpat arcu blandit.\r\n\r\nIn hac habitasse platea dictumst. Maecenas sit amet leo non erat fringilla euismod. Aenean non placerat lorem, a mattis ligula. Proin elit mi, facilisis eu felis eu, rhoncus cursus dolor. Etiam venenatis est metus, sit amet semper dui porta non. Proin nunc nunc, lobortis at tristique non, vestibulum ac justo. Nam sed tempus lacus. Integer vel ligula non metus vehicula tristique. Vestibulum quis dignissim enim. Sed volutpat mattis tellus, id dapibus diam aliquam a. Nam gravida risus non leo efficitur facilisis. Quisque malesuada, est vitae ultricies malesuada, diam enim lobortis urna, ut condimentum mi leo sit amet quam. Vestibulum a laoreet risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\n\r\nMauris vitae ipsum feugiat, luctus eros vitae, faucibus dui. Pellentesque volutpat dui diam, eu ornare enim ultricies ac. In hac habitasse platea dictumst. Etiam vel scelerisque urna. Integer mattis at ipsum id tempor. Sed sagittis vestibulum mauris, nec lobortis lorem ultricies a. Nunc sed lorem ut urna vehicula aliquet ut pellentesque urna. Etiam pulvinar dolor quis sagittis vulputate. Donec sed varius magna, ut ornare quam. Maecenas leo enim, posuere mollis gravida vel, porta vitae enim. Integer dictum purus eget velit sagittis imperdiet. Sed in sem vitae odio luctus viverra. Phasellus pulvinar, dui sit amet aliquam accumsan, est nibh scelerisque enim, id pharetra diam nulla ut turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Maecenas imperdiet tortor nisl, sit amet congue enim interdum ultricies. Etiam auctor, sem et blandit aliquet, felis odio bibendum neque, vel mollis neque diam at quam.\r\n\r\nInteger malesuada mattis sem sit amet scelerisque. Nullam eget semper risus. Pellentesque eget orci nunc. Phasellus laoreet diam ligula, eu placerat risus varius eu. Sed lorem turpis, dapibus quis orci porta, convallis tempor nulla. Cras vitae orci id est aliquam cursus ac quis neque. Vivamus lobortis, ligula quis posuere volutpat, libero nunc lobortis lacus, eget congue quam quam at turpis. Cras a condimentum odio.', 'belum', '2025-05-07 06:51:10', '2025-05-07 17:00:00'),
(58, 54, 'Unit Test Tugas', 'Tugas hasil testing otomatis', 'belum', '2025-05-27 10:20:46', '2025-05-28 04:00:00'),
(59, 55, 'Unit Test Tugas', 'Tugas hasil testing otomatis', 'belum', '2025-05-27 10:23:18', '2025-05-28 04:00:00'),
(60, 56, 'Unit Test Tugas', 'Tugas hasil testing otomatis', 'belum', '2025-05-27 10:23:21', '2025-05-28 04:00:00'),
(66, 62, 'Tugas Sudah Diedit', 'Deskripsi telah diperbarui', 'belum', '2025-05-27 13:29:43', '2025-05-30 04:00:00'),
(67, 63, 'Unit Test Tugas', 'Tugas hasil testing otomatis', 'belum', '2025-05-27 13:48:35', '2025-05-28 04:00:00'),
(72, 34, 'Tugas Testing', 'efasda', 'selesai', '2025-06-03 11:59:32', '2025-06-12 04:00:00'),
(75, 34, 'Tugas Automation Testing STQA', 'Katalon Testing', 'belum', '2025-06-03 12:04:02', '2025-07-06 04:00:00'),
(76, 34, 'dwawdwadaw', 'dawdawdwad', 'belum', '2025-06-03 12:04:34', '2025-07-06 04:00:00'),
(78, 34, 'Tugas STQA', 'Katalon', 'belum', '2025-06-03 12:38:27', '2025-10-10 04:00:00'),
(79, 34, 'Tugas STQA', 'Katalon', 'belum', '2025-06-03 12:44:49', '2025-10-10 04:00:00'),
(81, 34, 'awdaw', 'wadawd', 'belum', '2025-06-09 02:45:33', '2027-12-10 05:00:00'),
(83, 76, 'tes', 'test', 'belum', '2025-06-15 11:08:02', '2025-10-10 04:00:00'),
(84, 27, 'PDW', 'bikin use case pdw', 'belum', '2025-06-15 11:43:23', '2025-06-17 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `email`, `password`, `tanggal_daftar`, `role`) VALUES
(16, 'Muhammad Mufid Ghibran Rumekso', 'mufid1012', 'mufidghibran1012@gmail.com', '$2y$10$CK5o0I2g1YWOoVkiThZ.GOVKfPwvas28g8Z3W19vH4CIKTNde/fRi', '2025-04-16 12:25:32', 'user'),
(19, 'dawdwada', 'mufid123123', 'awda23123@gmail.com', '$2y$10$I9oruQSvrnKwKLnGuQrXoeZOQI/5LwNGyTI.nxDNvkJerv2OD.ayy', '2025-04-17 00:08:09', 'user'),
(20, 'awdawdwad', '12345', 'adsdawd@gmail.com', '$2y$10$NiVOAW9i1bgkRTtG6rAnd.JFdQSlHR6qRdbj/0PJjQgCekMucMuqS', '2025-04-17 00:10:25', 'user'),
(26, 'Ronaldo', 'ronaldo', 'ronaldo7@gmail.com', '$2y$10$nEmA8yZeHOvSm0tOUhlaEO3Rd8utepksXyAU/6w1aghSiMkyTmdLe', '2025-04-17 07:03:03', 'user'),
(27, 'Andika Arya Putra', 'Andika Arya', 'andika.arya.ft23@mail.umy.ac.id', '$2y$10$i06VDVDlR3Yy7Vk2FpnoVevR0Z7e4zVkHJSxDvLFJAVo96pgXMbI2', '2025-04-17 11:56:44', 'user'),
(28, 'abillaaa', 'abillaaa._', 'nabilasafitri861@gmail.com', '$2y$10$Fb3AOVfQGYqJ.STOAXZdOuCzhR74W0VyWlG5pPq3FNkUy2GxMC4f6', '2025-04-23 07:11:48', 'user'),
(29, 'Syafrina$%$%6', 'vianida', 'syafrinavia@gmail.com', '$2y$10$0UNTsYaqyJRnYVHxNPgvQuArHuO9IgOx6LpUlWDh/UK1VGjYGHrie', '2025-04-29 04:26:16', 'user'),
(30, 'Syafrina Metavianida', 'syafrinavia', 'perpusptma@gmail.com', '$2y$10$jg2ht/7XfZ0x47ilHxQ3XeqxPAX4irLHzCp1Wpw8.KwRyfFszaqaC', '2025-04-29 04:27:14', 'user'),
(31, 'Alfarizi Reza', 'system', 'reza@gmail.com', '$2y$10$WXJ8MDDWxWIRZ60Fv.ZtbOt9xahynCmBjS1d.TMbmpuocZVDswV0e', '2025-04-29 04:37:45', 'user'),
(32, '123413', 'dawed', '123@gmail.com', '$2y$10$eszCloYNJb1wdj7mpLdrlubXJF5fSDvgMkNMr0YczKTjrgmQO2F5K', '2025-04-29 04:42:51', 'user'),
(34, '1', '1', '1@gmail.com', '$2y$10$qRSINb7EpoS33pq8rGnUiOMGwbGOa.Ugk9mgAKKYy2B0hUsWJeQZe', '2025-04-29 20:28:25', 'admin'),
(35, 'Mufid Ghibran', 'mufid12', 'mufidghibran12@gmail.com', '$2y$10$UtmTa84gUk50YhvU9kNPx.HrG/twzIeP6CRp/QP2psXDIFij8dYU2', '2025-05-06 22:13:51', 'user'),
(37, 'testing', 'testing', 'testing@gmail.com', '$2y$10$bdtyujcrNPZDNY...dUILOTM6qiUwtaeI9O057nZ5FH2/ij4gKKzG', '2025-05-06 22:27:00', 'user'),
(38, 'Test User 682d92c872311', 'testuser_682d92c872311', 'test_682d92c872311@example.com', '$2y$10$lyka7ZZmmABO9shMtO4X.O0apBw2t1ShJDkaLfPO53e5PdXA7p3yC', '2025-05-21 08:46:00', 'user'),
(39, 'Test User 682d9354a8bc6', 'testuser_682d9354a8bc6', 'test_682d9354a8bc6@example.com', '$2y$10$sehH4IN5YYIqByr85U3.D.rE07R4UWjjpvLfDsYzqJUJLKG8S2AkS', '2025-05-21 08:48:20', 'user'),
(40, 'Integration User 682d95215f6ac', 'ituser_682d95215f6ac', 'it_682d95215f6ac@example.com', '$2y$10$A57unsCOZgp0pKOioOyWV.Ruxbb7SlBViM70BoNWprrP33tFF0g1W', '2025-05-21 08:56:01', 'user'),
(41, 'Integration User 682e8ebda94d7', 'ituser_682e8ebda94d7', 'it_682e8ebda94d7@example.com', '$2y$10$ovHX9.58S4.GrEndNv.REOYvB.Dk.rpm6wRTh.Yl93KNC3OGe/EWO', '2025-05-22 02:41:01', 'user'),
(42, 'Integration User 683585065df7f', 'ituser_683585065df7f', 'it_683585065df7f@example.com', '$2y$10$ZCPzBv81yc/QbHKJ69B3o.LrxDGxaxiFiqjdIXHK/U.aPeIh/Ft5q', '2025-05-27 09:25:26', 'user'),
(43, 'Integration User 683586e07633a', 'ituser_683586e07633a', 'it_683586e07633a@example.com', '$2y$10$r42s4ZH9uGAFl1qGwpttfuYZHeDNrHHtsqEJa/7pqrBKOAL1cPFcK', '2025-05-27 09:33:20', 'user'),
(44, 'User Integration 68358f704c54e', 'integration_68358f704c54e', 'integration_68358f704c54e@example.com', '$2y$10$zO4Ah8QWvjPpWKMkGIMYc.CgPHjlPnPa7WILDkkDvL7n78Eb5JJvi', '2025-05-27 10:09:52', 'user'),
(45, 'User Integration 683590dfbc289', 'integration_683590dfbc289', 'integration_683590dfbc289@example.com', '$2y$10$b9hQIxxje6hQUDSSwoGW/urh6VPJjzxdJ7aCO2EO43KCpfVTnwbHC', '2025-05-27 10:15:59', 'user'),
(47, 'User Integration 683590fe3920b', 'integration_683590fe3920b', 'integration_683590fe3920b@example.com', '$2y$10$yx6H9rG8dneQoIUAoqebjeT8pGvYENHQNkqAKBvzIFtU7E8oZ0FWK', '2025-05-27 10:16:30', 'user'),
(48, 'User Integration 68359100427f0', 'integration_68359100427f0', 'integration_68359100427f0@example.com', '$2y$10$W.VSOHORGD40nkETheKIEOxobd8DYM3xXB1KxYPLnxCy7iXGsaLE2', '2025-05-27 10:16:32', 'user'),
(49, 'User Integration 68359122dbdd0', 'integration_68359122dbdd0', 'integration_68359122dbdd0@example.com', '$2y$10$wJs5prD.mQ36NVzGlxDSW.6h/nOOy30vYRG2ns7SYuhru.rK0ta.i', '2025-05-27 10:17:07', 'user'),
(50, 'User Integration 6835912796e89', 'integration_6835912796e89', 'integration_6835912796e89@example.com', '$2y$10$1OnmGGOz8ght79iQ82f38e7XnBIWtZcLxf2htlycHcbJu6IpZTbCu', '2025-05-27 10:17:11', 'user'),
(51, 'User Integration 6835914aa6d84', 'integration_6835914aa6d84', 'integration_6835914aa6d84@example.com', '$2y$10$tBVLaA5gsbn8AMwy1.nT/urZHE0ywhIjvjN952SDy3DlVrCKKIMIm', '2025-05-27 10:17:46', 'user'),
(52, 'User Integration 683591ccc809e', 'integration_683591ccc809e', 'integration_683591ccc809e@example.com', '$2y$10$9DmMyXkqiDK02hNoKOkI8uijhz9HorqtU1QqrbNYhq09C.QSOE3wa', '2025-05-27 10:19:57', 'user'),
(53, 'User Integration 683591cf62b5e', 'integration_683591cf62b5e', 'integration_683591cf62b5e@example.com', '$2y$10$LlUZr.MfxnQhS8iMRdPWPewYIh77C4qEQGc2zAoLgrpzWVeJHHSyG', '2025-05-27 10:19:59', 'user'),
(54, 'User Tugas 683591fde8ef0', 'tugas_683591fde8ef0', 'tugas_683591fde8ef0@example.com', '$2y$10$97OjfxfSZAMk8pX4kdazmOUX2jWcrUMw.xHPBjtGDw8Ft7aH03M4K', '2025-05-27 10:20:46', 'user'),
(55, 'User Tugas 68359295bc400', 'tugas_68359295bc400', 'tugas_68359295bc400@example.com', '$2y$10$qNIoLXL3YFo/UoImh1MtPeH/z74jkGd2qNXURyze5YJNVkrRkdroq', '2025-05-27 10:23:17', 'user'),
(56, 'User Tugas 6835929913d0c', 'tugas_6835929913d0c', 'tugas_6835929913d0c@example.com', '$2y$10$.TaL1bqTbQYIQhKirLpsLePk9oWxrc5OkcGUUZZ1KJhkaEbkGEf82', '2025-05-27 10:23:21', 'user'),
(57, 'User Hapus 68359f3760ff2', 'hapus_68359f3760ff2', 'hapus_68359f3760ff2@example.com', '$2y$10$nm.4YuTJxllYkmJHtzBhWevdIAanHwwqnLQJTm4mn3Pk96UHs3WUO', '2025-05-27 11:17:11', 'user'),
(58, 'User Hapus 68359f3ce0167', 'hapus_68359f3ce0167', 'hapus_68359f3ce0167@example.com', '$2y$10$w0Xgxa7fd2rkQdkYxUVwlu.NdFClCeDloQ9aJ.QOQ2OVg7JJejDxW', '2025-05-27 11:17:17', 'user'),
(59, 'User Hapus 6835bd977f28d', 'hapus_6835bd977f28d', 'hapus_6835bd977f28d@example.com', '$2y$10$Rq.vhmpfCOj1F37rikDLjeJ867dQ5QHZK9Cs9pn5UXHCIp1.XgM9q', '2025-05-27 13:26:47', 'user'),
(60, 'User Hapus 6835bdb303bb0', 'hapus_6835bdb303bb0', 'hapus_6835bdb303bb0@example.com', '$2y$10$wlzfreiihDUP2m2vOqxr7..5nA00ZkhlbXn3K9AOWyk.Q6C82JHpK', '2025-05-27 13:27:15', 'user'),
(62, 'User Edit 6835be47706f2', 'edittest_6835be47706f2', 'edittest_6835be47706f2@example.com', '$2y$10$k1A8YMADm4s4vZ2Orf/b/O9RXUjrcPyKLQIwAFaCJr0bMuKGUMI9S', '2025-05-27 13:29:43', 'user'),
(63, 'User Tugas 6835c2b35f217', 'tugas_6835c2b35f217', 'tugas_6835c2b35f217@example.com', '$2y$10$fjCuS0kY4HO6aIY8KeSKCOBB2cwD0mGsE8uj1DJ.HuLhaCMaaaGMy', '2025-05-27 13:48:35', 'user'),
(64, 'User Integration 6835c40b70238', 'integration_6835c40b70238', 'integration_6835c40b70238@example.com', '$2y$10$d1RSK0HRPKYWAj4iaEmxxOJdoMO2jGtoEoE1cT2AoOzCIMvjZoHLS', '2025-05-27 13:54:19', 'user'),
(65, 'User Integration 6836ad8069a13', 'integration_6836ad8069a13', 'integration_6836ad8069a13@example.com', '$2y$10$q5zI1zH7uhQT7d2HULNsduTjjNXT3dXG5XhsOVnrm.MdgHkwwItEq', '2025-05-28 06:30:24', 'user'),
(66, 'Syafrina m', 'syafrinam', 'meta@gmail.com', '$2y$10$kd2wfOagxnQbPjExbPrDa.QCMUVOcOj.a83C9KtsESYhZCPW/yX9W', '2025-05-30 08:17:42', 'user'),
(67, 'User Integration 683d542c831ed', 'integration_683d542c831ed', 'integration_683d542c831ed@example.com', '$2y$10$j473a5HnfQ6R8iha44vgXecqQhF0gLIXHwXqkIPKHq/VK/CqYpite', '2025-06-02 07:35:08', 'user'),
(68, 'Dzaky Putra Pratama', 'nopalcies', 'dzakypratama@gmail.com', '$2y$10$vnwQqUHG3g428jTvpqYwIewLFnaZAqevYIUL.U/WTzAhJoaUAJz32', '2025-06-03 12:36:45', 'user'),
(69, 'Dzaky Putra Pratama', 'dzakyputra', 'dzakypratama45@gmail.com', '$2y$10$ZjZtNCJQYBPZSx4cVaHyxuv.sMNB7Lbh8K/rZU224ikIEzYL3ZFLG', '2025-06-03 13:03:43', 'user'),
(70, 'naufal gege', 'nopal', 'naufal@gmail.com', '$2y$10$rPOkSMWKrrlvavqB9LiFpexxsVCETCucuFC2YMmsK3tKB1iqkwC1.', '2025-06-03 13:09:14', 'user'),
(71, 'adw', 'awda', 'awd@gmail.com', '$2y$10$UnXuC8nevu0cwxw3.cacM..or0dqHKmgSg9ALqCKGl6zOpcBPjljy', '2025-06-09 01:19:06', 'user'),
(75, 'Admin', 'admin', 'admin@example.com', '$2y$10$R6j6gOCYdTuwUoeYw8fRDeMHXbKOwAWnMgklSRHaFVQYUtWzYTZBa', '2025-06-15 07:12:51', 'admin'),
(76, '2', '2', '2@gmail.com', '$2y$10$BkoBm1sJlLFxU0U9SRVXxuxNb8Ir5caRcrgHcNHGEZ6/fsmh2e8Na', '2025-06-15 07:22:24', 'user'),
(78, 'admin2', 'admin2', 'admin@gmail.com', '$2y$10$W2pwsEU/R3aE0AF8D.SZG.vaRJAJUh7CqtWNxtq3OoSpdEYvckYUa', '2025-06-16 08:15:02', 'admin'),
(79, 'test123', 'test123', 'test123@gmail.com', '$2y$10$eFPyKD5JRlV8dv6UEPxLkuuEfeeuYGGvR3M6tojVRYUkuCa3/uRpy', '2025-06-16 08:45:19', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `informasi_kuliah`
--
ALTER TABLE `informasi_kuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `informasi_kuliah`
--
ALTER TABLE `informasi_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
