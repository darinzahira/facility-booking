<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Detail Peminjaman
        </h6>
    </div>

    <div class="card-body">

        <!-- INFORMASI BOOKING -->
        <h6 class="font-weight-bold text-dark mb-3">
            Informasi Booking
        </h6>

        <div class="row mb-2">
            <div class="col-md-3 font-weight-bold">
                Kode Booking
            </div>
            <div class="col-md-9">
                : <?= $booking->booking_code; ?>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-3 font-weight-bold">
                Pemohon
            </div>
            <div class="col-md-9">
                : <?= $booking->name; ?>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-3 font-weight-bold">
                Fasilitas
            </div>
            <div class="col-md-9">
                : <?= ucfirst(str_replace('_', ' ', $booking->facility_type)); ?>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-3 font-weight-bold">
                Tanggal
            </div>
            <div class="col-md-9">
                :
                <?= date('d-m-Y', strtotime($booking->start_date)); ?>

                <?php if ($booking->start_date != $booking->end_date): ?>
                    s/d
                    <?= date('d-m-Y', strtotime($booking->end_date)); ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-3 font-weight-bold">
                Waktu
            </div>
            <div class="col-md-9">
                :
                <?= $booking->start_time
                    ? date('H:i', strtotime($booking->start_time))
                    : '-'; ?>

                s/d

                <?= $booking->end_time
                    ? date('H:i', strtotime($booking->end_time))
                    : '-'; ?>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-3 font-weight-bold">
                Keperluan
            </div>
            <div class="col-md-9">
                : <?= nl2br(htmlspecialchars($booking->purpose)); ?>
            </div>
        </div>


        <hr>


        <!-- INFORMASI FASILITAS -->
        <h6 class="font-weight-bold text-dark mb-3">
            Informasi Fasilitas
        </h6>


        <?php if ($booking->facility_type == 'vehicle'): ?>

            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">
                    Kendaraan
                </div>
                <div class="col-md-9">
                    :
                    <?= !empty($booking->vehicle_name)
                        ? $booking->vehicle_name
                        : '-'; ?>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">
                    Plat Nomor
                </div>
                <div class="col-md-9">
                    :
                    <?= !empty($booking->plate_number)
                        ? $booking->plate_number
                        : '-'; ?>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">
                    Driver
                </div>
                <div class="col-md-9">
                    :
                    <?= !empty($booking->driver_name)
                        ? $booking->driver_name
                        : '-'; ?>
                </div>
            </div>


        <?php elseif ($booking->facility_type == 'room'): ?>

            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">
                    Kamar
                </div>
                <div class="col-md-9">
                    :
                    <?= !empty($booking->room_name)
                        ? $booking->room_name
                        : '-'; ?>
                </div>
            </div>


        <?php elseif ($booking->facility_type == 'meeting_room'): ?>

            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">
                    Meeting Room
                </div>
                <div class="col-md-9">
                    :
                    <?= !empty($booking->meeting_room_name)
                        ? $booking->meeting_room_name
                        : '-'; ?>
                </div>
            </div>

        <?php endif; ?>


        <hr>


        <!-- STATUS -->
        <h6 class="font-weight-bold text-dark mb-3">
            Status Peminjaman
        </h6>

        <div class="row mb-2">
            <div class="col-md-3 font-weight-bold">
                Status
            </div>

            <div class="col-md-9">

                <?php if ($booking->status == 'pending'): ?>

                    <span class="badge badge-warning">
                        Menunggu Persetujuan
                    </span>

                <?php elseif ($booking->status == 'approved'): ?>

                    <span class="badge badge-success">
                        Disetujui
                    </span>

                <?php elseif ($booking->status == 'rejected'): ?>

                    <span class="badge badge-danger">
                        Ditolak
                    </span>

                <?php elseif ($booking->status == 'cancelled'): ?>

                    <span class="badge badge-secondary">
                        Dibatalkan
                    </span>

                <?php endif; ?>

            </div>
        </div>


        <?php if ($booking->status == 'rejected' && !empty($booking->rejection_reason)): ?>

            <div class="row mb-2">

                <div class="col-md-3 font-weight-bold">
                    Alasan Penolakan
                </div>

                <div class="col-md-9">
                    : <?= nl2br(htmlspecialchars($booking->rejection_reason)); ?>
                </div>

            </div>

        <?php endif; ?>


        <hr>


        <!-- TOMBOL -->
        <div class="mt-4">

            <a
                href="<?= base_url('employee/Bookings'); ?>"
                class="btn btn-secondary"
            >
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>

            <?php if ($booking->status == 'pending'): ?>

            <a
                href="<?= base_url('employee/Bookings/edit/' . $booking->id); ?>"
                class="btn btn-info"
            >
                <i class="fas fa-edit"></i>
                Edit
            </a>

            <?php endif; ?>

            <?php if ($booking->status == 'pending' || $booking->status == 'approved'): ?>

            <a
                href=""
                class="btn btn-danger"
                data-toggle="modal" data-target="#cancelModal"
            >
                <i class="fas fa-times"></i>
                Batalkan
            </a>

            <?php endif; ?>

            <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Batalkan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin membatalkan peminjaman ini?</div>
                <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <a class="btn btn-info" href="<?= base_url('employee/Bookings/cancel/' . $booking->id); ?>">Ya</a>
                </div>
            </div>
            </div>
            </div>

        </div>

    </div>
</div>