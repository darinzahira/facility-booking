<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Perusahaan </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>ga/Companies" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Tambah Perusahaan</h6>
      </div>
      <div class="card-body col-lg-10 mx-auto">
        <form method="post" action="<?php echo base_url(); ?>ga/Companies/store" >

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Kode Perusahaan<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
              <input type="text" name="company_code" class="form-control" id="company_code" placeholder="" autofocus value="<?php echo set_value('company_code');?>">
              <?php echo form_error('company_code', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Nama Perusahaan<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
              <input type="text" name="company_name" class="form-control" id="company_name" placeholder="" autofocus value="<?php echo set_value('company_name');?>">
              <?php echo form_error('company_name', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Status Perusahaan<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
              <select name="status" class="form-control" >
                <option value="">-- Pilih Status --</option>
                <option value="aktif" <?php echo set_select('status', 'aktif'); ?>>Aktif</option>
                <option value="tidak aktif"<?php echo set_select('status', 'tidak aktif'); ?>>Tidak Aktif</option>
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
