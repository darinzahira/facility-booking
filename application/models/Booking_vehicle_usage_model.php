
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_vehicle_usage_model extends CI_Model
{
    private $table = 'booking_vehicle_usage';

    public function get_by_booking($booking_id)
    {
        return $this->db
            ->where('booking_id', $booking_id)
            ->get($this->table)
            ->row();
    }

    public function create_initial($booking_id)
    {
        $existing = $this->get_by_booking($booking_id);

        if ($existing) {
            return $existing->id;
        }

        $data = array(
            'booking_id'       => $booking_id,
            'status_penggunaan' => 'belum_mulai'
        );

        $this->db->insert($this->table, $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }

        return FALSE;
    }

    public function save_initial($booking_id, $data)
    {
        $existing = $this->get_by_booking($booking_id);

        if (!$existing) {
            return FALSE;
        }

        if (
            $existing->status_penggunaan !== 'belum_mulai' ||
            !empty($existing->foto_km_awal) ||
            !empty($existing->foto_bbm_awal)
        ) {
            return FALSE;
        }

        $data['status_penggunaan'] = 'digunakan';
        $data['tanggal_mulai'] = date('Y-m-d H:i:s');

        return $this->db
            ->where('booking_id', $booking_id)
            ->where('status_penggunaan', 'belum_mulai')
            ->where('foto_km_awal IS NULL', NULL, FALSE)
            ->where('foto_bbm_awal IS NULL', NULL, FALSE)
            ->update($this->table, $data);

    }
}
