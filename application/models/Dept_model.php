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

			$editdata = array(
				'department_name' => $dept_name, 
				'status' => $status,
				'updated_at' => $updated_at
			);
			$this->db->where('id', $id);
			return $this->db->update('departments', $editdata);
		}

		public function get_active()
		{
			$this->db->where('status', 1);
			return $this->db->get('departments')->result();
		}
	}
?>