<div class="container-fluid"> 

        <h1 class="h3 mb-0 text-gray-800">Daftar Booking</h1>
        <p class="mb-4 mt-3">
            <a href="<?php echo base_url();?>ga/Bookings/add" class="btn btn-info"><i class="fas fa-plus"></i> Tambah Booking</a>
        </p>

    <div class="card shadow mb-4">

          <?php if ($this->session->flashdata('success')): ?>

          <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
          </div>

      <?php endif; ?>

      <?php if ($this->session->flashdata('error')): ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>

      <?php endif; ?>

      <?php if ($this->session->flashdata('warning')): ?>
          <div class="alert alert-warning">
              <?= $this->session->flashdata('warning'); ?>
              <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
          </div>
      <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

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
                                    <td><?= $booking->name; ?>
                                        <br>
                                            <small class="text-muted">
                                                <?= html_escape(
                                                    $booking->employee_code ?: '-'
                                                ); ?>
                                            </small></td>
                                    <td>
                                        <?php if ($booking->facility_type == 'vehicle'): ?>
                                                Kendaraan
                                        <?php elseif ($booking->facility_type == 'room'): ?>
                                                Kamar
                                        <?php elseif ($booking->facility_type == 'meeting_room'): ?>
                                                Ruang Meeting
                                        <?php else: ?>
                                                <?= ucfirst($booking->facility_type); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d-m-Y', strtotime($booking->start_date)); ?>
                                        <?php if ($booking->start_date != $booking->end_date): ?>
                                            s/d
                                            <?= date('d-m-Y', strtotime($booking->end_date)); ?>
                                        <?php endif; ?>
                                        <br>
                                        <small class="text-muted">
                                            <?= html_escape(
                                                substr($booking->start_time, 0, 5)
                                            ); ?> WIB 
                                            -
                                            <?= html_escape(
                                                substr($booking->end_time, 0, 5)
                                            ); ?> WIB 
                                        </small>
                                    </td>
                                    <td>
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
                                        <?php else: ?>
                                            <span class="badge badge-secondary">
                                                <?= ucfirst($booking->status); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('ga/Bookings/detail/' . $booking->id); ?>" class="btn btn-outline-info btn-sm">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <?php if ($booking->status == 'pending'): ?>
                                        <a
                                            href="<?= base_url('ga/Bookings/edit/' . $booking->id); ?>"
                                            class="btn btn-outline-success btn-sm"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php endif; ?>
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