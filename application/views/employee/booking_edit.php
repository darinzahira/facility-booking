<?php  
  foreach ($editdata as $e)
  {
    $id = $e->id;
    $facility_type = $e->facility_type;
    $start_date = $e->start_date;
    $end_date = $e->end_date;
    $start_time = $e->start_time;
    $end_time = $e->end_time;
    $purpose = $e->purpose;
  } 
?>

<div class="card shadow mb-4">

    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            Ajukan Peminjaman
        </h6>
    </div>

    <div class="card-body">

        <form method="post"
              action="<?= base_url(); ?>employee/Bookings/store">

            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="form-group">
                <label>Fasilitas<span class="text-danger"> *</span></label>
                <select name="facility_type" class="form-control" >
                    <option value=""> -- Pilih Fasilitas -- </option>
                    <option value="vehicle" <?= set_select('facility_type', 'vehicle'); ?>>
                        Kendaraan
                    </option>
                    <option value="room" <?= set_select('facility_type', 'room'); ?>>
                        Kamar
                    </option>
                    <option value="meeting_room" <?= set_select('facility_type', 'meeting_room'); ?>>
                        Meeting Room
                    </option>
                </select>
                <?php echo form_error( 'facility_type', '<small class="text-danger">', '</small>' ); ?>
            </div>


            <div class="form-group">
                <label>Tanggal Mulai<span class="text-danger"> *</span></label>
                <input type="date" name="start_date" class="form-control" value="<?= set_value('start_date', $start_date); ?>">
                <?php echo form_error('start_date','<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label>Tanggal Selesai<span class="text-danger"> *</span></label>
                <input
                    type="date"
                    name="end_date"
                    class="form-control"
                    value="<?= set_value('end_date',$end_date); ?>"
                >

                <?php echo form_error(
                    'end_date',
                    '<small class="text-danger">',
                    '</small>'
                ); ?>
            </div>


            <div class="form-group">
                <label>Jam Mulai<span class="text-danger"> *</span></label>

                <input
                    type="time"
                    name="start_time"
                    class="form-control"
                    value="<?= set_value('start_time',$start_time); ?>"
                >
            </div>


            <div class="form-group">
                <label>Jam Selesai<span class="text-danger"> *</span></label>

                <input
                    type="time"
                    name="end_time"
                    class="form-control"
                    value="<?= set_value('end_time',$end_time); ?>"
                >
            </div>


            <div class="form-group">
                <label>Keperluan<span class="text-danger"> *</span></label> 

                <textarea
                    name="purpose"
                    class="form-control"
                    rows="4"
                ><?= set_value('purpose', $purpose); ?></textarea>

                <?php echo form_error(
                    'purpose',
                    '<small class="text-danger">',
                    '</small>'
                ); ?>
            </div>


            <button
                type="submit"
                class="btn btn-info"
            >
                Simpan
            </button>

            <a
                href="<?= base_url('employee/Bookings'); ?>"
                class="btn btn-secondary"
            >
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

        </form>

    </div>

</div>