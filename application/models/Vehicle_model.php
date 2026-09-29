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
		public function store()
		{
			$vehicle_code = $this->input->post('vehicle_code');
			$plate_number = $this->input->post('plate_number');
			$vehicle_name = $this->input->post('vehicle_name');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$created_at = date('Y-m-d H:i:s');
			$requires_driver = $this->input->post('requires_driver');

			$data = array(
				'vehicle_code' => $vehicle_code, 
				'plate_number' => $plate_number, 
				'vehicle_name' => $vehicle_name, 
				'notes' => $notes, 
				'status' => $status,
				'requires_driver'=> $requires_driver,
				'created_at' => $created_at
			);

			$result = $this->db->insert('vehicles', $data);
			return $result;
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
		public function update()
		{
			$id = $this->input->post('id');

			// Ambil data lama
			$old_data = $this->edit($id);

			$vehicle_code = $this->input->post('vehicle_code');
			$plate_number = $this->input->post('plate_number');
			$vehicle_name = $this->input->post('vehicle_name');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$requires_driver = $this->input->post('requires_driver');
			$updated_at = date('Y-m-d H:i:s');

			// Cek apakah ada perubahan data
			$vehicle_changed = (
				$old_data->vehicle_code != $vehicle_code ||
				$old_data->plate_number != $plate_number ||
				$old_data->vehicle_name != $vehicle_name ||
				$old_data->notes != $notes ||
				$old_data->status != $status ||
				$old_data->requires_driver != $requires_driver 	
			);

			// Kalau tidak ada perubahan sama sekali
			if (!$vehicle_changed)
			{
				return 'no_change';
			}

			$editdata = array(
				'vehicle_code' => $vehicle_code, 
				'plate_number' => $plate_number, 
				'vehicle_name' => $vehicle_name, 
				'status' => $status,
				'requires_driver' => $requires_driver,
				'updated_at' => $updated_at
			);

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