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
                                <tr>
                                    <th>Kapasitas</th>
                                    <td>
                                        <?php if (!empty($booking->kapasitas_kendaraan)): ?>

                                             <?= $booking->kapasitas_kendaraan; ?> Orang

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Belum ditentukan
                                            </span>

                                        <?php endif; ?>
                                    </td>
                                </tr>
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
                
                <?php if ($booking->facility_type == 'vehicle'): ?>

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Riwayat Penggunaan Kendaraan
                        </h6>
                    </div>

                    <div class="card-body">

                        <?php
                        $ada_data_penggunaan =
                            !empty($booking->status_penggunaan) ||
                            !empty($booking->foto_km_awal) ||
                            !empty($booking->foto_bbm_awal) ||
                            !empty($booking->foto_km_akhir) ||
                            !empty($booking->foto_bbm_akhir);
                        ?>

                        <?php if ($ada_data_penggunaan): ?>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 h-100">
                                        <h6 class="font-weight-bold text-primary">
                                            Data Awal Penggunaan
                                        </h6>

                                        <p class="mb-2">
                                            <strong>Kilometer Awal:</strong>
                                            <?= $booking->km_awal !== null
                                                && $booking->km_awal !== ''
                                                ? number_format((float) $booking->km_awal, 0, ',', '.') . ' km'
                                                : '-'; ?>
                                        </p>

                                        <p class="mb-2">
                                            <strong>Tanggal Mulai:</strong>
                                            <?php if (!empty($booking->tanggal_mulai)): ?>
                                                <?= date('d-m-Y H:i', strtotime($booking->tanggal_mulai)); ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </p>

                                        <div class="form-group mt-3">
                                            <label class="font-weight-bold">
                                                Foto Kilometer Awal
                                            </label>

                                            <?php if (!empty($booking->foto_km_awal)): ?>
                                                <a href="<?= base_url('uploads/vehicle_usage/' . rawurlencode(basename($booking->foto_km_awal))); ?>"
                                                   target="_blank"
                                                   rel="noopener noreferrer">
                                                    <img
                                                        src="<?= base_url('uploads/vehicle_usage/' . rawurlencode(basename($booking->foto_km_awal))); ?>"
                                                        alt="Foto kilometer awal"
                                                        class="img-thumbnail d-block"
                                                        style="width:100%; max-height:220px; object-fit:contain;">
                                                </a>
                                            <?php else: ?>
                                                <p class="text-muted">Foto belum tersedia.</p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group mb-0">
                                            <label class="font-weight-bold">
                                                Foto BBM Awal
                                            </label>

                                            <?php if (!empty($booking->foto_bbm_awal)): ?>
                                                <a href="<?= base_url('uploads/vehicle_usage/' . rawurlencode(basename($booking->foto_bbm_awal))); ?>"
                                                   target="_blank"
                                                   rel="noopener noreferrer">
                                                    <img
                                                        src="<?= base_url('uploads/vehicle_usage/' . rawurlencode(basename($booking->foto_bbm_awal))); ?>"
                                                        alt="Foto BBM awal"
                                                        class="img-thumbnail d-block"
                                                        style="width:100%; max-height:220px; object-fit:contain;">
                                                </a>
                                            <?php else: ?>
                                                <p class="text-muted">Foto belum tersedia.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 h-100">
                                        <h6 class="font-weight-bold text-primary">
                                            Data Akhir Penggunaan
                                        </h6>

                                        <p class="mb-2">
                                            <strong>Kilometer Akhir:</strong>
                                            <?= $booking->km_akhir !== null
                                                && $booking->km_akhir !== ''
                                                ? number_format((float) $booking->km_akhir, 0, ',', '.') . ' km'
                                                : '-'; ?>
                                        </p>

                                        <p class="mb-2">
                                            <strong>Tanggal Selesai:</strong>
                                            <?php if (!empty($booking->tanggal_selesai)): ?>
                                                <?= date('d-m-Y H:i', strtotime($booking->tanggal_selesai)); ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </p>

                                        <?php if (
                                            $booking->km_awal !== null &&
                                            $booking->km_awal !== '' &&
                                            $booking->km_akhir !== null &&
                                            $booking->km_akhir !== ''
                                        ): ?>
                                            <p class="mb-2">
                                                <strong>Total Jarak:</strong>
                                                <?php
                                                $total_jarak = (float) $booking->km_akhir
                                                    - (float) $booking->km_awal;
                                                ?>
                                                <?= number_format($total_jarak, 0, ',', '.'); ?> km
                                            </p>
                                        <?php endif; ?>

                                        <div class="form-group mt-3">
                                            <label class="font-weight-bold">
                                                Foto Kilometer Akhir
                                            </label>

                                            <?php if (!empty($booking->foto_km_akhir)): ?>
                                                <a href="<?= base_url('uploads/vehicle_usage/' . rawurlencode(basename($booking->foto_km_akhir))); ?>"
                                                   target="_blank"
                                                   rel="noopener noreferrer">
                                                    <img
                                                        src="<?= base_url('uploads/vehicle_usage/' . rawurlencode(basename($booking->foto_km_akhir))); ?>"
                                                        alt="Foto kilometer akhir"
                                                        class="img-thumbnail d-block"
                                                        style="width:100%; max-height:220px; object-fit:contain;">
                                                </a>
                                            <?php else: ?>
                                                <p class="text-muted">Foto belum tersedia.</p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group mb-0">
                                            <label class="font-weight-bold">
                                                Foto BBM Akhir
                                            </label>

                                            <?php if (!empty($booking->foto_bbm_akhir)): ?>
                                                <a href="<?= base_url('uploads/vehicle_usage/' . rawurlencode(basename($booking->foto_bbm_akhir))); ?>"
                                                   target="_blank"
                                                   rel="noopener noreferrer">
                                                    <img
                                                        src="<?= base_url('uploads/vehicle_usage/' . rawurlencode(basename($booking->foto_bbm_akhir))); ?>"
                                                        alt="Foto BBM akhir"
                                                        class="img-thumbnail d-block"
                                                        style="width:100%; max-height:220px; object-fit:contain;">
                                                </a>
                                            <?php else: ?>
                                                <p class="text-muted">Foto belum tersedia.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <strong>Status Penggunaan:</strong>

                                <?php if ($booking->status_penggunaan == 'belum_mulai'): ?>
                                    <span class="badge badge-secondary">Belum Mulai</span>
                                <?php elseif ($booking->status_penggunaan == 'digunakan'): ?>
                                    <span class="badge badge-primary">Sedang Digunakan</span>
                                <?php elseif ($booking->status_penggunaan == 'menunggu_pemeriksaan'): ?>
                                    <span class="badge badge-warning">Menunggu Pemeriksaan</span>
                                <?php elseif ($booking->status_penggunaan == 'selesai'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">
                                        <?= htmlspecialchars($booking->status_penggunaan); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <small class="text-muted d-block mt-2">
                                Klik foto untuk melihat ukuran gambar yang lebih besar.
                            </small>

                        <?php else: ?>

                            <div class="alert alert-info mb-0">
                                Belum ada data penggunaan kendaraan.
                            </div>

                        <?php endif; ?>

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
                                <tr>
                                    <th>Kapasitas</th>
                                    <td>
                                        <?php if (!empty($booking->kapasitas_kamar)): ?>

                                            <?= $booking->kapasitas_kamar; ?> Orang

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Kamar belum ditentukan.
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
                                <tr>
                                    <th>Kapasitas</th>
                                    <td>
                                        <?php if (!empty($booking->kapasitas_meeting)): ?>

                                            <?= $booking->kapasitas_meeting; ?> Orang

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Meeting room belum ditentukan.
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
            </div>
        </div>
    </div> 

    <!-- Tombol Approval -->

    <?php if ($booking->status == 'pending'): ?>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button type="button"
                            class="btn btn-danger mb-3 mt-3 mr-2"
                            data-toggle="modal"
                            data-target="#rejectModal">

                        <i class="fas fa-times"></i>
                        Tolak

                    </button>

                    <p class="mb-3 mt-3">
                        <a href="<?= base_url('ga/Bookings/approved/' . $booking->id); ?>" class="btn btn-success"><i class="fas fa-check"></i> Setujui</a>
                    </p>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>


<!-- ========================= -->
<!-- MODAL APPROVE -->
<!-- ========================= -->
<!-- 
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

</div> -->


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