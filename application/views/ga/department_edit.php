<?php  
  foreach ($editdepartment as $e_dept)
  {
    $id = $e_dept->id;
    $department_name = $e_dept->department_name;
    $status = $e_dept->status;
  } 
?>
<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i>Departemen </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>index.php/ga/Departments" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Edit Departemen</h6>
      </div>
      <div class="card-body">
        <form method="post" action="<?php echo base_url(); ?>index.php/ga/Departments/update" >

          <input type="hidden" name="id" value="<?= $id ?>">
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Nama Departemen : </label>
            <div class="col-sm-10">
              <input type="text" name="dept_name" class="form-control" id="dept_name" placeholder="" required autofocus value="<?= $department_name?>">
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Status Departemen : </label>
            <div class="col-sm-10">
              <select name="status" class="form-control" required autofocus>
                <option value="">-- Pilih Status --</option>
                <option value="1" <?= ($status == 1) ? 'selected' : '' ?>>
                    Aktif
                </option>
                <option value="0" <?= ($status == 0) ? 'selected' : '' ?>>
                    Tidak Aktif
                </option>
            </select>
            <?php echo form_error('status', '<small class="text-danger">', '</small>'); ?>
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
