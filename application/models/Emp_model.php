<?php  

	class Emp_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('employees.*, departments.department_name, users.last_login, company.company_name');
			$this->db->from('employees');
			$this->db->join('departments' , 'departments.id = employees.department_id');
			$this->db->join('users' , 'users.employee_id = employees.id');
			$this->db->join('company' , 'company.id = employees.company_id');
			$this->db->where('employees.isdelete', 1);
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
				'company_id' => $this->input->post('company_id'),
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
				'status'    => 1,
				'role'    => $this->input->post('role')
			);

			$this->db->insert('users', $user_data);
			$this->db->trans_complete();
			return $this->db->trans_status();
		}

		// DETAIL  
		public function get_detail($id)
		{
			$this->db->select('employees.*, departments.department_name, users.id AS user_id, users.username, users.role, company.company_name, employee_sims.sim_type, employee_sims.sim_number, employee_sims.expired_date, employee_sims.sim_photo');
			$this->db->from('employees');
			$this->db->join('departments', 'departments.id = employees.department_id', 'left');
			$this->db->join('company', 'company.id = employees.company_id', 'left');
			$this->db->join('employee_sims', 'employee_sims.employee_id = employees.id', 'left');
			$this->db->join('users','users.employee_id = employees.id','left');
			$this->db->where('employees.id', $id);
			return $this->db->get()->row();
		}

		// DELETE
		public function delete($id)
		{
			    $this->db->trans_start();

				// Hapus User berdasarkan employee_id
				$this->db->where('employee_id', $id);
				$this->db->update('users', [
					'isdelete' => 0
				]);

				// Hapus Driver berdasarkan employee_id
				$this->db->where('employee_id', $id);
				$this->db->update('drivers', [
					'isdelete' => 0
				]);

				// Hapus Employee berdasarkan id
				$this->db->where('id', $id);
				$this->db->update('employees', [
					'isdelete' => 0
				]);

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
				users.role,
				company.company_name
			');

			$this->db->from('employees');

			$this->db->join(
				'departments',
				'departments.id = employees.department_id',
				'left'
			);

			$this->db->join(
				'company',
				'company.id = employees.company_id',
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

			// Ambil data lama
    		$old_data = $this->edit($id);

			// Data baru
			$employee_code = $this->input->post('employee_code');
			$name          = $this->input->post('name');
			$department_id = $this->input->post('department_id');
			$company_id = $this->input->post('company_id');
			$position      = $this->input->post('position');
			$phone         = $this->input->post('phone');
			$status        = $this->input->post('status');

			$username = $this->input->post('username');
			$role     = $this->input->post('role');
			$password = $this->input->post('password');

			$sim_type     = $this->input->post('sim_type');
			$sim_number   = $this->input->post('sim_number');
			$expired_date = $this->input->post('expired_date');

			// Cek apakah ada perubahan
			$employee_changed = (
				$old_data->employee_code != $employee_code ||
				$old_data->name != $name ||
				$old_data->department_id != $department_id ||
				$old_data->company_id != $company_id ||
				$old_data->position != $position ||
				$old_data->phone != $phone ||
				$old_data->status != $status
			);

			$user_changed = (
				$old_data->username != $username ||
				$old_data->role != $role ||
				!empty($password)
			);

			$sim_data = $this->db
				->where('employee_id', $id)
				->where('isdelete', 1)
				->get('employee_sims')
				->row();

			$sim_changed = false;

			if ($sim_data) {

				$sim_changed = (
					$sim_data->sim_type != $sim_type ||
					$sim_data->sim_number != $sim_number ||
					$sim_data->expired_date != $expired_date
				);

			} else {

				// Kalau sebelumnya belum ada SIM
				if (
					!empty($sim_type) ||
					!empty($sim_number) ||
					!empty($expired_date)
				) {
					$sim_changed = true;
				}
			}			

			 // Kalau tidak ada perubahan sama sekali
			if (!$employee_changed && !$user_changed && !$sim_changed)
			{
				$this->db->trans_rollback();
				return 'no_change';
			}

			$employee_data = array(
				'employee_code' => $employee_code,
				'name'          => $name,
				'department_id' => $department_id,
				'company_id' => $company_id,
				'position'      => $position,
				'phone'         => $phone,
				'status'        => $status,
				'updated_at'    => date('Y-m-d H:i:s')
			);

			$this->db->where('id', $id);
			$this->db->update('employees', $employee_data);

			$user_data = array(
				'employee_id' => $id,
				'username'    => $username,
				'role'        => $role
			);

			if (!empty($password)) {
				$user_data['password'] = password_hash(
					$password,
					PASSWORD_DEFAULT
				);
			}

			$this->db->where('employee_id', $id);
			$this->db->update('users', $user_data);

			// SIM
			if ($sim_data) {

				// Update data SIM yang sudah ada
				$sim_update = array(
					'sim_type'     => $sim_type,
					'sim_number'   => $sim_number,
					'expired_date' => $expired_date,
					'updated_at'   => date('Y-m-d H:i:s')
				);

				$this->db->where('employee_id', $id);
				$this->db->where('isdelete', 1);
				$this->db->update('employee_sims', $sim_update);

			} else {

				// Insert data SIM baru
				if (
					!empty($sim_type) ||
					!empty($sim_number) ||
					!empty($expired_date)
				) {

					$sim_insert = array(
						'employee_id'  => $id,
						'sim_type'     => $sim_type,
						'sim_number'   => $sim_number,
						'expired_date' => $expired_date,
						'isdelete'     => 1,
						'created_at'   => date('Y-m-d H:i:s')
					);

					$this->db->insert('employee_sims', $sim_insert);
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				return FALSE;
			}

			return TRUE;
		}

		// GET ROLE
		public function get_role()
		{
			$this->db->select('*');
			$this->db->from('users');
			$sql = $this->db->get('');

			return $sql->result();
		}

		public function check_employee_code($employee_code, $id)
		{
			$this->db->where('employee_code', $employee_code);
			$this->db->where('id !=', $id);
			$this->db->where('isdelete', 1);

			$query = $this->db->get('employees');

			return $query->num_rows() > 0;
		}

		public function check_username($username, $id)
		{
			$this->db->where('username', $username);
			$this->db->where('employee_id !=', $id);
			$this->db->where('isdelete', 1);

			$query = $this->db->get('users');

			return $query->num_rows() > 0;
		}
		
	}
?>