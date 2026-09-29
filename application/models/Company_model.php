<?php  

	class Company_model extends CI_Model
	{
		// Read
		public function list()
		{
			$this->db->select('*');
			$this->db->where('isdelete', 1);
			$this->db->from('company');
			$sql = $this->db->get('');

			return $sql->result();
		}

		// CREATE (STORE)
		public function store()
		{
			$company_name = $this->input->post('company_name');
			$company_code = $this->input->post('company_code');
			$status = $this->input->post('status');
			$created_at = date('Y-m-d H:i:s');

			$data = array(
				'company_code' => $company_code, 
				'company_name' => $company_name, 
				'status' => $status,
				'created_at' => $created_at
			);

			$result = $this->db->insert('company', $data);
			return $result;
		}

		// DELETE
		public function delete($id)
		{
			$this->db->where('id', $id);
			$this->db->update('company', [
				'isdelete' => 0
			]);

			return $this->db->affected_rows() > 0;
		}

		// EDIT
		public function edit($id)
		{
			$this->db->select('*');
			$this->db->from('company');
			$this->db->where('id', $id);
			$sql = $this->db->get('');

			return $sql->result();
		}
 
		// UPDATE
		public function update()
		{
			$id = $this->input->post('id');
			$company_code = $this->input->post('company_code');
			$company_name = $this->input->post('company_name');
			$status = $this->input->post('status');
			$updated_at = date('Y-m-d H:i:s');

			// Ambil data lama
		    $old_data = $this->get_by_id($id);

			// Cek apakah ada perubahan
			if (
				$old_data->company_code == $company_code &&
				$old_data->company_name == $company_name &&
				$old_data->status == $status
			) {
				return 'no_change';
			}

			
			$editdata = array(
				'company_code' => $company_code, 
				'company_name' => $company_name, 
				'status' => $status,
				'updated_at' => $updated_at
			);
			$this->db->where('id', $id);
			return $this->db->update('company', $editdata);
		}

		// AMBIL DEPARTEMEN AKTIF
		public function get_active()
		{
			$this->db->where('status', 1);
			$this->db->where('isdelete', 1);
			return $this->db->get('company')->result();
		}

		// CEK NAMA DEPARTEMEN
		public function check_company_code($company_code, $id)
		{
			$this->db->where('company_code', $company_code);
			$this->db->where('id !=', $id);
			$this->db->where('isdelete', 1);

			$query = $this->db->get('company');

			return $query->num_rows() > 0;
		}

		// CEK NAMA DEPARTEMEN
		public function check_company_name($company_name, $id)
		{
			$this->db->where('company_name', $company_name);
			$this->db->where('id !=', $id);
			$this->db->where('isdelete', 1);

			$query = $this->db->get('company');

			return $query->num_rows() > 0;
		}

		// AMBIL DEPARTEMEN BY ID
		public function get_by_id($id)
		{
			$this->db->where('id', $id);
			$this->db->where('isdelete', 1);
			return $this->db->get('company')->row();
		}


		
	}
?>