
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Data Pemakaian Kendaraan
        </h1>

        <a href="<?= base_url('employee/Bookings'); ?>"
           class="btn btn-info">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

    </div>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Informasi Booking
            </h6>
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
        </div>

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Riwayat Foto Kendaraan
            </h6>
        </div>
        
        <div class="card-body">
            
            <div class="alert alert-info">
                Status penggunaan:
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
            <div class="row">

                <!-- Foto awal -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header font-weight-bold">
                            Kondisi Awal
                        </div>

                        <div class="card-body">
                            <p>
                                <strong>Kilometer Awal:</strong>
                                <?= $usage->km_awal !== NULL
                                    ? number_format($usage->km_awal, 0, ',', '.') . ' km'
                                    : 'Belum diisi'; ?>
                            </p>

                            <p class="font-weight-bold">Foto Kilometer Awal</p>

                            <?php if (!empty($usage->foto_km_awal)): ?>
                                <a
                                    href="<?= base_url('uploads/vehicle_usage/' . rawurlencode($usage->foto_km_awal)); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="<?= base_url('uploads/vehicle_usage/' . rawurlencode($usage->foto_km_awal)); ?>"
                                        class="img-thumbnail mb-3"
                                        alt="Foto Kilometer Awal"
                                        style="width:100%; max-width:300px; object-fit: contain;"
                                    >
                                </a>
                            <?php else: ?>
                                <p class="text-muted">Foto belum tersedia.</p>
                            <?php endif; ?>

                            <p class="font-weight-bold">Foto BBM Awal</p>

                            <?php if (!empty($usage->foto_bbm_awal)): ?>
                                <a
                                    href="<?= base_url('uploads/vehicle_usage/' . rawurlencode($usage->foto_bbm_awal)); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="<?= base_url('uploads/vehicle_usage/' . rawurlencode($usage->foto_bbm_awal)); ?>"
                                        class="img-thumbnail mb-3"
                                        alt="Foto BBM Awal"
                                        style="width:100%; max-width:300px; object-fit: contain;"
                                    >
                                </a>
                            <?php else: ?>
                                <p class="text-muted">Foto belum tersedia.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Foto akhir -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header font-weight-bold">
                            Kondisi Akhir
                        </div>

                        <div class="card-body">
                            <p>
                                <strong>Kilometer Akhir:</strong>
                                <?= $usage->km_akhir !== NULL
                                    ? number_format($usage->km_akhir, 0, ',', '.') . ' km'
                                    : 'Belum diisi'; ?>
                            </p>

                            <p class="font-weight-bold">Foto Kilometer Akhir</p>

                            <?php if (!empty($usage->foto_km_akhir)): ?>
                                <a
                                    href="<?= base_url('uploads/vehicle_usage/' . rawurlencode($usage->foto_km_akhir)); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="<?= base_url('uploads/vehicle_usage/' . rawurlencode($usage->foto_km_akhir)); ?>"
                                        class="img-thumbnail mb-3"
                                        alt="Foto Kilometer Akhir"
                                        style="width:100%; max-width:300px; object-fit: contain;"
                                    >
                                </a>
                            <?php else: ?>
                                <p class="text-muted">Foto belum tersedia.</p>
                            <?php endif; ?>

                            <p class="font-weight-bold">Foto BBM Akhir</p>

                            <?php if (!empty($usage->foto_bbm_akhir)): ?>
                                <a
                                    href="<?= base_url('uploads/vehicle_usage/' . rawurlencode($usage->foto_bbm_akhir)); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="<?= base_url('uploads/vehicle_usage/' . rawurlencode($usage->foto_bbm_akhir)); ?>"
                                        class="img-thumbnail mb-3"
                                        alt="Foto BBM Akhir"
                                        style="width:100%; max-width:300px; object-fit: contain;"
                                    >
                                </a>
                            <?php else: ?>
                                <p class="text-muted">Foto belum tersedia.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php if ($usage->status_penggunaan == 'belum_mulai') : ?>

            <form method="post"
                    action="<?= base_url('employee/Bookings/save_vehicle_usage/' . $booking->id); ?>"
                    enctype="multipart/form-data">

                <div class="form-group">
                    <label>Kilometer Awal</label>
                    <input type="number"
                            name="km_awal"
                            class="form-control"
                            min="0"
                            step="1"
                            required>
                </div>

                <div class="form-group">
                    <label>Foto Kilometer Awal</label>
                    <input type="file"
                            name="foto_km_awal"
                            class="form-control-file"
                            accept="image/jpeg,image/png,image/webp"
                            required>
                </div>

                <div class="form-group">
                    <label>Foto Kondisi BBM Awal</label>
                    <input type="file"
                            name="foto_bbm_awal"
                            class="form-control-file"
                            accept="image/jpeg,image/png,image/webp"
                            required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Data Awal
                </button>
<!-- 
                <a
                    href="<?= base_url('employee/Bookings'); ?>"
                    class="btn btn-info"
                >
                    <i class="fas fa-angle-left"></i>
                    Kembali
                </a> -->

            </form>

        <?php else : ?>

            <div class="alert alert-info">
                Data awal pemakaian sudah tercatat atau proses
                penggunaan sudah dimulai.
            </div>

        <?php endif; ?>

    </div>

</div>
