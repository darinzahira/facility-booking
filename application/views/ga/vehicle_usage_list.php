<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Pemeriksaan Pengembalian Kendaraan
    </h1>

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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Kendaraan Menunggu Pemeriksaan
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Booking</th>
                            <th>Karyawan</th>
                            <th>Kendaraan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Pengembalian</th>
                            <th>KM Awal</th>
                            <th>KM Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($usages)): ?>
                            <?php $no = 1; ?>

                            <?php foreach ($usages as $usage): ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= html_escape($usage->booking_code); ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= html_escape(
                                                $usage->employee_name
                                                ?: 'Karyawan tidak ditemukan'
                                            ); ?>
                                        </strong>
                                        <br>
                                        <small class="text-muted">
                                            <?= html_escape(
                                                $usage->employee_code
                                                ?: '-'
                                            ); ?>
                                        </small>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= html_escape(
                                                $usage->vehicle_name
                                                ?: 'Kendaraan tidak ditemukan'
                                            ); ?>
                                        </strong>
                                        <br>
                                        <small class="text-muted">
                                            <?= html_escape(
                                                $usage->plate_number ?: '-'
                                            ); ?>
                                        </small>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd-m-Y',
                                            strtotime($usage->tanggal_mulai)
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd-m-Y',
                                            strtotime($usage->tanggal_selesai)
                                        ); ?>
                                    </td>

                                    <td>
                                        <?= $usage->km_awal !== null
                                            && $usage->km_awal !== ''
                                            ? number_format((float) $usage->km_awal, 0, ',', '.') . ' km'
                                            : '-'; ?>
                                    </td>

                                    <td>
                                        <?= $usage->km_akhir !== null
                                            && $usage->km_akhir !== ''
                                            ? number_format((float) $usage->km_akhir, 0, ',', '.') . ' km'
                                            : '-'; ?>
                                    </td>

                                    <td>
                                        <a
                                            href="<?= site_url(
                                                'ga/Bookings/vehicle_usage_detail/'
                                                . $usage->booking_id
                                            ); ?>"
                                            class="btn btn-info btn-sm"
                                        >
                                            <i class="fas fa-search"></i>
                                            Periksa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">
                                    Belum ada pengembalian kendaraan
                                    yang menunggu pemeriksaan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>