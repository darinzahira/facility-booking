<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Booking</h1>
    </div>

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Pengajuan Peminjaman
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Booking</th>
                            <th>Pemohon</th>
                            <th>Fasilitas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($bookings)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $booking->booking_code; ?></td>
                                    <td><?= $booking->name; ?></td>
                                    <td><?= ucfirst($booking->facility_type); ?>
                                    </td>
                                    <td><?= date('d-m-Y', strtotime($booking->start_date)); ?>
                                        <?php if ($booking->start_date != $booking->end_date): ?>
                                            s/d
                                            <?= date('d-m-Y', strtotime($booking->end_date)); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($booking->status == 'pending'): ?>
                                            <span class="badge badge-warning">
                                                Pending
                                            </span>
                                        <?php elseif ($booking->status == 'approved'): ?>
                                            <span class="badge badge-success">
                                                Approved
                                            </span>
                                        <?php elseif ($booking->status == 'rejected'): ?>
                                            <span class="badge badge-danger">
                                                Rejected
                                            </span>
                                        <?php elseif ($booking->status == 'cancelled'): ?>
                                            <span class="badge badge-secondary">
                                                Cancelled
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">
                                                <?= ucfirst($booking->status); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('ga/Bookings/detail/' . $booking->id); ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                            Detail </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum ada pengajuan booking.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>