<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-user-friends"></i> Booking </h1>
    <p class="mb-4 mt-3">
      <a href="<?php echo base_url(); ?>ga/Bookings" class="btn btn-info"><i class="fas fa-angle-left"></i> Kembali</a>
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Tambah Booking</h6>
      </div>
      <div class="card-body col-lg-10 mx-auto">
        
        <?php if (!empty($booking_error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= html_escape($booking_error) ?>
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo base_url(); ?>ga/Bookings/store" enctype="multipart/form-data">

        <h5 class="font-weight-bold text-info mb-4">
            Data Peminjam
        </h5> 
        
        <div class="form-group row mt-3">
            <label class="col-sm-2 col-form-label">Nama Karyawan</label>
            <div class="col-sm-10">
                <select name="employee_id" id="employee_id" class="form-control" required>
                    <option value="">-- Pilih Karyawan --</option>
                    <?php foreach ($employees as $employee): ?>
                        <option
                            value="<?= $employee->id ?>"
                            data-code="<?= html_escape($employee->employee_code) ?>"
                            data-position="<?= html_escape($employee->position) ?>"
                            data-company="<?= html_escape($employee->company_name ?? '') ?>"
                            <?= set_select('employee_id', $employee->id); ?>
                        >
                            <?= html_escape($employee->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-group row mt-3">
            <label class="col-sm-2 col-form-label">NIK Karyawan</label>
            <div class="col-sm-10">
                <input type="text" id="employee_code_display"
                    class="form-control" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Jabatan</label>
            <div class="col-sm-10">
                <input type="text" id="position_display"
                    class="form-control" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Perusahaan</label>
            <div class="col-sm-10">
                <input type="text" id="company_display"
                    class="form-control" readonly>
            </div>
        </div>

        <h5 class="font-weight-bold text-info mb-4">
            Data Fasilitas
        </h5> 
                
        <div class="form-group row">
            <label for="facility_type" class="col-sm-2 col-form-label">
                Fasilitas<span class="text-danger"> *</span>
            </label>
            <div class="col-sm-10">
                <select name="facility_type" id="facility_type" class="form-control">
                    <option value="">-- Pilih Fasilitas --</option>
                    <option value="vehicle" <?= set_select('facility_type', 'vehicle'); ?>>
                        Kendaraan
                    </option>
                    <option value="room" <?= set_select('facility_type', 'room'); ?>>
                        Kamar
                    </option>
                    <option value="meeting_room" <?= set_select('facility_type', 'meeting_room'); ?>>
                        Ruang Meeting
                    </option>
                </select>
                <?= form_error('facility_type', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        
        <!-- Pilihan Kendaraan -->
        <div class="form-group row facility-option" id="vehicle_option">
            <label for="vehicle_id" class="col-sm-2 col-form-label">
                Kendaraan<span class="text-danger"> *</span>
            </label>

            <div class="col-sm-10">
                <select name="vehicle_id" id="vehicle_id" class="form-control">
                    <option value="">-- Pilih Kendaraan --</option>

                    <?php foreach ($vehicles as $vehicle): ?>
                        <option
                            value="<?= $vehicle->id ?>"
                            data-requires-driver="<?= $vehicle->requires_driver ?>"
                            <?= set_select('vehicle_id', $vehicle->id); ?>
                        >
                            <?= $vehicle->vehicle_name ?> - <?= $vehicle->plate_number ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?= form_error('vehicle_id', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>

        <!-- Pilihan Driver -->
        <div class="form-group row" id="driver_option" style="display: none;">
            <label for="driver_id" class="col-sm-2 col-form-label">
                Driver<span class="text-danger"> *</span>
            </label>

            <div class="col-sm-10">
                <select name="driver_id" id="driver_id" class="form-control" disabled>
                    <option value="">-- Pilih Driver --</option>

                    <?php foreach ($drivers as $driver): ?>
                        <option
                            value="<?= $driver->id ?>"
                            <?= set_select('driver_id', $driver->id); ?>
                        >
                            <?= $driver->name ?> (<?= $driver->employee_code ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <?= form_error('driver_id', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>

        <!-- Pilihan Kamar -->
        <div class="form-group row facility-option" id="room_option">
            <label for="room_id" class="col-sm-2 col-form-label">
                Kamar<span class="text-danger"> *</span>
            </label>
            <div class="col-sm-10">
                <select name="room_id" id="room_id" class="form-control">
                    <option value="">-- Pilih Kamar --</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room->id ?>"
                            <?= set_select('room_id', $room->id); ?>>
                            <?= $room->room_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('room_id', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>

        <!-- Pilihan Ruang Meeting -->
        <div class="form-group row facility-option" id="meeting_room_option">
            <label for="meeting_room_id" class="col-sm-2 col-form-label">
                Ruang Meeting<span class="text-danger"> *</span>
            </label>
            <div class="col-sm-10">
                <select name="meeting_room_id" id="meeting_room_id" class="form-control">
                    <option value="">-- Pilih Ruang Meeting --</option>
                    <?php foreach ($meeting_rooms as $meeting_room): ?>
                        <option value="<?= $meeting_room->id ?>"
                            <?= set_select('meeting_room_id', $meeting_room->id); ?>>
                            <?= $meeting_room->room_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('meeting_room_id', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="start_date" class="col-sm-2 col-form-label">Tanggal Mulai<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <input type="date" name="start_date" class="form-control" value="<?= set_value('start_date'); ?>">
            <?php echo form_error('start_date', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="end_date" class="col-sm-2 col-form-label">Tanggal Selesai<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <input type="date" name="end_date" class="form-control" value="<?= set_value('end_date'); ?>">
            <?php echo form_error('end_date', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="start_time" class="col-sm-2 col-form-label">Jam Mulai<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <input type="time" name="start_time" class="form-control" value="<?= set_value('start_time'); ?>">
            <?php echo form_error('start_time', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="end_time" class="col-sm-2 col-form-label">Jam Selesai<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <input type="time" name="end_time" class="form-control" value="<?= set_value('end_time'); ?>">
            <?php echo form_error('end_time', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="end_time" class="col-sm-2 col-form-label">Keperluan<span class="text-danger"> *</span></label>
            <div class="col-sm-10">
            <textarea
                    name="purpose"
                    class="form-control"
                    rows="4"
                ><?= set_value('purpose'); ?></textarea>

                <?php echo form_error(
                    'purpose',
                    '<small class="text-danger">',
                    '</small>'
                ); ?>
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
    
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const facilityType = document.getElementById('facility_type');
        const vehicleSelect = document.getElementById('vehicle_id');
        const driverOption = document.getElementById('driver_option');
        const driverSelect = document.getElementById('driver_id');

        const options = {
            vehicle: document.getElementById('vehicle_option'),
            room: document.getElementById('room_option'),
            meeting_room: document.getElementById('meeting_room_option')
        };

        function toggleDriver() {
            const selectedVehicle =
                vehicleSelect.options[vehicleSelect.selectedIndex];

            const isVehicle = facilityType.value === 'vehicle';
            const requiresDriver =
                isVehicle &&
                selectedVehicle &&
                selectedVehicle.value !== '' &&
                selectedVehicle.dataset.requiresDriver === 'Ya';

            // Driver muncul untuk semua jenis kendaraan
            driverOption.style.display = isVehicle ? 'flex' : 'none';
            driverSelect.disabled = !isVehicle;

            // Wajib hanya jika kendaraan mensyaratkan driver
            driverSelect.required = !!requiresDriver;

            if (!isVehicle) {
                driverSelect.value = '';
            }
        }

        function toggleFacility() {
            const selected = facilityType.value;

            Object.keys(options).forEach(function (type) {
                const container = options[type];
                const select = container.querySelector('select');
                const isVisible = type === selected;

                container.style.display = isVisible ? 'flex' : 'none';
                select.disabled = !isVisible;
                select.required = isVisible;

                if (!isVisible) {
                    select.value = '';
                }
            });

            toggleDriver();
        }

        facilityType.addEventListener('change', toggleFacility);
        vehicleSelect.addEventListener('change', toggleDriver);

        toggleFacility();
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const employeeSelect = document.getElementById('employee_id');

        const codeDisplay = document.getElementById('employee_code_display');
        const positionDisplay = document.getElementById('position_display');
        const companyDisplay = document.getElementById('company_display');

        function showEmployeeInfo() {
            const selected = employeeSelect.options[employeeSelect.selectedIndex];

            codeDisplay.value = selected.dataset.code || '';
            positionDisplay.value = selected.dataset.position || '';
            companyDisplay.value = selected.dataset.company || '';
        }

        employeeSelect.addEventListener('change', showEmployeeInfo);

        // Menampilkan kembali data jika form gagal validasi
        showEmployeeInfo();
    });
    </script>

  </div>
  <!-- /.container-fluid -->
