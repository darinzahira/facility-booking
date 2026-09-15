<?php  
    $id = $detail->id;
    $employee_code = $detail->employee_code;
    $name = $detail->name;
    $department_id = $detail->department_id;
    $department_name = $detail->department_name;
    $position = $detail->position;
    $phone = $detail->phone;
    $status = $detail->status;
    $username = $detail->username;
    $created_at = $detail->created_at;
    $role = $detail->role;
?>
<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="far fa-clipboard"></i>
        Detail Data Karyawan
    </h1>
    <p class="mb-4 mt-3">
        <a href="<?php echo base_url(); ?>index.php/ga/Employees" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Detail Info</h6>
      </div>
      <div class="card-body">

        <hr class="divider">

      	<h5 class="text-info font-weight-bold mb-4 pl-lg-5"><?= $name?></h5>
      	<div class="row pl-lg-5">
          <label class="col-4 col-lg-3 font-weight-bold">NIK Karyawan : </label>
          <div class="col-8 col-lg-9">
            <?= $employee_code ?>
          </div>
        </div>

	      <div class="row pl-lg-5">
          <label class="col-4 col-lg-3 font-weight-bold">Departemen       : </label>
          <div class="col-8 col-lg-9">
            <?= $department_name ?>
          </div>
        </div>

	      <div class="row pl-lg-5">
          <label class="col-4 col-lg-3 font-weight-bold">Jabatan        : </label>
          <div class="col-8 col-lg-9">
          	<?= $position ?>
          </div>
        </div>

	      <div class="row pl-lg-5">
          <label class="col-4 col-lg-3 font-weight-bold">No Telpon        : </label>
          <div class="col-8 col-lg-9">
          	<?= $phone ?>
          </div>
        </div>

	      <div class="row pl-lg-5">
          <label class="col-4 col-lg-3 font-weight-bold">Username       : </label>
          <div class="col-8 col-lg-9">
          	<?= $username ?>
          </div>
        </div>

	      <div class="row pl-lg-5">
          <label class="col-4 col-lg-3 font-weight-bold">Role       : </label>
          <div class="col-8 col-lg-9">
          	<?= $role ?>
          </div>
        </div>

	      <div class="row pl-lg-5">
          <label class="col-4 col-lg-3 font-weight-bold">Created At       : </label>
          <div class="col-8 col-lg-9">
            <?= date("d M, Y", strtotime($created_at)) ?>
          </div>
        </div>

        <hr class="divider">

      </div>
    </div>

  </div>
  <!-- /.container-fluid -->
