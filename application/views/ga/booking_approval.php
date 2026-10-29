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
                                        <?= $booking->employee_code; ?>
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
                                        <?= $booking->position; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Perusahaan</th>
                                    <td>
                                        <?= $booking->company_name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nomor Telpon</th>
                                    <td>
                                        <?= $booking->phone; ?>
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
               <?php if ($booking->status == 'pending'): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Penetapan Fasilitas dan Persetujuan
                        </h6>
                    </div>
                    <div class="card-body">
                        <p>
                            Pilih fasilitas yang akan digunakan sebelum menyetujui booking ini.
                        </p>
                        <form action="<?= base_url('ga/Bookings/assign_approve/' . $booking->id); ?>"
                            method="post"
                            id="approveBookingForm">
                            <?php if ($booking->facility_type == 'vehicle'): ?>
                                <!-- Pilih kendaraan -->
                                <div class="form-group">
                                    <label for="vehicle_id">Kendaraan</label>
                                    <select
                                        name="vehicle_id"
                                        id="vehicle_id"
                                        class="form-control"
                                        required
                                    >
                                        <option value="">-- Pilih Kendaraan --</option>

                                        <?php foreach ($vehicles as $vehicle): ?>
                                            <option
                                                value="<?= $vehicle->id; ?>"
                                                data-driver="<?= $vehicle->requires_driver; ?>"
                                            >
                                                <?= $vehicle->vehicle_name; ?>
                                                - <?= $vehicle->plate_number; ?>
                                                (Kapasitas: <?= $vehicle->kapasitas; ?> orang)
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>

                                <!-- Pilih driver -->
                                <div class="form-group">
                                    <label for="driver_id">Driver</label>

                                    <select
                                        name="driver_id"
                                        id="driver_id"
                                        class="form-control"
                                    >
                                        <option value="">-- Pilih Driver --</option>

                                        <?php foreach ($drivers as $driver): ?>
                                            <option value="<?= $driver->id; ?>">
                                                <?= $driver->name; ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>

                                    <small class="form-text text-muted">
                                        Jika kendaraan mewajibkan driver, driver harus dipilih.
                                    </small>
                                </div>

                            <?php elseif ($booking->facility_type == 'room'): ?>

                                <!-- Pilih ruangan -->
                                <div class="form-group">
                                    <label for="room_id">Ruangan</label>

                                    <select
                                        name="room_id"
                                        id="room_id"
                                        class="form-control"
                                        required
                                    >
                                        <option value="">-- Pilih Ruangan --</option>

                                        <?php foreach ($rooms as $room): ?>
                                            <option value="<?= $room->id; ?>">
                                                <?= $room->room_name; ?>
                                                (Kapasitas: <?= $room->capacity; ?> orang)
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>

                            <?php elseif ($booking->facility_type == 'meeting_room'): ?>

                                <!-- Pilih meeting room -->
                                <div class="form-group">
                                    <label for="meeting_room_id">Meeting Room</label>

                                    <select
                                        name="meeting_room_id"
                                        id="meeting_room_id"
                                        class="form-control"
                                        required
                                    >
                                        <option value="">-- Pilih Meeting Room --</option>

                                        <?php foreach ($meeting_rooms as $meeting_room): ?>
                                            <option value="<?= $meeting_room->id; ?>">
                                                <?= $meeting_room->room_name; ?>
                                                (Kapasitas: <?= $meeting_room->capacity; ?> orang)
                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>

                            <?php endif; ?>

                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#confirmApproveModal">
                                <i class="fas fa-check"></i> Setujui Booking
                            </button>

                            <button type="button"
                                    class="btn btn-danger"
                                    data-toggle="modal"
                                    data-target="#rejectModal">
                                <i class="fas fa-times"></i> Tolak Booking
                            </button>
                            <a
                                href="<?= base_url('ga/Bookings'); ?>"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                        </form>
                    </div>
                </div>

            <?php endif; ?>
            </div>
        </div>
    </div> 

</div>


<!-- ========================= -->
<!-- MODAL APPROVE -->
<!-- ========================= -->

<!-- Modal Konfirmasi Persetujuan -->
<div class="modal fade" id="confirmApproveModal"
     tabindex="-1" role="dialog"
     aria-labelledby="confirmApproveLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="confirmApproveLabel">
                    Konfirmasi Persetujuan Booking
                </h5>

                <button type="button" class="close text-white"
                        data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                Apakah kamu yakin ingin menyetujui booking ini
                dengan fasilitas yang telah dipilih?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">
                    Batal
                </button>

                <button type="button" class="btn btn-success"
                        id="confirmApproveButton">
                    <i class="fas fa-check"></i> Ya, Setujui
                </button>
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

    <div class="modal-dialog modal-dialog-centered"
         role="document">

        <div class="modal-content">

            <form method="post"
                  action="<?= base_url('ga/Bookings/reject/' . $booking->id); ?>">

                <div class="modal-header bg-danger text-white">

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

                       <i class="fas fa-times"></i> Tolak Booking

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>