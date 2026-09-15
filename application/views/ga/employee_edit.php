<?php  
    $id = $editemployee->id;
    $employee_code = $editemployee->employee_code;
    $name = $editemployee->name;
    $position = $editemployee->position;
    $phone = $editemployee->phone;
    $status = $editemployee->status;
    $username = $editemployee->username;
    $created_at = $editemployee->created_at;
    $role = $editemployee->role;
?>
<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i>Karyawan </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>index.php/ga/Employees" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Tambah Karyawan</h6>
      </div>
      <div class="card-body">
        <form method="post" action="<?php echo base_url(); ?>index.php/ga/Employees/update" >

        <input type="hidden" name="id" value="<?= $id ?>">  
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">NIK Karyawan : </label>
            <div class="col-sm-10">
              <input type="text" name="employee_code" class="form-control" id="employee_code" placeholder="" required autofocus value="<?= $employee_code ?>">
              <?php echo form_error('employee_code', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Nama Karyawan : </label>
            <div class="col-sm-10">
              <input type="text" name="name" class="form-control" id="name" placeholder="" required autofocus value="<?= $name ?>">
              <?php echo form_error('name', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Departemen : </label>
            <div class="col-sm-10">
              <select name="department_id" class="form-control" required>
                <?php foreach ($departments as $department): ?>
                    <option
                        value="<?= $department->id ?>"
                        <?= ($editemployee->department_id == $department->id) ? 'selected' : '' ?>
                    >
                        <?= $department->department_name ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php echo form_error('department_id', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>
          
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Jabatan : </label>
            <div class="col-sm-10">
              <input type="text" name="position" class="form-control" id="position" placeholder="" required autofocus value="<?= $position ?>">
              <?php echo form_error('position', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>
          
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">No Telpon : </label>
            <div class="col-sm-10">
              <input type="text" name="phone" class="form-control" id="phone" placeholder="" required autofocus value="<?= $phone ?>">
              <?php echo form_error('phone', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
              <label class="col-sm-2 col-form-label">Username :</label>
              <div class="col-sm-10">
                  <input type="text" name="username" class="form-control" id="username" placeholder="" required autofocus value="<?= $username ?>">
                  <?php echo form_error(
                      'username',
                      '<small class="text-danger">',
                      '</small>'
                  ); ?>
              </div>
          </div>

          <div class="form-group row">
              <label for="password" class="col-sm-2 col-form-label">
                  Password :
              </label>

              <div class="col-sm-10">
                  <input
                      type="password"
                      name="password"
                      class="form-control"
                      placeholder="Kosongkan jika tidak ingin mengubah password"
                  >

                  <?php echo form_error(
                      'password',
                      '<small class="text-danger">',
                      '</small>'
                  ); ?>
              </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Status Karyawan : </label>
            <div class="col-sm-10">
              <select name="status" class="form-control" required>
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
            <label for="name" class="col-sm-2 col-form-label">Role Karyawan : </label>
            <div class="col-sm-10">
              <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" <?= ($role == 'admin') ? 'selected' : '' ?>>
                    Administrator
                </option>
                <option value="employee" <?= ($role == 'employee') ? 'selected' : '' ?>>
                    Employee
                </option>
            </select>
            <?php echo form_error('role', '<small class="text-danger">', '</small>'); ?>
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
