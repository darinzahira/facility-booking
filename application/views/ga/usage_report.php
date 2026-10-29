
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Laporan Penggunaan Fasilitas
    </h1>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary
                                text-uppercase mb-1">
                        Total Booking
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= number_format($summary['total']); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success
                                text-uppercase mb-1">
                        Booking Disetujui
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= number_format($summary['approved']); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info
                                text-uppercase mb-1">
                        Booking Kendaraan Disetujui
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= number_format($summary['vehicle']); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning
                                text-uppercase mb-1">
                        Menunggu Pemeriksaan GA
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= number_format(
                            $summary['pending_inspection']
                        ); ?>
                    </div>
                    <small class="text-muted">
                        Kendaraan yang menunggu pemeriksaan
                    </small>
                </div>
            </div>
        </div>

    </div>

    <!-- Filter laporan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Filter Laporan
            </h6>
        </div>

        <div class="card-body">
            <form method="get"
                  action="<?= site_url('ga/Bookings/report'); ?>">

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label>Tanggal Mulai</label>
                        <input type="date"
                               name="start_date"
                               class="form-control"
                               value="<?= isset($filters['start_date'])
                                   ? html_escape($filters['start_date'])
                                   : ''; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label>Tanggal Akhir</label>
                        <input type="date"
                               name="end_date"
                               class="form-control"
                               value="<?= isset($filters['end_date'])
                                   ? html_escape($filters['end_date'])
                                   : ''; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label>Jenis Fasilitas</label>
                        <select name="facility_type" class="form-control">
                            <option value="">Semua Fasilitas</option>
                            <option value="vehicle"
                                <?= isset($filters['facility_type']) &&
                                    $filters['facility_type'] == 'vehicle'
                                    ? 'selected' : ''; ?>>
                                Kendaraan
                            </option>
                            <option value="room"
                                <?= isset($filters['facility_type']) &&
                                    $filters['facility_type'] == 'room'
                                    ? 'selected' : ''; ?>>
                                Kamar
                            </option>
                            <option value="meeting_room"
                                <?= isset($filters['facility_type']) &&
                                    $filters['facility_type'] == 'meeting_room'
                                    ? 'selected' : ''; ?>>
                                Ruang Meeting
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Status Booking</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending"
                                <?= isset($filters['status']) &&
                                    $filters['status'] == 'pending'
                                    ? 'selected' : ''; ?>>
                                Menunggu Persetujuan
                            </option>
                            <option value="approved"
                                <?= isset($filters['status']) &&
                                    $filters['status'] == 'approved'
                                    ? 'selected' : ''; ?>>
                                Disetujui
                            </option>
                            <option value="rejected"
                                <?= isset($filters['status']) &&
                                    $filters['status'] == 'rejected'
                                    ? 'selected' : ''; ?>>
                                Ditolak
                            </option>
                            <option value="cancelled"
                                <?= isset($filters['status']) &&
                                    $filters['status'] == 'cancelled'
                                    ? 'selected' : ''; ?>>
                                Dibatalkan
                            </option>
                        </select>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Tampilkan
                </button>

                <a href="<?= site_url('ga/Bookings/report'); ?>"
                   class="btn btn-secondary">
                    Reset
                </a>

                <a href="<?= site_url('ga/Bookings/export_csv') .
                    (!empty($filters) ? '?' . http_build_query($filters) : ''); ?>"
                class="btn btn-success">
                    <i class="fas fa-file-csv"></i> Ekspor Excel (CSV)
                </a>

            </form>
        </div>
    </div>

    <!-- Tabel laporan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Laporan
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover"
                       width="100%"
                       cellspacing="0">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Booking</th>
                            <th>Pemohon</th>
                            <th>Fasilitas</th>
                            <th>Jadwal</th>
                            <th>Keperluan</th>
                            <th>Status Booking</th>
                            <th>Status Penggunaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if (!empty($reports)): ?>
                        <?php $no = 1; ?>

                        <?php foreach ($reports as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <?= html_escape($row->booking_code); ?>
                                </td>

                                <td>
                                    <?= html_escape(
                                        $row->employee_name ?: '-'
                                    ); ?>
                                    <br>
                                    <small class="text-muted">
                                        <?= html_escape(
                                            $row->employee_code ?: '-'
                                        ); ?>
                                    </small>
                                </td>

                                <td>
                                    <?php
                                    if ($row->facility_type == 'vehicle') {
                                        echo 'Kendaraan';
                                        echo '<br><small>' .
                                            html_escape(
                                                $row->vehicle_name ?: '-'
                                            ) .
                                            ' (' .
                                            html_escape(
                                                $row->plate_number ?: '-'
                                            ) .
                                            ')</small>';
                                    } elseif (
                                        $row->facility_type == 'room'
                                    ) {
                                        echo 'Kamar';
                                        echo '<br><small>' .
                                            html_escape(
                                                $row->room_name ?: '-'
                                            ) .
                                            '</small>';
                                    } elseif (
                                        $row->facility_type == 'meeting_room'
                                    ) {
                                        echo 'Ruang Meeting';
                                        echo '<br><small>' .
                                            html_escape(
                                                $row->meeting_room_name ?: '-'
                                            ) .
                                            '</small>';
                                    } else {
                                        echo html_escape(
                                            $row->facility_type
                                        );
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($row->start_date)
                                    ); ?>

                                    <?php if (
                                        $row->start_date != $row->end_date
                                    ): ?>
                                        <br>s/d
                                        <?= date(
                                            'd-m-Y',
                                            strtotime($row->end_date)
                                        ); ?>
                                    <?php endif; ?>

                                    <br>
                                    <small class="text-muted">
                                        <?= html_escape(
                                            substr($row->start_time, 0, 5)
                                        ); ?>
                                        -
                                        <?= html_escape(
                                            substr($row->end_time, 0, 5)
                                        ); ?>
                                    </small>
                                </td>

                                <td>
                                    <?= html_escape($row->purpose ?: '-'); ?>
                                </td>

                                <td>
                                    <?php
                                    $status_labels = array(
                                        'pending'   => array(
                                            'Menunggu Persetujuan',
                                            'warning'
                                        ),
                                        'approved'  => array(
                                            'Disetujui',
                                            'success'
                                        ),
                                        'rejected'  => array(
                                            'Ditolak',
                                            'danger'
                                        ),
                                        'cancelled' => array(
                                            'Dibatalkan',
                                            'secondary'
                                        )
                                    );

                                    $booking_status = isset(
                                        $status_labels[$row->status]
                                    ) ? $status_labels[$row->status] : array(
                                        ucfirst($row->status),
                                        'secondary'
                                    );
                                    ?>

                                    <span class="badge badge-<?= $booking_status[1]; ?>">
                                        <?= $booking_status[0]; ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if (
                                        $row->facility_type != 'vehicle'
                                    ): ?>
                                        <span class="text-muted">-</span>

                                    <?php elseif (
                                        $row->status != 'approved'
                                    ): ?>
                                        <span class="text-muted">-</span>

                                    <?php else: ?>
                                        <?php
                                        $usage_labels = array(
                                            'belum_mulai' => array(
                                                'Belum Mulai',
                                                'secondary'
                                            ),
                                            'digunakan' => array(
                                                'Sedang Digunakan',
                                                'primary'
                                            ),
                                            'menunggu_pemeriksaan' => array(
                                                'Menunggu Pemeriksaan GA',
                                                'warning'
                                            ),
                                            'selesai' => array(
                                                'Selesai Diperiksa',
                                                'success'
                                            )
                                        );

                                        $usage_status = isset(
                                            $row->status_penggunaan
                                        ) ? $row->status_penggunaan : '';

                                        $usage_label = isset(
                                            $usage_labels[$usage_status]
                                        ) ? $usage_labels[$usage_status] : array(
                                            'Belum Ada Data',
                                            'secondary'
                                        );
                                        ?>

                                        <span class="badge badge-<?= $usage_label[1]; ?>">
                                            <?= $usage_label[0]; ?>
                                        </span>

                                        <?php if (
                                            $row->km_awal !== NULL &&
                                            $row->km_akhir !== NULL
                                        ): ?>
                                            <br>
                                            <small>
                                                Jarak:
                                                <?= number_format(
                                                    (int) $row->km_akhir -
                                                    (int) $row->km_awal
                                                ); ?> km
                                            </small>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="<?= site_url(
                                        'ga/Bookings/detail/' . $row->id
                                    ); ?>"
                                       class="btn btn-outline-info btn-sm"
                                       title="Lihat Detail Booking">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">
                                Tidak ada data laporan untuk filter ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>
