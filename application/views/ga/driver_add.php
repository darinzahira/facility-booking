<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Driver </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>ga/Drivers" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Tambah Driver</h6>
      </div>
      <div class="card-body col-lg-10 mx-auto">
        <form method="post" action="<?php echo base_url(); ?>ga/Drivers/store" >

          <div class="form-group row">
            <label for="employee_id" class="col-sm-2 col-form-label">Nama Karyawan<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
              <select name="employee_id" class="form-control">
                <option value="">-- Pilih Karyawan --</option>
                <?php foreach ($employees as $employees): ?>

                    <option value="<?= $employees->id ?>" <?php echo set_select('employee_id', $employees->id); ?>>
                        <?= $employees->employee_code ?> . <?= $employees->name ?>
                    </option>

                <?php endforeach; ?>
            </select>
            <?php echo form_error('employee_id', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Kode Driver<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
              <input type="text" name="driver_code" class="form-control" id="driver_code" placeholder="" autofocus value="<?php echo set_value('driver_code');?>">
              <?php echo form_error('driver_code', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Status Driver<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
              <select name="status" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="Aktif" <?php echo set_select('status', 'Aktif'); ?>>Aktif</option>
                <option value="Tidak Aktif" <?php echo set_select('status', 'Tidak Aktif'); ?>>Tidak Aktif</option>
            </select>
            <?php echo form_error('status', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Notes</label>
            <div class="col-sm-10">
              <input type="text" name="notes" class="form-control" id="notes" placeholder="" autofocus value="<?php echo set_value('notes');?>">
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
