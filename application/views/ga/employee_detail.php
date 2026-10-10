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
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800">
            Detail Karyawan
        </h1>
        <p class="mb-0 text-muted">
            Informasi lengkap karyawan
        </p>
    </div>
    <div>
        <a href="<?php echo base_url(); ?>ga/Employees" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali</a>
        <a href="<?= base_url('ga/Employees/edit/' . $id); ?>"
        class="btn btn-warning">
            <i class="fas fa-edit"></i>
            Edit Karyawan
        </a>
    </div>
</div>


<!-- Data Karyawan -->
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Data SIM Karyawan
                </h6>
            </div>
            <div class="card-body text-center">
                <!-- Foto SIM Sementara -->
                <div class="mb-3">
                    <?php if (!empty($sim_photo)): ?>
                        <img
                            src="<?= base_url('uploads/sim/' . rawurlencode($sim_photo)); ?>"
                            alt="Foto Kendaraan"
                            class="img-fluid rounded"
                            style="max-height: 250px; object-fit: contain;"
                        >
                    <?php else: ?>
                        <i class="fas fa-user fa-5x text-gray-400"></i>
                        <p class="text-muted small mt-2">
                            Foto SIM belum tersedia.
                        </p>
                    <?php endif; ?>
                </div>
                <h4 class="font-weight-bold text-gray-800">
                    <?= html_escape($sim_type); ?>
                </h4>
                <h5 class="text-grey">
                    <?= html_escape($sim_number); ?>
                </h5>
                <h5 class="text-grey">
                    <?= html_escape($expired_date); ?>
                </h5>
            </div>
        </div>
    </div>

    <!-- Data Karyawan -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Data Karyawan
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th width="35%">NIK Karyawan</th>
                                <td>
                                    <?= html_escape($employee_code); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Karyawan</th>
                                <td>
                                    <?= html_escape($name); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Perusahaan</th>
                                <td>
                                    <?= html_escape($company_name); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Departemen</th>
                                <td>
                                    <?= html_escape($department_name); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>
                                    <?= html_escape($position); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Nomor Telpon</th>
                                <td>
                                    <?= html_escape($phone); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($status == 1): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-user-tie"></i>
                                            Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-info">
                                            Tidak Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Data User
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th width="35%">Username</th>
                                <td>
                                    <?= html_escape($username); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    <?php if ($role == 'admin'): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-user-tie"></i>
                                            Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-user-tie"></i>
                                            Karyawan
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
  <!-- /.container-fluid -->
