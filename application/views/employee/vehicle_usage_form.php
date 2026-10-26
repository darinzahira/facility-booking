
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Data Awal Pemakaian Kendaraan
    </h1>

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

            <hr>

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

                </form>

            <?php else : ?>

                <div class="alert alert-info">
                    Data awal pemakaian sudah tercatat atau proses
                    penggunaan sudah dimulai.
                </div>

            <?php endif; ?>

            <a href="<?= base_url('employee/Bookings/detail/' . $booking->id); ?>"
               class="btn btn-secondary mt-3">
                Kembali ke Detail Booking
            </a>

        </div>
    </div>

</div>
