<?php  

	class Login extends CI_Controller
	{

		public function __construct() 
		{
			parent::__construct();
			$this->load->library('session');
		}

		public function index()
		{
			$this->load->view('login');
		}

		public function login() 
		{
            // 1. Ambil username dan password dari form
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password');
            
            // 2. Cari user berdasarkan username
            $user = $this->User_model->get_by_username($username);

            // 3. Kalau username tidak ditemukan
            if (!$user) {

                $this->session->set_flashdata(
                    'error',
                    'Username atau password salah.'
                );

                redirect('login');
            }

            // 4. Cek password
            if (!password_verify($password, $user->password)) {

                $this->session->set_flashdata(
                    'error',
                    'Username atau password salah.'
                );

                redirect('login');
            }

            // 5. Kalau password benar, buat session
            $userdata = array(
                'user_id'     => $user->id,
                'employee_id' => $user->employee_id,
                'username'    => $user->username,
                'role'        => $user->role,
                'logged_in'   => TRUE
            );
            $this->session->set_userdata($userdata);

            // 6. Update waktu login terakhir
            $this->db
                ->where('id', $user->id)
                ->update(
                    'users',
                    array(
                        'last_login' => date('Y-m-d H:i:s')
                    )
                );

            // 8. Kalau tidak perlu ganti password, arahkan berdasarkan role

            if ($user->role == 'employee') {

                redirect(base_url() . 'index.php/employee/Dashboard');

            } elseif ($user->role == 'ga') {

                redirect(base_url() . 'index.php/ga/Dashboard');

            } elseif ($user->role == 'admin') {

                redirect('admin/dashboard');

            } else {

                // Role tidak dikenali
                $this->session->sess_destroy();

                show_error(
                    'Role user tidak dikenali.',
                    403,
                    'Access Denied'
                );
            }

        }
			
		public function logout() 
		{
			$this->load->library('session');
			$this->session->sess_destroy();
			redirect(base_url().'index.php/Login');
		}
	}
?>