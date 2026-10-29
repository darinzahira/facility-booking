
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

        $this->db
            ->where('booking_id', $booking_id)
            ->where('status_penggunaan', 'belum_mulai')
            ->where('foto_km_awal IS NULL', NULL, FALSE)
            ->where('foto_bbm_awal IS NULL', NULL, FALSE)
            ->update($this->table, $data);

        return $this->db->affected_rows() > 0;
    }

    
    public function save_return($booking_id, $data)
    {
        $existing = $this->get_by_booking($booking_id);

        if (!$existing) {
            return FALSE;
        }

        // Pengembalian hanya bisa dilakukan jika kendaraan sedang digunakan.
        if ($existing->status_penggunaan !== 'digunakan') {
            return FALSE;
        }

        // Data awal harus sudah lengkap.
        if (
            empty($existing->foto_km_awal) ||
            empty($existing->foto_bbm_awal) ||
            $existing->km_awal === NULL
        ) {
            return FALSE;
        }

        // Kilometer akhir tidak boleh lebih kecil dari kilometer awal.
        if (
            !isset($data['km_akhir']) ||
            !is_numeric($data['km_akhir']) ||
            $data['km_akhir'] < $existing->km_awal
        ) {
            return FALSE;
        }

        // Foto akhir wajib tersedia.
        if (
            empty($data['foto_km_akhir']) ||
            empty($data['foto_bbm_akhir'])
        ) {
            return FALSE;
        }

        $data['tanggal_selesai'] = date('Y-m-d H:i:s');
        $data['status_penggunaan'] = 'menunggu_pemeriksaan';

        $this->db
            ->where('booking_id', $booking_id)
            ->where('status_penggunaan', 'digunakan')
            ->update($this->table, $data);

        return $this->db->affected_rows() > 0;
    }

    public function get_pending_inspection()
    {
        return $this->db
            ->select('
                booking_vehicle_usage.*,
                bookings.booking_code,
                bookings.employee_id,
                bookings.vehicle_id,
                bookings.start_date,
                bookings.end_date,
                bookings.start_time,
                bookings.end_time,
                bookings.purpose,
                employees.name AS employee_name,
                employees.employee_code,
                vehicles.vehicle_name,
                vehicles.plate_number
            ')
            ->from('booking_vehicle_usage')
            ->join(
                'bookings',
                'bookings.id = booking_vehicle_usage.booking_id'
            )
            ->join(
                'employees',
                'employees.id = bookings.employee_id',
                'left'
            )
            ->join(
                'vehicles',
                'vehicles.id = bookings.vehicle_id',
                'left'
            )
            ->where(
                'booking_vehicle_usage.status_penggunaan',
                'menunggu_pemeriksaan'
            )
            ->order_by(
                'booking_vehicle_usage.tanggal_selesai',
                'ASC'
            )
            ->get()
            ->result();
    }

    public function complete_inspection($booking_id)
    {
        $usage = $this->get_by_booking($booking_id);

        if (!$usage) {
            return 'Data penggunaan kendaraan tidak ditemukan.';
        }

        if ($usage->status_penggunaan !== 'menunggu_pemeriksaan') {
            return 'Data ini tidak sedang menunggu pemeriksaan.';
        }

        if (
            $usage->km_awal === NULL ||
            $usage->km_akhir === NULL ||
            (int) $usage->km_akhir < (int) $usage->km_awal
        ) {
            return 'Data kilometer awal dan akhir tidak valid.';
        }

        if (
            empty($usage->foto_km_awal) ||
            empty($usage->foto_bbm_awal) ||
            empty($usage->foto_km_akhir) ||
            empty($usage->foto_bbm_akhir)
        ) {
            return 'Empat foto kondisi kendaraan wajib tersedia.';
        }

        $this->db
            ->where('booking_id', $booking_id)
            ->where('status_penggunaan', 'menunggu_pemeriksaan')
            ->update($this->table, array(
                'status_penggunaan' => 'selesai',
                'updated_at' => date('Y-m-d H:i:s')
            ));

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }

        return 'Pemeriksaan belum berhasil diselesaikan.';
    }

}
