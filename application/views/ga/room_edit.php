<?php  
  foreach ($editroom as $e)
  {
    $id = $e->id;
    $room_code = $e->room_code;
    $room_name = $e->room_name;
    $capacity = $e->capacity;
    $notes = $e->notes;
    $status = $e->status;
  } 
?>
<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Kamar </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>index.php/ga/Rooms" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Edit Data Kamar</h6>
      </div>
      <div class="card-body">
        <form method="post" action="<?php echo base_url(); ?>index.php/ga/Rooms/update" >       

          <input type="hidden" name="id" value="<?= $id ?>">
          <div class="form-group row">
            <label for="room_code" class="col-sm-2 col-form-label">Kode Kamar : </label>
            <div class="col-sm-10">
              <input type="text" name="room_code" class="form-control" id="room_code" placeholder="" required autofocus value="<?= $room_code ?>">
            </div>
            <?php echo form_error('room_code', '<small class="text-danger">', '</small>'); ?>
          </div>

          <div class="form-group row">
            <label for="room_name" class="col-sm-2 col-form-label">Nama Kamar : </label>
            <div class="col-sm-10">
              <input type="text" name="room_name" class="form-control" id="room_name" placeholder="" required autofocus value="<?= $room_name ?>">
            </div>
            <?php echo form_error('room_name', '<small class="text-danger">', '</small>'); ?>
          </div>

          <div class="form-group row">
            <label for="capacity" class="col-sm-2 col-form-label">Kapasitas : </label>
            <div class="col-sm-10">
              <input type="text" name="capacity" class="form-control" id="capacity" placeholder="" required autofocus value="<?= $capacity ?>">
            </div>
            <?php echo form_error('capacity', '<small class="text-danger">', '</small>'); ?>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Status Kamar : </label>
            <div class="col-sm-10">
              <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Tersedia" <?= ($status == 'Tersedia') ? 'selected' : '' ?>>
                    Tersedia
                </option>
                <option value="Terisi" <?= ($status == 'Terisi') ? 'selected' : '' ?>>
                    Terisi
                </option>
                <option value="Perbaikan" <?= ($status == 'Perbaikan') ? 'selected' : '' ?>>
                    Perbaikan
                </option>
            </select>
            <?php echo form_error('status', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Notes : </label>
            <div class="col-sm-10">
              <input type="text" name="notes" class="form-control" id="notes" placeholder="" autofocus value="<?= $notes ?>">
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
