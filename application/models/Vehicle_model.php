<?php  

	class Vehicle_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('*');
			$this->db->where('isdelete', 1);
			$this->db->from('vehicles');
			$sql = $this->db->get('');

			return $sql->result();
		}

		// CREATE (STORE)
		public function store($vehicle_photo = null)
		{
			$vehicle_code = $this->input->post('vehicle_code');
			$plate_number = $this->input->post('plate_number');
			$vehicle_name = $this->input->post('vehicle_name');
			$jenis = $this->input->post('jenis');
			$warna = $this->input->post('warna');
			$tahun = $this->input->post('tahun');
			$lokasi = $this->input->post('lokasi');
			$kapasitas = $this->input->post('kapasitas');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$created_at = date('Y-m-d H:i:s');
			$requires_driver = $this->input->post('requires_driver');

			$data = array(
				'vehicle_code' => $vehicle_code, 
				'plate_number' => $plate_number, 
				'vehicle_name' => $vehicle_name, 
				'jenis' => $jenis, 
				'warna' => $warna, 
				'tahun' => $tahun, 
				'lokasi' => $lokasi, 
				'kapasitas' => $kapasitas, 
				'notes' => $notes, 
				'status' => $status,
				'requires_driver'=> $requires_driver,
				'vehicle_photo'=> $vehicle_photo,
				'created_at' => $created_at
			);

			$result = $this->db->insert('vehicles', $data);
			return $result;
		} 

		// DETAIL
		public function get_detail($id)
		{
			$this->db->select('vehicles.*');
			$this->db->from('vehicles');
			$this->db->where('vehicles.id', $id);
			return $this->db->get()->row();
		}

		// DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->update('vehicles', [
				'isdelete' => 0
			]);

			return $this->db->affected_rows() > 0;
		}

		// EDIT
		public function edit($id)
		{
			$this->db->select('*');
			$this->db->from('vehicles');
			$this->db->where('id', $id);
			$sql = $this->db->get('');

			return $sql->row();
		}

		// UPDATE
		public function update($vehicle_photo = null)
		{
			$id = $this->input->post('id');

			// Ambil data lama
			$old_data = $this->edit($id);

			$vehicle_code = $this->input->post('vehicle_code');
			$plate_number = $this->input->post('plate_number');
			$vehicle_name = $this->input->post('vehicle_name');
			$jenis = $this->input->post('jenis');
			$warna = $this->input->post('warna');
			$tahun = $this->input->post('tahun');
			$lokasi = $this->input->post('lokasi');
			$kapasitas = $this->input->post('kapasitas');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$requires_driver = $this->input->post('requires_driver');
			$updated_at = date('Y-m-d H:i:s');

			// Cek apakah ada perubahan data
			$vehicle_changed = (
				$old_data->vehicle_code != $vehicle_code ||
				$old_data->plate_number != $plate_number ||
				$old_data->vehicle_name != $vehicle_name ||
				$old_data->jenis != $jenis ||
				$old_data->tahun != $tahun ||
				$old_data->warna != $warna ||
				$old_data->kapasitas != $kapasitas ||
				$old_data->lokasi != $lokasi ||
				$old_data->notes != $notes ||
				$old_data->status != $status ||
				$old_data->requires_driver != $requires_driver 	
			);

			if ($vehicle_photo !== null) {
				$vehicle_changed = true;
			}

			// Kalau tidak ada perubahan sama sekali
			if (!$vehicle_changed)
			{
				return 'no_change';
			}

			$editdata = array(
				'vehicle_code' => $vehicle_code, 
				'plate_number' => $plate_number, 
				'vehicle_name' => $vehicle_name,
				'jenis' => $jenis, 
				'warna' => $warna, 
				'tahun' => $tahun, 
				'lokasi' => $lokasi, 
				'kapasitas' => $kapasitas,
				'status' => $status,
				'requires_driver' => $requires_driver,
				'updated_at' => $updated_at
			);

			if ($vehicle_photo !== null) {
				$editdata['vehicle_photo'] = $vehicle_photo;
			}

			if (!empty($notes)) {
				$editdata['notes'] = $notes ;
			}

			$this->db->where('id', $id);
			return $this->db->update('vehicles', $editdata);
		}

		public function check_vehicle_code($vehicle_code, $id)
		{
			$this->db->where('vehicle_code', $vehicle_code); 
			$this->db->where('id !=', $id);
			$this->db->where('isdelete', 1);

			$query = $this->db->get('vehicles');

			return $query->num_rows() > 0;
		}

		public function check_plate_number($plate_number, $id)
		{
			$this->db->where('plate_number', $plate_number);
			$this->db->where('id !=', $id);
			$this->db->where('isdelete', 1);

			$query = $this->db->get('vehicles');

			return $query->num_rows() > 0;
		}

		public function get_active()
		{
			$this->db->where('status', 'Aktif');
			$this->db->where('isdelete', 1);
			return $this->db->get('vehicles')->result();
		}
	}
?>