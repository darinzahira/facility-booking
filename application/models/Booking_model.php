<?php

class Booking_model extends CI_Model
{
    public function store()
    {
        $start_date = $this->input->post('start_date');
        $end_date   = $this->input->post('end_date');
        $start_time = $this->input->post('start_time');
        $end_time   = $this->input->post('end_time');

        // Validasi rentang tanggal
        if ($end_date < $start_date) {
            // $this->session->set_flashdata(
            //     'error',
            //     'Tanggal selesai tidak boleh mendahului tanggal mulai.'
            // );

            // redirect('ga/Bookings/add');
            return 'Tanggal selesai tidak boleh mendahului tanggal mulai.';
        }

        // Validasi jam jika booking berlangsung pada tanggal yang sama
        if (
            $start_date == $end_date &&
            $end_time <= $start_time
        ) {
            // $this->session->set_flashdata(
            //     'error',
            //     'Jam selesai harus setelah jam mulai.'
            // );

            // redirect('ga/Bookings/add');
            return 'Jam selesai harus setelah jam mulai.';
        }

        $employee_id = $this->input->post('employee_id');

        $employee = $this->db->get_where('employees', array(
            'id'       => $employee_id,
            'status'   => 1,
            'isdelete' => 1
        ))->row();

        if (!$employee) {
            return 'Karyawan tidak ditemukan atau tidak aktif.';
        }

        $facility_type = $this->input->post('facility_type');

        $vehicle_id      = NULL;
        $room_id         = NULL;
        $meeting_room_id = NULL;
        $driver_id       = NULL;

        // 4. Validasi fasilitas sesuai jenis booking
        if ($facility_type == 'vehicle') {

            $vehicle_id = $this->input->post('vehicle_id');

            if (empty($vehicle_id)) {
                return 'Silakan pilih kendaraan.';
            }

            $vehicle = $this->db->get_where('vehicles', array(
                'id'       => $vehicle_id,
                'status'   => 'Aktif',
                'isdelete' => 1
            ))->row();

            if (!$vehicle) {
                return 'Kendaraan tidak ditemukan atau tidak aktif.';
            }

            $driver_id = $this->input->post('driver_id');

            // Driver wajib jika kendaraan mensyaratkannya
            if (
                $vehicle->requires_driver == 'Ya' &&
                empty($driver_id)
            ) {
                return 'Kendaraan ini wajib menggunakan driver.';
            }

            // Jika driver dipilih, pastikan driver aktif
            if (!empty($driver_id)) {
                $driver = $this->db->get_where('drivers', array(
                    'id'       => $driver_id,
                    'status'   => 'Aktif',
                    'isdelete' => 1
                ))->row();

                if (!$driver) {
                    return 'Driver tidak ditemukan atau tidak aktif.';
                }
            } else {
                $driver_id = NULL;
            }

        } elseif ($facility_type == 'room') {

            $room_id = $this->input->post('room_id');

            if (empty($room_id)) {
                return 'Silakan pilih ruangan.';
            }

            $room = $this->db->get_where('rooms', array(
                'id'       => $room_id,
                'status'   => 'Tersedia',
                'isdelete' => 1
            ))->row();

            if (!$room) {
                return 'Ruangan tidak ditemukan atau tidak tersedia.';
            }

        } elseif ($facility_type == 'meeting_room') {

            $meeting_room_id = $this->input->post('meeting_room_id');

            if (empty($meeting_room_id)) {
                return 'Silakan pilih meeting room.';
            }

            $meeting_room = $this->db->get_where('meeting_rooms', array(
                'id'       => $meeting_room_id,
                'status'   => 'Tersedia',
                'isdelete' => 1
            ))->row();

            if (!$meeting_room) {
                return 'Meeting room tidak ditemukan atau tidak tersedia.';
            }

        } else {
            return 'Jenis fasilitas tidak valid.';
        }

        // 5. Periksa bentrok fasilitas dan driver
        $facility_id = NULL;

        if ($facility_type == 'vehicle') {
            $facility_id = $vehicle_id;
        } elseif ($facility_type == 'room') {
            $facility_id = $room_id;
        } else {
            $facility_id = $meeting_room_id;
        }

        $availability = $this->check_availability(
            $facility_type,
            $facility_id,
            $driver_id,
            $start_date,
            $end_date,
            $start_time,
            $end_time
        );

        if ($availability !== TRUE) {
            return $availability;
        }

        // 6. Simpan booking GA/Admin sebagai approved
        $data = array(
            'booking_code'     => 'BK-' . date('YmdHis') . '-' . mt_rand(100, 999),
            'employee_id'      => $employee_id,
            'facility_type'    => $facility_type,
            'vehicle_id'       => $vehicle_id,
            'room_id'          => $room_id,
            'meeting_room_id'  => $meeting_room_id,
            'driver_id'        => $driver_id,
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            'start_time'       => $start_time,
            'end_time'         => $end_time,
            'purpose'          => trim($this->input->post('purpose')),
            'status'           => 'approved',
            'notes'            => NULL,
            'rejection_reason' => NULL,
            'approved_by'      => $this->session->userdata('user_id'),
            'approved_at'      => date('Y-m-d H:i:s'),
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('bookings', $data)) {
            return TRUE;
        }

        return 'Booking gagal disimpan ke database.';
    }

    public function get_by_employee($employee_id)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->order_by('created_at', 'DESC');

        return $this->db->get('bookings')->result();
    }

    public function get_detail($id, $employee_id)
    {
        $this->db->select('
            bookings.*,

            employees.name,

            vehicles.vehicle_name,
            vehicles.plate_number,

            rooms.room_name,

            meeting_rooms.room_name AS meeting_room_name,

            driver_employee.name AS driver_name
        ');

        $this->db->from('bookings');

        // Pemohon
        $this->db->join(
            'employees',
            'employees.id = bookings.employee_id',
            'left'
        );

        // Kendaraan
        $this->db->join(
            'vehicles',
            'vehicles.id = bookings.vehicle_id',
            'left'
        );

        // Kamar
        $this->db->join(
            'rooms',
            'rooms.id = bookings.room_id',
            'left'
        );

        // Meeting room
        $this->db->join(
            'meeting_rooms',
            'meeting_rooms.id = bookings.meeting_room_id',
            'left'
        );

        // Driver
        $this->db->join(
            'drivers',
            'drivers.id = bookings.driver_id',
            'left'
        );

        // Ambil nama driver dari employees
        $this->db->join(
            'employees AS driver_employee',
            'driver_employee.id = drivers.employee_id',
            'left'
        );

        // Pastikan booking milik employee yang login
        $this->db->where('bookings.id', $id);
        $this->db->where('bookings.employee_id', $employee_id);

        return $this->db->get()->row();
    }

    public function get_all()
    {
        $this->db->select('
            bookings.*,
            employees.name
        ');

        $this->db->from('bookings');

        $this->db->join(
            'employees',
            'employees.id = bookings.employee_id',
            'left'
        );

        $this->db->order_by('bookings.created_at', 'DESC');

        return $this->db->get()->result();
    }

    public function get_pending()
    {
        $this->db->select('
            bookings.*,
            employees.name
        ');

        $this->db->from('bookings');

        $this->db->join(
            'employees',
            'employees.id = bookings.employee_id',
            'left'
        );

        $this->db->where('bookings.status', 'pending');

        $this->db->order_by('bookings.created_at', 'DESC');

        $query = $this->db->get();

        return $query->result();
    }

    public function update_status($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('bookings', $data);
    }

    public function get_detail_admin($id)
    {
        $this->db->select('
            bookings.*,

            employees.name,

            vehicles.vehicle_name,
            vehicles.plate_number,

            rooms.room_name,

            meeting_rooms.room_name AS meeting_room_name,

            driver_employee.name AS driver_name
        ');

        $this->db->from('bookings');

        // Pemohon
        $this->db->join(
            'employees',
            'employees.id = bookings.employee_id',
            'left'
        );

        // Kendaraan
        $this->db->join(
            'vehicles',
            'vehicles.id = bookings.vehicle_id',
            'left'
        );

        // Ruangan
        $this->db->join(
            'rooms',
            'rooms.id = bookings.room_id',
            'left'
        );

        // Meeting Room
        $this->db->join(
            'meeting_rooms',
            'meeting_rooms.id = bookings.meeting_room_id',
            'left'
        );

        // Driver
        $this->db->join(
            'drivers',
            'drivers.id = bookings.driver_id',
            'left'
        );

        // Nama driver diambil dari employees
        $this->db->join(
            'employees AS driver_employee',
            'driver_employee.id = drivers.employee_id',
            'left'
        );

        $this->db->where('bookings.id', $id);

        return $this->db->get()->row();
    }

    public function check_availability(
        $facility_type,
        $facility_id,
        $driver_id,
        $start_date,
        $end_date,
        $start_time,
        $end_time,
        $exclude_booking_id = NULL
    ) {
        // Gabungkan tanggal dan jam menjadi waktu lengkap
        $start_datetime = $start_date . ' ' . $start_time;
        $end_datetime   = $end_date . ' ' . $end_time;

        // Cari booking approved yang waktunya beririsan
        $this->db->from('bookings');
        $this->db->where('status', 'approved');

        // Kondisi bentrok waktu:
        // jadwal lama dimulai sebelum jadwal baru berakhir,
        // dan jadwal lama berakhir setelah jadwal baru dimulai.
        $this->db->where(
            "CONCAT(start_date, ' ', start_time) < " .
            $this->db->escape($end_datetime),
            NULL,
            FALSE
        );

        $this->db->where(
            "CONCAT(end_date, ' ', end_time) > " .
            $this->db->escape($start_datetime),
            NULL,
            FALSE
        );

        // Abaikan booking yang sedang diedit, jika ada
        if ($exclude_booking_id !== NULL) {
            $this->db->where('id !=', $exclude_booking_id);
        }

        // Periksa fasilitas yang dipilih
        if ($facility_type == 'vehicle') {
            $this->db->where('vehicle_id', $facility_id);
        } elseif ($facility_type == 'room') {
            $this->db->where('room_id', $facility_id);
        } elseif ($facility_type == 'meeting_room') {
            $this->db->where('meeting_room_id', $facility_id);
        } else {
            return 'Jenis fasilitas tidak valid.';
        }

        if ($this->db->count_all_results() > 0) {
            return 'Fasilitas sudah digunakan pada jadwal tersebut.';
        }

        // Periksa bentrok driver jika driver dipilih
        if (!empty($driver_id)) {
            $this->db->from('bookings');
            $this->db->where('status', 'approved');
            $this->db->where('driver_id', $driver_id);

            $this->db->where(
                "CONCAT(start_date, ' ', start_time) < " .
                $this->db->escape($end_datetime),
                NULL,
                FALSE
            );

            $this->db->where(
                "CONCAT(end_date, ' ', end_time) > " .
                $this->db->escape($start_datetime),
                NULL,
                FALSE
            );

            if ($exclude_booking_id !== NULL) {
                $this->db->where('id !=', $exclude_booking_id);
            }

            if ($this->db->count_all_results() > 0) {
                return 'Driver sudah ditugaskan pada jadwal tersebut.';
            }
        }

        return TRUE;
    }


}