<?php  

	class Dept_model extends CI_Model
	{
		// Read
		public function deptlist()
		{
			$this->db->select('*');
			$this->db->from('departments');
			$sql = $this->db->get('');

			return $sql->result();
		}

		// CREATE (STORE)
		public function store()
		{
			$dept_name = $this->input->post('dept_name');
			$status = $this->input->post('status');
			$created_at = date('Y-m-d H:i:s');

			$data = array(
				'department_name' => $dept_name, 
				'status' => $status,
				'created_at' => $created_at
			);

			$result = $this->db->insert('departments', $data);
			return $result;
		}

		// DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
    		return $this->db->delete('departments');
		}

		// EDIT
		public function edit($id)
		{
			$this->db->select('*');
			$this->db->from('departments');
			$this->db->where('id', $id);
			$sql = $this->db->get('');

			return $sql->result();
		}
 
		// UPDATE
		public function update()
		{
			$id = $this->input->post('id');
			$dept_name = $this->input->post('dept_name');
			$status = $this->input->post('status');
			$updated_at = date('Y-m-d H:i:s');

			// Ambil data lama
		    $old_data = $this->get_by_id($id);

			// Cek apakah ada perubahan
			if (
				$old_data->department_name == $dept_name &&
				$old_data->status == $status
			) {
				return 'no_change';
			}

			
			$editdata = array(
				'department_name' => $dept_name, 
				'status' => $status,
				'updated_at' => $updated_at
			);
			$this->db->where('id', $id);
			return $this->db->update('departments', $editdata);
		}

		// AMBIL DEPARTEMEN AKTIF
		public function get_active()
		{
			$this->db->where('status', 1);
			return $this->db->get('departments')->result();
		}

		// CEK NAMA DEPARTEMEN
		public function check_department_name($department_name, $id)
		{
			$this->db->where('department_name', $department_name);
			$this->db->where('id !=', $id);

			$query = $this->db->get('departments');

			return $query->num_rows() > 0;
		}

		// AMBIL DEPARTEMEN BY ID
		public function get_by_id($id)
		{
			$this->db->where('id', $id);
			return $this->db->get('departments')->row();
		}


		
	}
?>