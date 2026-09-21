<?php

class Booking_model extends CI_Model
{
    public function store($data)
    {
        return $this->db->insert('bookings', $data);
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

}