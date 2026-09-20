<?php  

	class Vehicle_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('*');
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

			$data = array(
				'vehicle_code' => $vehicle_code, 
				'plate_number' => $plate_number, 
				'vehicle_name' => $vehicle_name, 
				'notes' => $notes, 
				'status' => $status,
				'created_at' => $created_at
			);

			$result = $this->db->insert('vehicles', $data);
			return $result;
		}

		// DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
    		return $this->db->delete('vehicles');
		}

		// EDIT
		public function edit($id)
		{
			$this->db->select('*');
			$this->db->from('vehicles');
			$this->db->where('id', $id);
			$sql = $this->db->get('');

			return $sql->result();
		}

		// UPDATE
		public function update()
		{
			$id = $this->input->post('id');
			$vehicle_code = $this->input->post('vehicle_code');
			$plate_number = $this->input->post('plate_number');
			$vehicle_name = $this->input->post('vehicle_name');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$updated_at = date('Y-m-d H:i:s');

			// Ambil data lama
			$old_data = $this->edit($id);

			// Cek apakah ada perubahan data
			$vehicle_changed = (
				$old_data->vehicle_code != $vehicle_code ||
				$old_data->plate_number != $plate_number ||
				$old_data->vehicle_name != $vehicle_name ||
				$old_data->notes != $notes ||
				$old_data->status != $status
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

			$query = $this->db->get('vehicles');

			return $query->num_rows() > 0;
		}

		public function check_plate_number($plate_number, $id)
		{
			$this->db->where('plate_number', $plate_number);
			$this->db->where('id !=', $id);

			$query = $this->db->get('vehicles');

			return $query->num_rows() > 0;
		}

		// public function get_active()
		// {
		// 	$this->db->where('status', 1);
		// 	return $this->db->get('departments')->result();
		// } 
	}
?>