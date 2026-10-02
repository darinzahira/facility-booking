<?php  

	class Employee_sim_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('*');
			$this->db->where('isdelete', 1);
			$this->db->from('employee_sims');
			$sql = $this->db->get('');

			return $sql->result();
		}

		// CREATE (STORE)
		public function store()
		{
			$employee_id = $this->input->post('employee_id');
			$sim_type = $this->input->post('sim_type');
			$sim_number = $this->input->post('sim_number');
			$expired_date = $this->input->post('expired_date');
			$created_at = date('Y-m-d H:i:s');

			$data = array(
				'employee_id' => $employee_id, 
				'sim_type' => $sim_type, 
				'sim_number' => $sim_number, 
				'expired_date' => $expired_date, 
				'created_at' => $created_at
			);

			$result = $this->db->insert('employee_sims', $data);
			return $result;
		}

		// DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->update('empolyee_sims', [
				'isdelete' => 0
			]);

			return $this->db->affected_rows() > 0;
		}

		// EDIT
		public function edit($id)
		{
			$this->db->select('*');
			$this->db->from('employee_sims');
			$this->db->where('id', $id);
			$sql = $this->db->get('');

			return $sql->result();
		}
 
		// UPDATE
		public function update()
		{
			$id = $this->input->post('id');
			$employee_id = $this->input->post('employee_id');
			$sim_type = $this->input->post('sim_type');
			$sim_number = $this->input->post('sim_number');
			$expired_date = $this->input->post('expired_date');
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
			return $this->db->update('employee_sims', $editdata);
		}

		// AMBIL DEPARTEMEN AKTIF
		public function get_active()
		{
			$this->db->where('status', 1);
			$this->db->where('isdelete', 1);
			return $this->db->get('employee_sims')->result();
		}

		// Ambil data SIM berdasarkan employee
		public function get_by_employee($employee_id)
		{
			return $this->db
				->where('employee_id', $employee_id)
				->where('isdelete', 1)
				->get('employee_sims')
				->row();
		}

		public function update_photo($employee_id, $data)
		{
			$this->db->where('employee_id', $employee_id);

			return $this->db->update(
				'employee_sims',
				array(
					'sim_photo' => $data['sim_photo'],
					'updated_at' => date('Y-m-d H:i:s')
				)
			);
		}

		
	}
?>