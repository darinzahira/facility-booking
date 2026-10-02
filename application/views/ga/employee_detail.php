<?php  
    $id = $detail->id;
    $employee_code = $detail->employee_code;
    $name = $detail->name;
    $department_name = $detail->department_name;
    $position = $detail->position;
    $phone = $detail->phone;
    $status = $detail->status;
    $username = $detail->username;
    $created_at = $detail->created_at;
    $role = $detail->role;
    $company_name = $detail->company_name;
    $sim_type = $detail->sim_type;
    $sim_number = $detail->sim_number;
    $expired_date = $detail->expired_date;
    $sim_photo = $detail->sim_photo;
?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Detail Karyawan </h1>
<p class="mb-4 mt-3">
    <a href="<?php echo base_url(); ?>ga/Employees" class="btn btn-info"><i class="fas fa-angle-left"></i> Back</a>
</p>

<!-- Data Karyawan -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            Data Karyawan
        </h6>
    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                NIK Karyawan
            </div>
            <div class="col-md-9">
                <?= $employee_code ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                Nama Karyawan
            </div>
            <div class="col-md-9">
                <?= $name ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                Perusahaan
            </div>
            <div class="col-md-9">
                <?= $company_name ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                Departemen
            </div>
            <div class="col-md-9">
                <?= $department_name ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                Jabatan
            </div>
            <div class="col-md-9">
                <?= $position ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                No. Telepon
            </div>
            <div class="col-md-9">
                <?= $phone ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                Status
            </div>
            <div class="col-md-9">

                <?php if ($status == 1): ?>

                    <span class="badge badge-success">
                        Aktif
                    </span>

                <?php else: ?>

                    <span class="badge badge-secondary">
                        Tidak Aktif
                    </span>

                <?php endif; ?>

            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                Dibuat
            </div>
            <div class="col-md-9">
                <?= $created_at ?>
            </div>
        </div>

    </div>

</div>


<!-- Data User -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            Data User
        </h6>
    </div>

    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                Username
            </div>
            <div class="col-md-9">
                <?= $username ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 font-weight-bold">
                Role
            </div>
            <div class="col-md-9">

                <?php if ($role == 'admin'): ?>

                    <span class="badge badge-primary">
                        Admin
                    </span>

                <?php else: ?>

                    <span class="badge badge-info">
                        Karyawan
                    </span>

                <?php endif; ?>

            </div>
        </div>

    </div>

</div>


<!-- Data SIM -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            Data SIM
        </h6>
    </div>

    <div class="card-body">

        <?php if ($simdata): ?>

            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">
                    Jenis SIM
                </div>
                <div class="col-md-9">
                    <?= $sim_type ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">
                    Nomor SIM
                </div>
                <div class="col-md-9">
                    <?= $sim_number ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">
                    Masa Berlaku
                </div>
                <div class="col-md-9">
                    <?= $expired_date ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">
                    Foto SIM
                </div>
                <div class="col-md-9">

                    <?php if (!empty($simdata->sim_photo)): ?>

                        <a href="<?= base_url('uploads/sim/' . $simdata->sim_photo); ?>"
                           target="_blank"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-image"></i>
                            Lihat Foto SIM
                        </a>

                    <?php else: ?>

                        <span class="text-muted">
                            Belum ada foto SIM.
                        </span>

                    <?php endif; ?>

                </div>
            </div>

        <?php else: ?>

            <div class="text-center text-muted py-3">
                <i class="fas fa-id-card fa-2x mb-2"></i>

                <p class="mb-0">
                    Data SIM belum tersedia.
                </p>
            </div>

        <?php endif; ?>

    </div>

</div>

<!-- Action -->
<div class="mb-4">

    <a href="<?= base_url('ga/Employees/edit/' . $id); ?>"
       class="btn btn-warning">
        <i class="fas fa-edit"></i>
        Edit Karyawan
    </a>
    
  </div>
  <!-- /.container-fluid -->
