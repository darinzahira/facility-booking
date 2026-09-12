<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Departemen</h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url();?>index.php/ga/Departments/add" class="btn btn-info"><i class="fas fa-plus"></i> Tambah Departemen</a>
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
        <h6 class="m-0 font-weight-bold text-info">List Departemen</h6>
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID.</th>
                <th>Nama Departemen</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                $i = 0;
                foreach ($deptlist as $dept): 
                $i++;
                $id = $dept->id;
                $department_name = $dept->department_name;
                $status = $dept->status;
                $created_at = $dept->created_at;
                $updated_at = $dept->updated_at;
              ?>
              <tr>
                <td><?= $i ?>.</td>
                <td><?= $department_name ?></td>
                <td><?php if ($status == 1): ?> 
                        Aktif 
                    <?php else: ?> 
                        Tidak Aktif 
                    <?php endif ?></td>
                <td><?= $created_at ?></td>
                <td><?= $updated_at ?></td>
                <td>
                  <a href="<?php echo base_url(); ?>index.php/ga/Departments/edit/<?= $id ?>" class="btn btn-outline-success btn-sm">
                    <i class="far fa-edit"></i> Edit
                  </a>
                  <a href="<?php echo base_url(); ?>index.php/ga/Departments/delete/<?= $id ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you Sure to Delete?')"><i class="far fa-trash-alt"></i> Remove</a>
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
