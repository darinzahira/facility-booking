<?php  
    $id = $editvehicle->id;
    $vehicle_code = $editvehicle->vehicle_code;
    $vehicle_name = $editvehicle->vehicle_name;
    $plate_number = $editvehicle->plate_number;
    $jenis = $editvehicle->jenis;
    $tahun = $editvehicle->tahun;
    $warna = $editvehicle->warna;
    $lokasi = $editvehicle->lokasi;
    $kapasitas = $editvehicle->kapasitas;
    $notes = $editvehicle->notes;
    $vehicle_photo = $editvehicle->vehicle_photo;
    $status = $editvehicle->status;
    $requires_driver = $editvehicle->requires_driver;
?>
<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Kendaraan </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>ga/Vehicles" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali</a>
    </p>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?> 
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Edit Data Kendaraan</h6>
      </div>
      <div class="card-body col-lg-10 mx-auto">
        <form method="post" action="<?php echo base_url(); ?>ga/Vehicles/update" enctype="multipart/form-data">       

        <input type="hidden" name="id" value="<?= $id ?>">  
        <div class="form-group row">
            <label for="vehicle_code" class="col-sm-2 col-form-label">Kode Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="vehicle_code" class="form-control" id="vehicle_code" placeholder="" autofocus value="<?= set_value('vehicle_code', $vehicle_code) ?>">
            <?php echo form_error('vehicle_code', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="plate_number" class="col-sm-2 col-form-label">Plat Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="plate_number" class="form-control" id="plate_number" placeholder="" autofocus value="<?= set_value('plate_number', $plate_number) ?>">
            <?php echo form_error('plate_number', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="vehicle_name" class="col-sm-2 col-form-label">Brand Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="vehicle_name" class="form-control" id="vehicle_name" placeholder="" autofocus value="<?= set_value('vehicle_name', $vehicle_name) ?>">
            <?php echo form_error('vehicle_name', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
          <label for="vehicle_photo" class="col-sm-2 col-form-label">
              Foto Kendaraan
          </label>

          <div class="col-sm-10">

              <?php if (!empty($vehicle_photo)): ?>

                  <div class="mb-3">
                      <img
                          src="<?= base_url('uploads/vehicles/' . $vehicle_photo) ?>"
                          alt="Foto Kendaraan"
                          style="max-width: 300px; max-height: 200px; object-fit: contain;"
                          class="img-thumbnail">
                  </div>

              <?php else: ?>

                  <p class="text-muted">Belum ada foto kendaraan.</p>

              <?php endif; ?>

              <input type="file"
                    name="vehicle_photo"
                    id="vehicle_photo"
                    class="form-control-file"
                    accept=".jpg,.jpeg,.png">

              <small class="form-text text-muted">
                  Kosongkan jika tidak ingin mengganti foto.
                  Format JPG, JPEG, atau PNG. Maksimal 2 MB.
              </small>

          </div>
      </div>

          <div class="form-group row">
            <label for="jenis" class="col-sm-2 col-form-label">Jenis Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="jenis" class="form-control" id="jenis" placeholder="" autofocus value="<?= set_value('jenis', $jenis) ?>">
            <?php echo form_error('jenis', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="tahun" class="col-sm-2 col-form-label">Tahun Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="tahun" class="form-control" id="tahun" placeholder="" autofocus value="<?= set_value('tahun', $tahun) ?>">
            <?php echo form_error('tahun', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="warna" class="col-sm-2 col-form-label">Warna Kendaraan : </label>
            <div class="col-sm-10">
              <input type="text" name="warna" class="form-control" id="warna" placeholder="" autofocus value="<?= set_value('warna', $warna) ?>">
            <?php echo form_error('warna', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="kapasitas" class="col-sm-2 col-form-label">Kapasitas : </label>
            <div class="col-sm-10">
              <input type="text" name="kapasitas" class="form-control" id="kapasitas" placeholder="" autofocus value="<?= set_value('kapasitas', $kapasitas) ?>">
            <?php echo form_error('kapasitas', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="lokasi" class="col-sm-2 col-form-label">Lokasi : </label>
            <div class="col-sm-10">
              <input type="text" name="lokasi" class="form-control" id="lokasi" placeholder="" autofocus value="<?= set_value('lokasi', $lokasi) ?>">
            <?php echo form_error('lokasi', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Status Kendaraan : </label>
            <div class="col-sm-10">
              <select name="status" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="Aktif" <?= set_select('status', 'Aktif', $status == 'Aktif') ?>>
                    Aktif
                </option>
                <option value="Perbaikan" <?= set_select('status', 'Perbaikan', $status == 'Perbaikan') ?>>
                    Perbaikan
                </option>
                <option value="Tidak Aktif" <?= set_select('status', 'Tidak Aktif', $status == 'Tidak Aktif') ?>>
                    Tidak Aktif
                </option>
            </select>
            <?php echo form_error('status', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Driver :</label>
              <div class="col-sm-10">
              <select name="requires_driver" class="form-control">
                  <option value="Tidak" <?= set_select('requires_driver', 'Tidak', $requires_driver == 'Tidak') ?>>
                      Tidak Wajib
                  </option>
                  <option value="Ya" <?= set_select('requires_driver', 'Ya', $requires_driver == 'Ya') ?>>
                      Wajib
                  </option>
              </select>            
              <?php echo form_error('requires_driver', '<small class="text-danger">', '</small>'); ?>
              </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Notes : </label>
            <div class="col-sm-10">
              <input type="text" name="notes" class="form-control" id="notes" placeholder="" autofocus value="<?= set_value('notes', $notes) ?>">
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
