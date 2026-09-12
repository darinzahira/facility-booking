<?php  

	class Emp_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('employees.* , departments.id , departments.department_name');
			$this->db->from('employees');
			$this->db->join('departments' , 'departments.id = employees.department_id');
			$sql = $this->db->get('');

			return $sql->result();
		}

		// CREATE (STORE)
		public function store()
		{
			$this->db->trans_start();

			$employee_data = array(
				'employee_code' => $this->input->post('employee_code'),
				'name' => $this->input->post('name'),
				'department_id' => $this->input->post('department_id'),
				'position' => $this->input->post('position'),
				'phone' => $this->input->post('phone'),
				'status' => $this->input->post('status'),
				'created_at' => date('Y-m-d H:i:s')
			);

			$this->db->insert('employees', $employee_data);

			$employee_id = $this->db->insert_id();

			$password = password_hash(
				$this->input->post('password'),
				PASSWORD_DEFAULT
			);

			$user_data = array(
				'employee_id' => $employee_id,
				'username'    => $this->input->post('username'),
				'password'    => $password
			);

			$this->db->insert('users', $user_data);
			$this->db->trans_complete();

			return $this->db->trans_status();
		}

		// DETAIL
		public function get_detail($id)
		{
			$this->db->select('
				employees.*,
				departments.department_name,
				users.id AS user_id,
				users.username
			');

			$this->db->from('employees');

			$this->db->join(
				'departments',
				'departments.id = employees.department_id',
				'left'
			);

			$this->db->join(
				'users',
				'users.employee_id = employees.id',
				'left'
			);

			$this->db->where('employees.id', $id);

			return $this->db->get()->row();
		}

		// DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
    		return $this->db->delete('employees');
		}

		// EDIT
		public function edit($id)
		{
			$this->db->select('*');
			$this->db->from('employees');
			$this->db->where('id', $id);
			$sql = $this->db->get('');

			return $sql->result();
		}

		// UPDATE
		public function update()
		{
			$employee_code = $this->input->post('employee_code');
			$name = $this->input->post('name');
			$department_id = $this->input->post('department_id');
			$position = $this->input->post('position');
			$phone = $this->input->post('phone');
			$status = $this->input->post('status');
			$updated_at = date('Y-m-d H:i:s');

			$editdata = array(
				'employee_code' => $employee_code, 
				'name' => $name, 
				'department_id' => $department_id, 
				'position' => $position, 
				'phone' => $phone, 
				'status' => $status,
			);
			$this->db->where('id', $id);
			return $this->db->update('employees', $editdata);
		}
		
	}
?>