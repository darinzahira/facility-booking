<div class="card shadow mb-4">

    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            Ajukan Peminjaman
        </h6>
    </div>

    <div class="card-body">

        <form method="post"
              action="<?= base_url(); ?>employee/Bookings/store">

            <div class="form-group">
                <label>Fasilitas :</label>

                <select
                    name="facility_type"
                    class="form-control"
                >

                    <option value="">
                        -- Pilih Fasilitas --
                    </option>

                    <option value="vehicle"
                        <?= set_select('facility_type', 'vehicle'); ?>>
                        Kendaraan
                    </option>

                    <option value="room"
                        <?= set_select('facility_type', 'room'); ?>>
                        Kamar
                    </option>

                    <option value="meeting_room"
                        <?= set_select('facility_type', 'meeting_room'); ?>>
                        Meeting Room
                    </option>

                </select>

                <?php echo form_error(
                    'facility_type',
                    '<small class="text-danger">',
                    '</small>'
                ); ?>
            </div>


            <div class="form-group">
                <label>Tanggal Mulai :</label>

                <input
                    type="date"
                    name="start_date"
                    class="form-control"
                    value="<?= set_value('start_date'); ?>"
                >

                <?php echo form_error(
                    'start_date',
                    '<small class="text-danger">',
                    '</small>'
                ); ?>
            </div>


            <div class="form-group">
                <label>Tanggal Selesai :</label>

                <input
                    type="date"
                    name="end_date"
                    class="form-control"
                    value="<?= set_value('end_date'); ?>"
                >

                <?php echo form_error(
                    'end_date',
                    '<small class="text-danger">',
                    '</small>'
                ); ?>
            </div>


            <div class="form-group">
                <label>Jam Mulai :</label>

                <input
                    type="time"
                    name="start_time"
                    class="form-control"
                    value="<?= set_value('start_time'); ?>"
                >
            </div>


            <div class="form-group">
                <label>Jam Selesai :</label>

                <input
                    type="time"
                    name="end_time"
                    class="form-control"
                    value="<?= set_value('end_time'); ?>"
                >
            </div>


            <div class="form-group">
                <label>Keperluan :</label>

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


            <button
                type="submit"
                class="btn btn-info"
            >
                Ajukan Peminjaman
            </button>

        </form>

    </div>

</div>