<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Detail Booking
        </h1>

        <a href="<?= base_url('ga/Bookings'); ?>"
           class="btn btn-sm btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

    </div>


    <!-- Flash Message -->

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


    <!-- Detail Booking -->

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Informasi Pengajuan
            </h6>

        </div>


        <div class="card-body">

            <div class="row">

                <!-- Kode Booking -->
                <div class="col-md-6 mb-3">

                    <label class="font-weight-bold">
                        Kode Booking
                    </label>

                    <div>
                        <?= $booking->booking_code; ?>
                    </div>

                </div>


                <!-- Pemohon -->
                <div class="col-md-6 mb-3">

                    <label class="font-weight-bold">
                        Pemohon
                    </label>

                    <div>
                        <?= $booking->name; ?>
                    </div>

                </div>


                <!-- Fasilitas -->
                <div class="col-md-6 mb-3">

                    <label class="font-weight-bold">
                        Fasilitas
                    </label>

                    <div>
                        <?= ucfirst($booking->facility_type); ?>
                    </div>

                </div>


                <!-- Status -->
                <div class="col-md-6 mb-3">

                    <label class="font-weight-bold">
                        Status
                    </label>

                    <div>

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

                    </div>

                </div>


                <!-- Tanggal Mulai -->
                <div class="col-md-6 mb-3">

                    <label class="font-weight-bold">
                        Tanggal Mulai
                    </label>

                    <div>
                        <?= date('d-m-Y', strtotime($booking->start_date)); ?>
                    </div>

                </div>


                <!-- Tanggal Selesai -->
                <div class="col-md-6 mb-3">

                    <label class="font-weight-bold">
                        Tanggal Selesai
                    </label>

                    <div>
                        <?= date('d-m-Y', strtotime($booking->end_date)); ?>
                    </div>

                </div>


                <!-- Jam -->
                <div class="col-md-6 mb-3">

                    <label class="font-weight-bold">
                        Waktu
                    </label>

                    <div>

                        <?php if ($booking->start_time && $booking->end_time): ?>

                            <?= date('H:i', strtotime($booking->start_time)); ?>
                            -
                            <?= date('H:i', strtotime($booking->end_time)); ?>

                        <?php else: ?>

                            <span class="text-muted">
                                Tidak ada waktu khusus
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


                <!-- Keperluan -->
                <div class="col-md-12 mb-3">

                    <label class="font-weight-bold">
                        Keperluan
                    </label>

                    <div class="border rounded p-3">

                        <?= nl2br(htmlspecialchars($booking->purpose)); ?>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Informasi Kendaraan -->

    <?php if ($booking->facility_type == 'vehicle'): ?>

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Informasi Kendaraan
                </h6>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Kendaraan
                        </label>

                        <div>

                            <?php if (!empty($booking->vehicle_name)): ?>

                                <?= $booking->vehicle_name; ?>

                            <?php else: ?>

                                <span class="text-muted">
                                    Belum ditentukan
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Nomor Polisi
                        </label>

                        <div>

                            <?php if (!empty($booking->plate_number)): ?>

                                <?= $booking->plate_number; ?>

                            <?php else: ?>

                                <span class="text-muted">
                                    Belum ditentukan
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="font-weight-bold">
                            Driver
                        </label>

                        <div>

                            <?php if (!empty($booking->driver_name)): ?>

                                <?= $booking->driver_name; ?>

                            <?php else: ?>

                                <span class="text-muted">
                                    Belum ditentukan
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php endif; ?>


    <!-- Informasi Ruangan -->

    <?php if ($booking->facility_type == 'room'): ?>

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Informasi Ruangan
                </h6>

            </div>

            <div class="card-body">

                <?php if (!empty($booking->room_name)): ?>

                    <?= $booking->room_name; ?>

                <?php else: ?>

                    <span class="text-muted">
                        Ruangan belum ditentukan.
                    </span>

                <?php endif; ?>

            </div>

        </div>

    <?php endif; ?>


    <!-- Informasi Meeting Room -->

    <?php if ($booking->facility_type == 'meeting_room'): ?>

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">
                    Informasi Meeting Room
                </h6>

            </div>

            <div class="card-body">

                <?php if (!empty($booking->meeting_room_name)): ?>

                    <?= $booking->meeting_room_name; ?>

                <?php else: ?>

                    <span class="text-muted">
                        Meeting room belum ditentukan.
                    </span>

                <?php endif; ?>

            </div>

        </div>

    <?php endif; ?>


    <!-- Alasan Penolakan -->

    <?php if ($booking->status == 'rejected' && !empty($booking->rejection_reason)): ?>

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-danger">
                    Alasan Penolakan
                </h6>

            </div>

            <div class="card-body">

                <?= nl2br(htmlspecialchars($booking->rejection_reason)); ?>

            </div>

        </div>

    <?php endif; ?>


    <!-- Tombol Approval -->

    <?php if ($booking->status == 'pending'): ?>

        <div class="card shadow mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-end">

                    <button type="button"
                            class="btn btn-danger mr-2"
                            data-toggle="modal"
                            data-target="#rejectModal">

                        <i class="fas fa-times"></i>
                        Reject

                    </button>


                    <button type="button"
                            class="btn btn-success"
                            data-toggle="modal"
                            data-target="#approveModal">

                        <i class="fas fa-check"></i>
                        Approve

                    </button>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>


<!-- ========================= -->
<!-- MODAL APPROVE -->
<!-- ========================= -->

<div class="modal fade"
     id="approveModal"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog"
         role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Konfirmasi Approval
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <div class="modal-body">

                Apakah Anda yakin ingin menyetujui booking

                <strong>
                    <?= $booking->booking_code; ?>
                </strong>?

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                    Batal

                </button>


                <a href="<?= base_url('ga/Bookings/approve/' . $booking->id); ?>"
                   class="btn btn-success">

                    Ya, Approve

                </a>

            </div>

        </div>

    </div>

</div>


<!-- ========================= -->
<!-- MODAL REJECT -->
<!-- ========================= -->

<div class="modal fade"
     id="rejectModal"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog"
         role="document">

        <div class="modal-content">

            <form method="post"
                  action="<?= base_url('ga/Bookings/reject/' . $booking->id); ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Tolak Booking
                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            Alasan Penolakan
                        </label>

                        <textarea
                            name="rejection_reason"
                            class="form-control"
                            rows="4"
                            placeholder="Masukkan alasan penolakan..."><?= set_value('rejection_reason'); ?></textarea>

                        <?= form_error(
                            'rejection_reason',
                            '<small class="text-danger">',
                            '</small>'
                        ); ?>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Batal

                    </button>


                    <button type="submit"
                            class="btn btn-danger">

                        Tolak Booking

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>