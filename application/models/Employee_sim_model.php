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
		public function store($employee_id, $sim_photo = null)
		{
			$data = array(
				'employee_id' => $employee_id,
				'sim_type'    => $this->input->post('sim_type'),
				'sim_number'  => $this->input->post('sim_number'),
				'expired_date'=> $this->input->post('expired_date'),
				'sim_photo'   => $sim_photo,
				'created_at'  => date('Y-m-d H:i:s'),
				'isdelete'    => 1
			);

			return $this->db->insert('employee_sims', $data);
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
			// $id = $this->input->post('id');
			$employee_id = $this->input->post('employee_id');
			$sim_type = $this->input->post('sim_type');
			$sim_number = $this->input->post('sim_number');
			$expired_date = $this->input->post('expired_date');
			$updated_at = date('Y-m-d H:i:s');

			// Ambil data lama
		    $old_data = $this->get_by_employee($employee_id);

			if (!$old_data)
			{
				$sim_data = array(
					'employee_id' => $employee_id,
					'sim_type' => $sim_type,
					'sim_number' => $sim_number,
					'expired_date' => $expired_date,
					'updated_at' => $updated_at,
					'isdelete' => 1
				);

				return $this->db->insert('employee_sims', $sim_data);
			}

			$sim_changed = (
				$old_data->sim_type != $sim_type ||
				$old_data->sim_number != $sim_number ||
				$old_data->expired_date != $expired_date
			);

			// Cek apakah ada perubahan
			if (!$sim_changed)
			{
				return 'no_change';
			}

			$sim_data = array(
				'sim_type' => $sim_type,
				'sim_number' => $sim_number,
				'expired_date' => $expired_date,
				'updated_at' => $updated_at
			);
			
			$this->db->where('id', $old_data->id);

			return $this->db->update('employee_sims', $sim_data);
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

		public function update_photo($employee_id, $sim_photo)
		{
			$old_data = $this->get_by_employee($employee_id);

			// Kalau data SIM belum ada
			if (!$old_data)
			{
				$data = array(
					'employee_id' => $employee_id,
					'sim_photo' => $sim_photo,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					'isdelete' => 1
				);

				return $this->db->insert('employee_sims', $data);
			}

			// Kalau data SIM sudah ada
			$data = array(
				'sim_photo' => $sim_photo,
				'updated_at' => date('Y-m-d H:i:s')
			);

			$this->db->where('id', $old_data->id);

			return $this->db->update('employee_sims', $data);
		}

		
	}
?>