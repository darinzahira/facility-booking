<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Booking </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>ga/Bookings" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Tambah Booking</h6>
      </div>
      <div class="card-body col-lg-10 mx-auto">
        <form method="post" action="<?php echo base_url(); ?>ga/Bookings/store" enctype="multipart/form-data">

        <h5 class="font-weight-bold text-info mb-4">
            Data Peminjam
        </h5> 
        <div class="form-group row">
            <label for="employee_id" class="col-sm-2 col-form-label">Nama Karyawan<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <select name="employee_id" class="form-control">
                <option value="">-- Pilih Karyawan --</option>
                <?php foreach ($employees as $employees): ?>

                    <option value="<?= $employees->id ?>" <?php echo set_select('employee_id', $employees->id); ?>>
                        <?= $employees->name ?>
                    </option>

                <?php endforeach; ?>
            </select>
            <?php echo form_error('employee_id', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>

        <h5 class="font-weight-bold text-info mb-4">
            Data Fasilitas
        </h5> 
        <div class="form-group row">
            <label for="facility_type" class="col-sm-2 col-form-label">Fasilitas<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <select name="facility_type" class="form-control">
                <option value="">-- Pilih Fasilitas --</option>
                <option value="vehicle" <?= set_select('facility_type', 'vehicle'); ?>>
                    Kendaraan
                </option>
                <option value="room" <?= set_select('facility_type', 'room'); ?>>
                    Kamar
                </option>
                <option value="meeting_room" <?= set_select('facility_type', 'meeting_room'); ?>>
                    Ruang Meeting
                </option>
            </select>
            <?php echo form_error('facility_type', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="start_date" class="col-sm-2 col-form-label">Tanggal Mulai<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <input type="date" name="start_date" class="form-control" value="<?= set_value('start_date'); ?>">
            <?php echo form_error('start_date', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="end_date" class="col-sm-2 col-form-label">Tanggal Selesai<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <input type="date" name="end_date" class="form-control" value="<?= set_value('end_date'); ?>">
            <?php echo form_error('end_date', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="start_time" class="col-sm-2 col-form-label">Jam Mulai<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <input type="time" name="start_time" class="form-control" value="<?= set_value('start_time'); ?>">
            <?php echo form_error('start_time', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="end_time" class="col-sm-2 col-form-label">Jam Selesai<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <input type="time" name="end_time" class="form-control" value="<?= set_value('end_time'); ?>">
            <?php echo form_error('end_time', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="end_time" class="col-sm-2 col-form-label">Keperluan<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <textarea
                    name="purpose"
                    class="form-control"
                    rows="4"
                ><?= set_value('purpose'); ?></textarea>

                <?php echo form_error(
                    'purpose',
                    '<small class="text-danger">',
                    '</small>'
                ); ?>
            </div>
        </div>

        <div class="form-group row">
        <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <input type="submit" name="btnsave" value="Save" class="btn btn-info">
        </div>
        </div>

        </form>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->
