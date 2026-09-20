<?php  

	class Driver_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('drivers.* , employees.name , employees.employee_code');
			$this->db->from('drivers');
            $this->db->join('employees' , 'employees.id = drivers.employee_id');
			$sql = $this->db->get('');

			return $sql->result();
		}

		// CREATE (STORE)
		public function store()
		{
			$employee_id = $this->input->post('employee_id');
			$driver_code = $this->input->post('driver_code');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$created_at = date('Y-m-d H:i:s');

			$data = array(
				'employee_id' => $employee_id, 
				'driver_code' => $driver_code, 
				'notes' => $notes, 
				'status' => $status,
				'created_at' => $created_at
			);

			$result = $this->db->insert('drivers', $data);
			return $result;
		}

		// DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
    		return $this->db->delete('drivers'); 
		}

		// EDIT
		public function edit($id)
		{
			$this->db->select('drivers.* , employees.name , employees.employee_code');
			$this->db->from('drivers');
            $this->db->join('employees' , 'employees.id = drivers.employee_id');
            $this->db->where('drivers.id', $id);
			$sql = $this->db->get('');

			return $sql->row();
		}

		// UPDATE
		public function update()
		{
			$id = $this->input->post('id');

			// Ambil data lama
    		$old_data = $this->edit($id);

			// Data baru
			$employee_id = $this->input->post('employee_id');
			$driver_code = $this->input->post('driver_code');
			$notes = $this->input->post('notes');
			$status = $this->input->post('status');
			$updated_at = date('Y-m-d H:i:s');

			// Cek apakah ada perubahan
			$driver_changed = (
				$old_data->employee_id != $employee_id ||
				$old_data->driver_code != $driver_code ||
				$old_data->notes != $notes ||
				$old_data->status != $status
			);

			// Kalau tidak ada perubahan sama sekali
			if (!$driver_changed)
			{
				return 'no_change';
			}

			$editdata = array(
				'employee_id' => $employee_id, 
				'driver_code' => $driver_code, 
				'status' => $status,
				'updated_at' => $updated_at
			);

            if (!empty($notes)) {
				$editdata['notes'] = $notes ;
			}

			$this->db->where('id', $id);
			return $this->db->update('drivers', $editdata);
		}

		public function get_active()
		{
			$this->db->where('status', 1);
			return $this->db->get('employees')->result();
		}
	}
?>