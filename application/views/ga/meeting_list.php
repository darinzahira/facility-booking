<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Ruang Meeting</h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url();?>ga/Meeting/add" class="btn btn-info"><i class="fas fa-plus"></i> Tambah Data Ruang Meeting</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <?php if ($this->session->flashdata('success')): ?>

          <div class="alert alert-success">
              <?php echo $this->session->flashdata('success'); ?>
              <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
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

      <?php if ($this->session->flashdata('warning')): ?>
          <div class="alert alert-warning">
              <?= $this->session->flashdata('warning'); ?>
              <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
          </div>
      <?php endif; ?>

      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Ruang Meeting</h6>
      </div>
      <div class="card-body">

        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID.</th>
                <th>Kode Kamar</th>
                <th>Nama Kamar</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Lokasi</th>
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
                $room_code = $list->room_code;
                $room_name = $list->room_name;
                $capacity = $list->capacity;
                $status = $list->status;
                $location = $list->location;
                $created_at = $list->created_at;
                $updated_at = $list->updated_at;
              ?>
              <tr>
                <td><?= $i ?>.</td>
                <td><?= $room_code ?></td>
                <td><?= $room_name ?></td>
                <td><?= $capacity ?></td>
                <td><?php if ($status == 'Tersedia'): ?> 
                        Tersedia 
                    <?php elseif ($status == 'Tidak Tersedia'): ?> 
                        Tidak Tersedia
                    <?php else: ?> 
                        Perbaikan
                    <?php endif ?></td>
                <td><?= $location ?></td>
                <td><?= $created_at ?></td>
                <td><?= $updated_at ?></td>
                <td>
                  <a href="<?php echo base_url(); ?>ga/Meeting/edit/<?= $id ?>" class="btn btn-outline-success btn-sm">
                    <i class="far fa-edit"></i>
                  </a>
                  <a href="" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i class="far fa-trash-alt"></i> </a>
                </td>
              </tr>
              <?php endforeach; ?>
              <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">Hapus Data?</div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-info" href="<?php echo base_url(); ?>ga/Meeting/delete/<?= $id ?>">Hapus</a>
                  </div>
                </div>
              </div>
              </div>
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>
  <!-- /.container-fluid -->
