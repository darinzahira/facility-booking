<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Karyawan</h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url();?>index.php/ga/Employees/add" class="btn btn-info"><i class="fas fa-plus"></i> Tambah Karyawan</a>
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
        <h6 class="m-0 font-weight-bold text-info">List Karyawan</h6>
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>NIK Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                $i = 0;
                foreach ($list as $list): 
                $i++;
                $id = $list->id;
                $employee_code = $list->employee_code;
                $name = $list->name;
                $status = $list->status;
                $created_at = $list->created_at;
                $updated_at = $list->updated_at;
              ?>
              <tr>
                <td><?= $i ?>.</td>
                <td><?= $employee_code ?></td>
                <td><?= $name ?></td>
                <td><?php if ($status == 1): ?> 
                        Aktif 
                    <?php else: ?> 
                        Tidak Aktif 
                    <?php endif ?></td>
                <td><?= $created_at ?></td>
                <td><?= $updated_at ?></td>
                <td>
                  <a href="<?php echo base_url(); ?>index.php/ga/Employees/detail/<?= $id ?>" class="btn btn-outline-info btn-sm">
                  <i class="far fa-eye"></i>
                  </a>
                  <a href="<?php echo base_url(); ?>index.php/ga/Employees/edit/<?= $id ?>" class="btn btn-outline-success btn-sm">
                  <i class="far fa-edit"></i>
                  </a>
                  <a href="<?php echo base_url(); ?>index.php/ga/Employees/delete/<?= $id ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you Sure to Delete?')"><i class="far fa-trash-alt"></i></a>
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
