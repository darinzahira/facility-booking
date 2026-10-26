
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pengembalian Kendaraan</h1>

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
                </form>

            <?php else: ?>

                <div class="alert alert-info">
                    Data pengembalian sudah dikirim. Status:
                    <strong>
                        <?= html_escape($usage->status_penggunaan); ?>
                    </strong>
                </div>

            <?php endif; ?>

            <a
                href="<?= base_url('employee/Bookings/detail/' . $booking->id); ?>"
                class="btn btn-secondary mt-3"
            >
                Kembali ke Detail Booking
            </a>
        </div>
    </div>
</div>
