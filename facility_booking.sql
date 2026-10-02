-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Okt 2026 pada 02.53
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
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) UNSIGNED NOT NULL,
  `booking_code` varchar(30) NOT NULL,
  `employee_id` int(11) UNSIGNED NOT NULL,
  `facility_type` enum('vehicle','room','meeting_room') NOT NULL,
  `vehicle_id` int(11) UNSIGNED DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `meeting_room_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `purpose` text NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `approved_by` int(11) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `employee_id`, `facility_type`, `vehicle_id`, `room_id`, `meeting_room_id`, `driver_id`, `start_date`, `end_date`, `start_time`, `end_time`, `purpose`, `status`, `notes`, `rejection_reason`, `approved_by`, `approved_at`, `created_at`, `updated_at`, `isdelete`) VALUES
(1, 'BK-20260921235405', 2, 'vehicle', NULL, NULL, NULL, NULL, '2026-09-23', '2026-09-25', '04:30:00', '11:30:00', 'Dinas ke semarang', 'pending', NULL, NULL, NULL, NULL, '2026-09-21 23:54:05', NULL, 1),
(2, 'BK-20260921235518', 2, 'vehicle', NULL, NULL, NULL, NULL, '2026-09-23', '2026-09-25', '04:30:00', '11:30:00', 'Dinas ke semarang', 'rejected', NULL, 'tidak disetujui', NULL, NULL, '2026-09-21 23:55:18', '2026-09-23 01:34:52', 1),
(3, 'BK-20260921235931', 2, 'vehicle', NULL, NULL, NULL, NULL, '2026-09-23', '2026-09-25', '04:30:00', '11:30:00', 'Dinas ke semarang', 'cancelled', NULL, NULL, 1, '2026-09-23 01:34:16', '2026-09-21 23:59:31', '2026-09-23 23:57:03', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `company`
--

CREATE TABLE `company` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_code` varchar(50) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `company`
--

INSERT INTO `company` (`id`, `company_code`, `company_name`, `status`, `created_at`, `updated_at`, `isdelete`) VALUES
(2, 'ETI', 'PT Evercoss Technology Indonesia', 'aktif', '2026-09-26 06:40:27', NULL, 0),
(3, 'ETI', 'PT Evercoss Technology Indonesia', 'aktif', '2026-09-26 08:00:46', NULL, 1),
(4, 'UNN', 'PT Unigo Niaga Nusantara', 'tidak aktif', '2026-09-29 22:25:31', '2026-09-30 04:41:45', 0),
(5, 'UNN', 'PT Unigo Niaga Nusantara', 'aktif', '2026-10-01 19:38:34', NULL, 1),
(6, 'JPN', 'PT Jalur Persada Nusantara', 'aktif', '2026-10-01 19:38:58', '2026-10-01 19:40:23', 1),
(7, 'JPN', 'PT Jalur Persada Nusantara', 'aktif', '2026-10-01 19:40:35', NULL, 0),
(8, 'JPN', 'PT Jalur Persada Nusantara', 'aktif', '2026-10-01 19:44:07', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `departments`
--

CREATE TABLE `departments` (
  `id` int(11) UNSIGNED NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `status`, `created_at`, `updated_at`, `isdelete`) VALUES
(1, 'HRGA', 1, '2026-09-15 14:38:12', '2026-09-20 19:29:43', 1),
(2, 'Operasional', 1, '2026-09-15 14:38:12', NULL, 1),
(6, 'IT', 1, '2026-09-20 01:02:50', NULL, 0),
(7, 'IT', 1, '2026-09-26 11:08:26', NULL, 1);

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
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `drivers`
--

INSERT INTO `drivers` (`id`, `employee_id`, `driver_code`, `status`, `notes`, `created_at`, `updated_at`, `isdelete`) VALUES
(5, 11, 'Driver_Ops', 'Tidak Aktif', 'Driver Operasional', '2026-09-20 19:32:23', '2026-09-23 23:29:20', 1),
(6, 12, 'Driver_AKW', 'Aktif', 'Driver pak Akwan', '2026-09-20 19:49:05', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(11) UNSIGNED NOT NULL,
  `employee_code` varchar(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `department_id` int(11) UNSIGNED NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `name`, `company_id`, `department_id`, `position`, `phone`, `status`, `created_at`, `updated_at`, `isdelete`) VALUES
(1, 'EMP001', 'Anggi', 3, 2, 'Staff GA', '087977542121', 1, '2026-09-15 14:39:10', '2026-09-30 05:46:55', 1),
(2, 'EMP002', 'Darin', 2, 2, 'Recruiter', '087654324568', 1, '2026-09-15 14:39:10', '2026-09-23 23:44:02', 1),
(11, 'EMP003', 'Michael', 2, 1, 'Driver', '087654324566', 1, '2026-09-20 19:30:31', NULL, 1),
(12, 'EMP004', 'Eko', 2, 1, 'Driver', '087654324568', 1, '2026-09-20 19:44:44', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employee_sims`
--

CREATE TABLE `employee_sims` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `sim_type` varchar(20) NOT NULL,
  `sim_number` varchar(50) NOT NULL,
  `expired_date` date NOT NULL,
  `sim_photo` varchar(255) DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `employee_sims`
--

INSERT INTO `employee_sims` (`id`, `employee_id`, `sim_type`, `sim_number`, `expired_date`, `sim_photo`, `isdelete`, `created_at`, `updated_at`) VALUES
(1, 1, 'SIM C', '123456789765', '2026-09-30', NULL, 1, '2026-09-30 05:46:55', '2026-09-30 05:46:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `meeting_rooms`
--

CREATE TABLE `meeting_rooms` (
  `id` int(11) NOT NULL,
  `room_code` varchar(30) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` enum('Tersedia','Tidak Tersedia','Perbaikan') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meeting_rooms`
--

INSERT INTO `meeting_rooms` (`id`, `room_code`, `room_name`, `capacity`, `location`, `status`, `notes`, `created_at`, `updated_at`, `isdelete`) VALUES
(1, 'RE001', 'Ruang Meeting Lantai 3', 8, 'Lantai 3', 'Tersedia', NULL, '2026-09-16 18:47:28', '2026-09-17 00:05:27', 1),
(2, 'RE002', 'Ruang Meeting Lantai 4', 10, 'Lantai 4', 'Tidak Tersedia', NULL, '2026-09-16 18:47:28', '2026-10-01 21:14:53', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_code` varchar(30) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `status` enum('Tersedia','Terisi','Perbaikan') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `room_code`, `room_name`, `capacity`, `status`, `notes`, `created_at`, `updated_at`, `isdelete`) VALUES
(1, 'RM001', 'Kamar 1A', 3, 'Tersedia', 'Kamar Pak Akwan', '2026-09-16 17:12:27', NULL, 1),
(2, 'RM002', 'Kamar 2A', 2, 'Tersedia', 'Ruang Arsip Divisi Pajak', '2026-09-16 17:12:27', '2026-10-01 21:15:03', 1),
(4, 'RM003', 'Kamar 3A', 4, 'Terisi', '', '2026-09-20 21:34:47', '2026-09-20 21:57:10', 0),
(6, 'RM003', 'Kamar 12A', 2, 'Terisi', 'Kamar pak Akwan', '2026-10-01 20:14:16', NULL, 0);

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
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `employee_id`, `username`, `password`, `role`, `status`, `last_login`, `created_at`, `updated_at`, `isdelete`) VALUES
(1, 1, 'anggi', '$2y$10$59Ic3cxSsZFHQFQ4MjPnbOo/5qGV8Ua5dhT4jCLMtgr3F4eLk.7W6', 'admin', 1, '2026-10-01 19:38:17', '2026-09-15 14:43:58', NULL, 1),
(2, 2, 'darin', '$2y$10$8mCfFSXPBuc0Izh9Jhbm9uQ7e44e.TN8ed4uFS0ET702fk2CCXise', 'employee', 1, '2026-09-26 13:46:38', '2026-09-15 14:43:58', NULL, 1),
(11, 11, 'michael', '$2y$10$XU2Kp5gd29M7Tdt9maBxTeb4qASATT0SW8mTdwajpMdnEaj5UCpQC', 'employee', 1, NULL, '0000-00-00 00:00:00', NULL, 1),
(12, 12, 'eko', '$2y$10$lrA/P9tP9ln.dTt/WGmVJe1qcK51QSWSOYzgFRLjVejYD.fUAGcm6', 'employee', 1, NULL, '0000-00-00 00:00:00', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) UNSIGNED NOT NULL,
  `vehicle_code` varchar(30) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `tahun` varchar(10) NOT NULL,
  `warna` varchar(30) DEFAULT NULL,
  `kapasitas` int(11) NOT NULL,
  `lokasi` varchar(30) NOT NULL,
  `requires_driver` enum('Ya','Tidak') NOT NULL DEFAULT 'Tidak',
  `status` enum('Aktif','Perbaikan','Tidak Aktif') NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isdelete` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_code`, `plate_number`, `vehicle_name`, `jenis`, `tahun`, `warna`, `kapasitas`, `lokasi`, `requires_driver`, `status`, `notes`, `created_at`, `updated_at`, `isdelete`) VALUES
(1, 'VE001', 'N1234ASD', 'BYD', NULL, '', '', 0, '0', 'Ya', 'Perbaikan', NULL, '2026-09-16 03:02:18', '2026-09-23 23:28:23', 1),
(3, 'VE002', 'B9876DE', 'Mobilio', NULL, '', '', 0, '0', 'Ya', 'Aktif', 'Mobil Operasional', '2026-09-16 22:05:21', '2026-10-01 20:09:26', 1),
(5, 'VE003', 'N1234ASC', 'Mobilio', NULL, '', '', 0, '0', 'Ya', 'Aktif', '', '2026-09-23 23:27:26', '2026-09-23 23:34:35', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_booking_code` (`booking_code`),
  ADD KEY `idx_employee_id` (`employee_id`),
  ADD KEY `idx_vehicle_id` (`vehicle_id`),
  ADD KEY `idx_room_id` (`room_id`),
  ADD KEY `idx_meeting_room_id` (`meeting_room_id`),
  ADD KEY `idx_driver_id` (`driver_id`),
  ADD KEY `idx_approved_by` (`approved_by`),
  ADD KEY `idx_booking_date` (`start_date`,`end_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `employee_dept` (`department_id`),
  ADD KEY `employee_com` (`company_id`);

--
-- Indeks untuk tabel `employee_sims`
--
ALTER TABLE `employee_sims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employee_sims_employee` (`employee_id`);

--
-- Indeks untuk tabel `meeting_rooms`
--
ALTER TABLE `meeting_rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`room_code`);

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `employee_sims`
--
ALTER TABLE `employee_sims`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `meeting_rooms`
--
ALTER TABLE `meeting_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_booking_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_driver` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_meeting_room` FOREIGN KEY (`meeting_room_id`) REFERENCES `meeting_rooms` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Ketidakleluasaan untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employee_com` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `employee_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Ketidakleluasaan untuk tabel `employee_sims`
--
ALTER TABLE `employee_sims`
  ADD CONSTRAINT `fk_employee_sims_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
