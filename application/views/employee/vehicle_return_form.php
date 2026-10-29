
<div class="container-fluid">

<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Pengembalian Kendaraan
        </h1>

        <a href="<?= base_url('employee/Bookings/detail/' . $booking->id); ?>"
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
                <strong>Keperluan:</strong>
                <?= html_escape($booking->purpose); ?>
            </p>

            <p>
                <strong>Kilometer Awal:</strong>
                <?= number_format($usage->km_awal, 0, ',', '.'); ?> km
            </p>

            <hr>

            <?php if ($usage->status_penggunaan === 'digunakan'): ?>

                <form
                    action="<?= base_url('employee/Bookings/save_vehicle_return/' . $booking->id); ?>"
                    method="post"
                    enctype="multipart/form-data"
                >
                    <div class="form-group">
                        <label for="km_akhir">Kilometer Akhir</label>
                        <input
                            type="number"
                            class="form-control"
                            id="km_akhir"
                            name="km_akhir"
                            min="<?= (int) $usage->km_awal; ?>"
                            step="1"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="foto_km_akhir">Foto Kilometer Akhir</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="foto_km_akhir"
                            name="foto_km_akhir"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >
                        <small class="form-text text-muted">
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="foto_bbm_akhir">Foto BBM Akhir</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="foto_bbm_akhir"
                            name="foto_bbm_akhir"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >
                        <small class="form-text text-muted">
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Data Pengembalian
                    </button>
<!-- 
                    <a
                        href="<?= base_url('employee/Bookings/detail/' . $booking->id); ?>"
                        class="btn btn-secondary mt-3"
                    >
                        Kembali
                    </a> -->
                </form>

            <?php else: ?>

                <div class="alert alert-info">
                    Data pengembalian sudah dikirim. Status:
                    <strong>
                        <?php if ($usage->status_penggunaan == 'belum_mulai'): ?>
                            Belum Mulai
                        <?php elseif ($usage->status_penggunaan == 'digunakan'): ?>
                            Sedang Digunakan
                        <?php elseif ($usage->status_penggunaan == 'menunggu_pemeriksaan'): ?>
                            Menunggu Pemeriksaan
                        <?php elseif ($usage->status_penggunaan == 'selesai'): ?>
                            Selesai
                        <?php else: ?>
                            
                                <?= htmlspecialchars($usage->status_penggunaan); ?>
                            
                        <?php endif; ?>
                    </strong>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
