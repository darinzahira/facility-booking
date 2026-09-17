-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Sep 2026 pada 02.50
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facility_booking`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `departments`
--

CREATE TABLE `departments` (
  `id` int(11) UNSIGNED NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'HRGA', 1, '2026-09-15 14:38:12', '2026-09-15 20:04:43'),
(2, 'Operasional', 1, '2026-09-15 14:38:12', NULL),
(4, 'IT', 1, '2026-09-15 21:44:33', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) UNSIGNED NOT NULL,
  `driver_code` varchar(30) NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `drivers`
--

INSERT INTO `drivers` (`id`, `employee_id`, `driver_code`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 7, 'Driver_Ops', 'Aktif', 'Driver operasional', '2026-09-15 20:00:32', NULL),
(4, 8, 'Driver_AKW', 'Tidak Aktif', 'Driver pak Akwan', '2026-09-16 20:46:08', '2026-09-16 21:16:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(11) UNSIGNED NOT NULL,
  `employee_code` varchar(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `department_id` int(11) UNSIGNED NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `name`, `department_id`, `position`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'EMP001', 'Anggi', 1, 'Staff GA', NULL, 1, '2026-09-15 14:39:10', NULL),
(2, 'EMP002', 'Darin', 2, NULL, NULL, 1, '2026-09-15 14:39:10', NULL),
(3, 'EMP003', 'Dewi', 1, 'Recruiter', '087654324566', 1, '2026-09-15 20:05:38', NULL),
(4, 'EMP004', 'Bayu', 4, 'Recruiter', '087654324568', 1, '2026-09-15 23:49:49', '2026-09-16 00:26:54'),
(6, 'EMP006', 'Bayu', 2, 'Recruiter', '087654324566', 0, '2026-09-16 00:33:26', '2026-09-16 00:53:12'),
(7, 'EMP007', 'Michael', 1, 'Driver', '087654399571', 1, '2026-09-16 01:00:10', NULL),
(8, 'EMP008', 'Eko', 1, 'Driver', '087654324569', 1, '2026-09-16 01:53:43', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `employee_id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('employee','admin') NOT NULL,
  `status` tinyint(4) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `employee_id`, `username`, `password`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 1, 'anggi', '$2y$10$59Ic3cxSsZFHQFQ4MjPnbOo/5qGV8Ua5dhT4jCLMtgr3F4eLk.7W6', 'admin', 1, '2026-09-17 00:25:09', '2026-09-15 14:43:58', NULL),
(2, 2, 'darin', '$2y$10$8mCfFSXPBuc0Izh9Jhbm9uQ7e44e.TN8ed4uFS0ET702fk2CCXise', 'employee', 1, '2026-09-17 00:07:49', '2026-09-15 14:43:58', NULL),
(3, 3, 'dewi', '$2y$10$Ko0rGLL/y0Z1Av7kMvJKDeaZOS6tW1YDnrx0tjIrAPyhvjq6x0vdS', 'employee', 0, NULL, '0000-00-00 00:00:00', NULL),
(6, 6, 'bayu', '$2y$10$gSZvlUarIHwhxjE5lRjVGORxL3vpJWQ8.eaxZWc.Pj7OziQSx80gK', 'employee', 0, NULL, '0000-00-00 00:00:00', NULL),
(7, 7, 'michael', '$2y$10$XHcPn8D3n46I09/JKE8ITe8AQ47/My3AbxyRsLUfffGmQQloxUTia', 'employee', 0, NULL, '0000-00-00 00:00:00', NULL),
(8, 8, 'eko', '$2y$10$/hT42X1iTtKK2/Q5pIlie.E45ms6MY87LA1RkOjSMZ8s9qmLrwBr2', 'employee', 0, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) UNSIGNED NOT NULL,
  `vehicle_code` varchar(30) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `status` enum('Aktif','Perbaikan','Tidak Aktif') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_code`, `plate_number`, `vehicle_name`, `brand`, `model`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'VE001', 'N1234ASD', 'BYD', NULL, NULL, 'Aktif', NULL, '2026-09-16 03:02:18', '2026-09-16 22:05:32'),
(3, 'VE002', 'B9876DE', 'Mobilio', NULL, NULL, 'Aktif', 'Mobil Operasional', '2026-09-16 22:05:21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`driver_code`),
  ADD KEY `drivers_employee` (`employee_id`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_code` (`employee_code`),
  ADD KEY `employee_dept` (`department_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`employee_id`),
  ADD UNIQUE KEY `UNIQUE1` (`username`);

--
-- Indeks untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`vehicle_code`),
  ADD UNIQUE KEY `UNIQUE1` (`plate_number`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Ketidakleluasaan untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employee_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
