<div class="card shadow mb-4">

    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            Booking Saya
        </h6>
    </div>

    <div class="card-body">

        <a href="<?= base_url('employee/Bookings/add'); ?>" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Ajukan Peminjaman
        </a>

        <?php if (empty($bookings)): ?>
            <div class="alert alert-info">
                Belum ada pengajuan peminjaman.
            </div>
        <?php else: ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Booking</th>
                        <th>Fasilitas</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $booking->booking_code; ?></td>
                            <td><?= $booking->facility_type; ?></td>
                            <td><?= $booking->start_date; ?> - <?= $booking->end_date; ?></td>
                            <td><?php if ($booking->status == 'pending'): ?> 
                                    Menunggu Persetujuan 
                                <?php elseif ($booking->status == 'approved'): ?> 
                                    Disetujui
                                <?php elseif ($booking->status == 'rejected'): ?> 
                                    Ditolak
                                <?php else: ?> 
                                    Dibatalkan
                                <?php endif ?></td>
                            <td>
                                <a href="<?= base_url('employee/Bookings/detail/' . $booking->id); ?>" class="btn btn-outline-info btn-sm">
                                <i class="far fa-eye"></i>
                                </a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>