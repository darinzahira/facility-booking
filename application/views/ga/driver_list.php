<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Driver</h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url();?>index.php/ga/Drivers/add" class="btn btn-info"><i class="fas fa-plus"></i> Tambah Data Driver</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <?php if ($this->session->flashdata('success')): ?>

          <div class="alert alert-success">
              <?php echo $this->session->flashdata('success'); ?>
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
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Driver</h6>
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID.</th>
                <th>NIK Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Kode Driver</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                $i = 0;
                foreach ($list as $driver): 
                $i++;
                $id = $driver->id;
                $employee_code = $driver->employee_code;
                $name = $driver->name;
                $driver_code = $driver->driver_code;
                $status = $driver->status;
                $created_at = $driver->created_at;
                $updated_at = $driver->updated_at;
              ?>
              <tr>
                <td><?= $i ?>.</td>
                <td><?= $employee_code ?></td>
                <td><?= $name ?></td>
                <td><?= $driver_code ?></td>
                <td><?= $status ?></td>
                <td><?= $created_at ?></td>
                <td><?= $updated_at ?></td>
                <td>
                  </a>
                  <a href="<?php echo base_url(); ?>index.php/ga/Drivers/edit/<?= $id ?>" class="btn btn-outline-success btn-sm">
                  <i class="far fa-edit"></i>
                  </a>
                  <a href="<?php echo base_url(); ?>index.php/ga/Drivers/delete/<?= $id ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you Sure to Delete?')"><i class="far fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>
  <!-- /.container-fluid -->
