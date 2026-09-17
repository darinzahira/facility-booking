<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Kendaraan </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>index.php/ga/Vehicles" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Tambah Data Kendaraan</h6>
      </div>
      <div class="card-body">
        <form method="post" action="<?php echo base_url(); ?>index.php/ga/Vehicles/store" >       

          <div class="form-group row">
            <label for="vehicle_code" class="col-sm-2 col-form-label">Kode Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="vehicle_code" class="form-control" id="vehicle_code" placeholder="" required autofocus value="<?php echo set_value('vehicle_code');?>">
            </div>
            <?php echo form_error('vehicle_code', '<small class="text-danger">', '</small>'); ?>
          </div>

          <div class="form-group row">
            <label for="plate_number" class="col-sm-2 col-form-label">Plat Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="plate_number" class="form-control" id="plate_number" placeholder="" required autofocus value="<?php echo set_value('plate_number');?>">
            </div>
            <?php echo form_error('plate_number', '<small class="text-danger">', '</small>'); ?>
          </div>

          <div class="form-group row">
            <label for="vehicle_name" class="col-sm-2 col-form-label">Brand Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="vehicle_name" class="form-control" id="vehicle_name" placeholder="" required autofocus value="<?php echo set_value('vehicle_name');?>">
            </div>
            <?php echo form_error('vehicle_name', '<small class="text-danger">', '</small>'); ?>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Status Kendaraan : </label>
            <div class="col-sm-10">
              <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Aktif">Aktif</option>
                <option value="Perbaikan">Perbaikan</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
            <?php echo form_error('status', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Notes : </label>
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
