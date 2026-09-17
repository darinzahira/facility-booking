<?php  
    $id = $editdrivers->id;
    $employee_id = $editdrivers->employee_id;
    $driver_code = $editdrivers->driver_code;
    $notes = $editdrivers->notes;
    $status = $editdrivers->status;
?>
<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i>Driver </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>index.php/ga/Drivers" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Edit Data Driver</h6>
      </div>
      <div class="card-body">
        <form method="post" action="<?php echo base_url(); ?>index.php/ga/Drivers/update" >

        <input type="hidden" name="id" value="<?= $id ?>"> 
          <div class="form-group row">
            <label for="employee_id" class="col-sm-2 col-form-label">Nama Karyawan : </label>
            <div class="col-sm-10">
              <select name="employee_id" class="form-control" required>
                <option value="">-- Pilih Karyawan --</option>
                <?php foreach ($employees as $employees): ?>

                    <option value="<?= $employees->id ?>" <?= ($employee_id ==$employees->id) ? 'selected' : '' ?>>
                        <?= $employees->name ?> .  <?= $employees->employee_code ?>
                    </option>

                <?php endforeach; ?>
            </select>
            <?php echo form_error('employee_id', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="driver_code" class="col-sm-2 col-form-label">Kode Driver : </label>
            <div class="col-sm-10">
              <input type="text" name="driver_code" class="form-control" id="driver_code" placeholder="" required autofocus value="<?= $driver_code?>">
            </div>
            <?php echo form_error('driver_code', '<small class="text-danger">', '</small>'); ?>
          </div>

          <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status Driver : </label>
            <div class="col-sm-10">
              <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Aktif" <?= ($status == 'Aktif') ? 'selected' : '' ?>>
                    Aktif
                </option>
                <option value="Tidak Aktif" <?= ($status == 'Tidak Aktif') ? 'selected' : '' ?>>
                    Tidak Aktif
                </option>
            </select>
            <?php echo form_error('status', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="notes" class="col-sm-2 col-form-label">Notes : </label>
            <div class="col-sm-10">
              <input type="text" name="notes" class="form-control" id="notes" placeholder="" autofocus value="<?= $notes?>">
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
