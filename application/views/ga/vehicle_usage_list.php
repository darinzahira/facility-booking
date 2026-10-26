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
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Booking</th>
                            <th>ID Karyawan</th>
                            <th>ID Kendaraan</th>
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
                                    <td><?= html_escape($usage->employee_id); ?></td>
                                    <td><?= html_escape($usage->vehicle_id); ?></td>
                                    <td>
                                        <?= html_escape($usage->tanggal_mulai); ?>
                                    </td>
                                    <td>
                                        <?= html_escape($usage->tanggal_selesai); ?>
                                    </td>
                                    <td><?= html_escape($usage->km_awal); ?></td>
                                    <td><?= html_escape($usage->km_akhir); ?></td>
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