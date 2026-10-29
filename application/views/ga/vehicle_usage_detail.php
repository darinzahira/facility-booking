<div class="container-fluid"> 

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Detail Pemeriksaan Kendaraan
        </h1>

        <a href="<?= base_url('ga/Bookings/vehicle_usage_list'); ?>"
           class="btn btn-info">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <style>
        .vehicle-photo-box {
            width: 100%;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .vehicle-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-header">
            <strong>Informasi Booking</strong>
        </div>

        <div class="card-body">
            <p>
                <strong>Kode Booking:</strong>
                <?= html_escape($booking->booking_code); ?>
            </p>

            <p>
                <strong>Nama Karyawan:</strong>
                <?= html_escape($booking->name); ?>
            </p>

            <p>
                <strong>Kendaraan:</strong>
                <?= html_escape($booking->vehicle_name); ?>
                <?= html_escape($booking->plate_number); ?>
            </p>

            <p>
                <strong>Keperluan:</strong>
                <?= html_escape($booking->purpose); ?>
            </p>

            <p>
                <strong>Waktu Mulai Booking:</strong>
                <?= !empty($booking->start_date)
                ? date('d-m-Y', strtotime($booking->start_date))
                : '-'; ?> (
                <?= !empty($booking->start_time)
                ? date('H:i', strtotime($booking->start_time))
                : '-'; ?> WIB)
            </p>

            <p>
                <strong>Waktu Selesai Booking:</strong>
                <?= !empty($booking->end_date)
                ? date('d-m-Y', strtotime($booking->end_date))
                : '-'; ?> (
                <?= !empty($booking->end_time)
                ? date('H:i', strtotime($booking->end_time))
                : '-'; ?> WIB)
            </p>

            <p>
                <strong>Status Penggunaan:</strong>
                <?php if ($booking->status_penggunaan == 'belum_mulai'): ?>
                    <span class="badge badge-secondary">Belum Mulai</span>
                <?php elseif ($booking->status_penggunaan == 'digunakan'): ?>
                    <span class="badge badge-primary">Sedang Digunakan</span>
                <?php elseif ($booking->status_penggunaan == 'menunggu_pemeriksaan'): ?>
                    <span class="badge badge-warning">Menunggu Pemeriksaan</span>
                <?php elseif ($booking->status_penggunaan == 'selesai'): ?>
                    <span class="badge badge-success">Selesai</span>
                <?php else: ?>
                    <span class="badge badge-secondary">
                        <?= htmlspecialchars($booking->status_penggunaan); ?>
                    </span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <strong>Kondisi Awal</strong>
                </div>

                <div class="card-body">
                    <p>
                        <strong>Kilometer Awal:</strong>
                        <?= html_escape($usage->km_awal); ?> km
                    </p>

                    <p>Foto Kilometer Awal</p>

                    <?php if (!empty($usage->foto_km_awal)): ?>
                        <div class="vehicle-photo-box">
                            <a
                                href="<?= base_url(
                                    'uploads/vehicle_usage/'
                                    . rawurlencode($usage->foto_km_awal)
                                ); ?>"
                                target="_blank"
                                rel="noopener"
                            >
                                <img
                                    src="<?= base_url(
                                        'uploads/vehicle_usage/'
                                        . rawurlencode($usage->foto_km_awal)
                                    ); ?>"
                                    alt="Foto kilometer awal"
                                >
                            </a>
                        </div>
                    <?php else: ?>
                        <p>Foto belum tersedia.</p>
                    <?php endif; ?>

                    <p>Foto BBM Awal</p>

                    <?php if (!empty($usage->foto_bbm_awal)): ?>
                        <div class="vehicle-photo-box">
                            <a
                                href="<?= base_url(
                                    'uploads/vehicle_usage/'
                                    . rawurlencode($usage->foto_bbm_awal)
                                ); ?>"
                                target="_blank"
                                rel="noopener"
                            >
                                <img
                                    src="<?= base_url(
                                        'uploads/vehicle_usage/'
                                        . rawurlencode($usage->foto_bbm_awal)
                                    ); ?>"
                                    alt="Foto BBM awal"
                                >
                            </a>
                        </div>
                    <?php else: ?>
                        <p>Foto belum tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <strong>Kondisi Pengembalian</strong>
                </div>

                <div class="card-body">
                    <p>
                        <strong>Kilometer Akhir:</strong>
                        <?= html_escape($usage->km_akhir); ?> km
                    </p>

                    <p>
                        <strong>Jarak Tempuh:</strong>
                        <?php
                        if (
                            $usage->km_awal !== NULL &&
                            $usage->km_akhir !== NULL
                        ) {
                            echo (int) $usage->km_akhir
                                - (int) $usage->km_awal;
                        } else {
                            echo '-';
                        }
                        ?>
                        km
                    </p>

                    <p>Foto Kilometer Akhir</p>

                    <?php if (!empty($usage->foto_km_akhir)): ?>
                        <div class="vehicle-photo-box">
                            <a
                                href="<?= base_url(
                                    'uploads/vehicle_usage/'
                                    . rawurlencode($usage->foto_km_akhir)
                                ); ?>"
                                target="_blank"
                                rel="noopener"
                            >
                                <img
                                    src="<?= base_url(
                                        'uploads/vehicle_usage/'
                                        . rawurlencode($usage->foto_km_akhir)
                                    ); ?>"
                                    alt="Foto kilometer akhir"
                                >
                            </a>
                        </div>
                    <?php else: ?>
                        <p>Foto belum tersedia.</p>
                    <?php endif; ?>

                    <p>Foto BBM Akhir</p>

                    <?php if (!empty($usage->foto_bbm_akhir)): ?>
                        <div class="vehicle-photo-box">
                            <a
                                href="<?= base_url(
                                    'uploads/vehicle_usage/'
                                    . rawurlencode($usage->foto_bbm_akhir)
                                ); ?>"
                                target="_blank"
                                rel="noopener"
                            >
                                <img
                                    src="<?= base_url(
                                        'uploads/vehicle_usage/'
                                        . rawurlencode($usage->foto_bbm_akhir)
                                    ); ?>"
                                    alt="Foto BBM akhir"
                                >
                            </a>
                        </div>
                    <?php else: ?>
                        <p>Foto belum tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
<?php if ($usage->status_penggunaan === 'menunggu_pemeriksaan'): ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p>
                Periksa kesesuaian foto, kilometer, dan kondisi
                pengembalian kendaraan sebelum menyelesaikan pemeriksaan.
            </p>

            <button
                type="button"
                class="btn btn-success"
                data-toggle="modal"
                data-target="#modalSelesaiPemeriksaan"
            >
                <i class="fas fa-check"></i>
                Selesaikan Pemeriksaan
            </button>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div
        class="modal fade"
        id="modalSelesaiPemeriksaan"
        tabindex="-1"
        role="dialog"
        aria-labelledby="judulModalPemeriksaan"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="judulModalPemeriksaan"
                    >
                        Konfirmasi Pemeriksaan
                    </h5>

                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Tutup"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    Apakah kamu yakin ingin menyelesaikan pemeriksaan
                    pengembalian kendaraan ini?

                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="fas fa-exclamation-triangle"></i>
                        Pastikan kilometer awal dan akhir serta seluruh
                        foto kondisi kendaraan sudah diperiksa.
                        Setelah dikonfirmasi, status penggunaan menjadi
                        <strong>selesai</strong>.
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Batal
                    </button>

                    <?= form_open(
                        'ga/Bookings/complete_vehicle_usage/'
                        . $booking->id
                    ); ?>

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            <i class="fas fa-check"></i>
                            Ya, Selesaikan
                        </button>

                    <?= form_close(); ?>
                </div>

            </div>
        </div>
    </div>

<?php elseif ($usage->status_penggunaan === 'selesai'): ?>

    <div class="alert alert-success">
        Pemeriksaan kendaraan telah selesai.
    </div>

<?php endif; ?>

</div>