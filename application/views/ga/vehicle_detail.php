<?php  
    $id = $vehicle->id;
    $vehicle_code = $vehicle->vehicle_code;
    $vehicle_name = $vehicle->vehicle_name;
    $plate_number = $vehicle->plate_number;
    $jenis = $vehicle->jenis;
    $tahun = $vehicle->tahun;
    $warna = $vehicle->warna;
    $lokasi = $vehicle->lokasi;
    $kapasitas = $vehicle->kapasitas;
    $notes = $vehicle->notes;
    $vehicle_photo = $vehicle->vehicle_photo;
    $status = $vehicle->status;
    $requires_driver = $vehicle->requires_driver;
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Detail Kendaraan
            </h1>
            <p class="mb-0 text-muted">
                Informasi lengkap kendaraan operasional
            </p>
        </div>
        <div>
            <a href="<?= base_url('ga/Vehicles'); ?>"
               class="btn btn-info">

                <i class="fas fa-angle-left"></i>
                Kembali
            </a>
            <a href="<?= base_url('ga/Vehicles/edit/' . $id); ?>"
               class="btn btn-warning">
                <i class="fas fa-edit "></i>
                Edit Kendaraan
            </a>
        </div>
    </div>
    <!-- Profil Kendaraan -->
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <!-- Foto Kendaraan Sementara -->
                    <div class="mb-3">
                        <?php if (!empty($vehicle_photo)): ?>
                            <img
                                src="<?= base_url('uploads/vehicles/' . rawurlencode($vehicle_photo)); ?>"
                                alt="Foto Kendaraan"
                                class="img-fluid rounded"
                                style="max-height: 250px; object-fit: contain;"
                            >
                        <?php else: ?>
                            <i class="fas fa-car fa-5x text-gray-400"></i>
                            <p class="text-muted small mt-2">
                                Foto kendaraan belum tersedia.
                            </p>
                        <?php endif; ?>
                    </div>
                    <h4 class="font-weight-bold text-gray-800">
                        <?= html_escape($vehicle_name); ?>
                    </h4>
                    <h5 class="text-primary font-weight-bold">
                        <?= html_escape($plate_number); ?>
                    </h5>
                    <p class="text-muted mb-3">
                        <?= html_escape($jenis); ?>
                    </p>
                    <?php if ($status == 'Aktif'): ?>
                        <span class="badge badge-success px-3 py-2">
                            Aktif
                        </span>
                    <?php else: ?>
                        <span class="badge badge-secondary px-3 py-2">
                            <?= html_escape($status); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Informasi Kendaraan -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informasi Kendaraan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%">Kode Kendaraan</th>
                                    <td>
                                        <?= html_escape($vehicle_code); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nomor Polisi</th>
                                    <td>
                                        <?= html_escape($plate_number); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Brand Kendaraan</th>
                                    <td>
                                        <?= html_escape($vehicle_name); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Kendaraan</th>
                                    <td>
                                        <?= html_escape($jenis); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tahun Kendaraan</th>
                                    <td>
                                        <?= html_escape($tahun); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Warna Kendaraan</th>
                                    <td>
                                        <?= html_escape($warna); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kapasitas</th>
                                    <td>
                                        <?= html_escape($kapasitas); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>
                                        <?= html_escape($lokasi); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kebutuhan Sopir</th>
                                    <td>
                                        <?php if ($requires_driver == 'Ya'): ?>
                                            <span class="badge badge-info">
                                                <i class="fas fa-user-tie"></i>
                                                Memerlukan Sopir
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">
                                                Tanpa Sopir
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Kendaraan</th>
                                    <td>
                                        <?php if ($status == 'Aktif'): ?>
                                            <span class="badge badge-success">
                                                Aktif
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">
                                                <?= html_escape($status); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>