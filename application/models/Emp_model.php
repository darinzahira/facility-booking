<?php  

	class Emp_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('employees.* , departments.id , departments.department_name, users.id, users.last_login');
			$this->db->from('employees');
			$this->db->join('departments' , 'departments.id = employees.department_id');
			$this->db->join('users' , 'users.employee_id = employees.id');
			$this->db->order_by('employees.id', 'ASC');
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
				'password'    => $password,
				'role'    => $this->input->post('role')
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
				users.username,
				users.role
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
			    $this->db->trans_start();

				// Hapus User berdasarkan employee_id
				$this->db->where('employee_id', $id);
				$this->db->delete('users');

				// Hapus Employee
				$this->db->where('id', $id);
				$this->db->delete('employees');

				$this->db->trans_complete();

				return $this->db->trans_status();
		}

		// EDIT
		public function edit($id)
		{
			$this->db->select('
				employees.*,
				departments.department_name,
				users.id AS user_id,
				users.username,
				users.role
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

		// UPDATE
		public function update()
		{

			$this->db->trans_start();

			$id = $this->input->post('id');

			$employee_data = array(
				'employee_code' => $this->input->post('employee_code'),
				'name' => $this->input->post('name'),
				'department_id' => $this->input->post('department_id'),
				'position' => $this->input->post('position'),
				'phone' => $this->input->post('phone'),
				'status' => $this->input->post('status'),
				'updated_at' => date('Y-m-d H:i:s')
			);

			$this->db->where('id', $id);
			$this->db->update('employees', $employee_data);

			$user_data = array(
				'employee_id' => $id,
				'username'    => $this->input->post('username'),
				'role'    => $this->input->post('role')
			);

			$password = $this->input->post('password');

			if (!empty($password)) {
				$user_data['password'] = password_hash(
					$password,
					PASSWORD_DEFAULT
				);
			}

			$this->db->where('employee_id', $id);
			$this->db->update('users', $user_data);

			$this->db->trans_complete();

			return $this->db->trans_status();
		}

		// GET ROLE
		public function get_role()
		{
			$this->db->select('*');
			$this->db->from('users');
			$sql = $this->db->get('');

			return $sql->result();
		}
		
	}
?>