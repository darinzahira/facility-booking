<div class="container-fluid"> 

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Detail Booking
        </h1>

        <a href="<?= base_url('ga/Bookings'); ?>"
           class="btn btn-info">

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

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informasi Pemohon
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%">NIK Pemohon</th>
                                    <td>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Pemohon</th>
                                    <td>
                                        <?= $booking->name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>Perusahaan</th>
                                    <td>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nomor Telpon</th>
                                    <td>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pengajuan -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informasi Pengajuan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%">Kode Booking</th>
                                    <td>
                                        <?= $booking->booking_code; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fasilitas</th>
                                    <td>
                                        <!-- <?= ucfirst($booking->facility_type); ?> -->
                                        <?php if ($booking->facility_type == 'vehicle'): ?>
                                            Kendaraan
                                        <?php elseif ($booking->facility_type == 'room'): ?>
                                            Kamar
                                        <?php else: ?>
                                            Ruang Meeting
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Pengajuan</th>
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
                                </tr>
                                <?php if ($booking->status == 'rejected' && !empty($booking->rejection_reason)): ?>
                                <tr>
                                    <th>Alasan Penolakan</th>
                                    <td>
                                        <?= nl2br(htmlspecialchars($booking->rejection_reason)); ?>

                                    </td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>Jumlah Orang</th>
                                    <td>
                                        <?= $booking->participant_count; ?> Orang
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>
                                        <?php if ($booking->start_date && $booking->end_date): ?>

                                            <?= date('d-m-Y', strtotime($booking->start_date)); ?>
                                             s/d 
                                            <?= date('d-m-Y', strtotime($booking->end_date)); ?> 

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Tidak ada Tanggal khusus
                                            </span>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Waktu</th>
                                    <td>
                                        <?php if ($booking->start_time && $booking->end_time): ?>

                                            <?= date('H:i', strtotime($booking->start_time)); ?> WIB
                                            -
                                            <?= date('H:i', strtotime($booking->end_time)); ?> WIB

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Tidak ada waktu khusus
                                            </span>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($booking->facility_type == 'vehicle'): ?>
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
                                    <th width="35%">Kendaraan</th>
                                    <td>
                                        <?php if (!empty($booking->vehicle_name)): ?>

                                            <?= $booking->vehicle_name; ?>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Belum ditentukan
                                            </span>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nomor Polisi</th>
                                    <td>
                                        <?php if (!empty($booking->plate_number)): ?>

                                            <?= $booking->plate_number; ?>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Belum ditentukan
                                            </span>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                </tr>
                                <!-- <tr>
                                    <th>Kapasitas</th>
                                    <td>
                                        <?= $booking->kapasitas_kendaraan; ?> Orang
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>Driver</th>
                                    <td>
                                        <?php if (!empty($booking->driver_name)): ?>

                                            <?= $booking->driver_name; ?>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Belum ditentukan
                                            </span>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keperluan</th>
                                    <td>
                                        <?= nl2br(htmlspecialchars($booking->purpose)); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($booking->facility_type == 'room'): ?>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informasi Kamar
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%">Kamar</th>
                                    <td>
                                        <?php if (!empty($booking->room_name)): ?>

                                            <?= $booking->room_name; ?>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Kamar belum ditentukan.
                                            </span>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>Kapasitas</th>
                                    <td>
                                        <?= $booking->kapasitas_kamar; ?> Orang
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>Keperluan</th>
                                    <td>
                                        <?= nl2br(htmlspecialchars($booking->purpose)); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($booking->facility_type == 'meeting_room'): ?>
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informasi Ruang Meeting
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%">Ruang Meeting</th>
                                    <td>
                                        <?php if (!empty($booking->meeting_room_name)): ?>

                                            <?= $booking->meeting_room_name; ?>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Meeting room belum ditentukan.
                                            </span>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>Kapasitas</th>
                                    <td>
                                        <?= $booking->kapasitas_meeting; ?> Orang
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>Keperluan</th>
                                    <td>
                                        <?= nl2br(htmlspecialchars($booking->purpose)); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div> 

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
                        Tolak

                    </button>


                    <button type="button"
                            class="btn btn-success"
                            data-toggle="modal"
                            data-target="#approveModal">

                        <i class="fas fa-check"></i>
                        Setujui

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