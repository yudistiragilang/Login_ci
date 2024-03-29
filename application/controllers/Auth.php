<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('form_validation');

	}

	public function index(){

		if ($this->session->userdata('email')) {
			
			redirect('user');

		}
		

		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			
			$data['title'] = "WPU User Login";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');

		} else {

			$this->_login();
			
		}
		
	}

	private function _login(){

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email, ])->row_array();
		if ($user) {

			if ($user['is_active'] == 1) {
				
				if (password_verify($password, $user['password'])) {
					
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id'],
					];

					$this->session->set_userdata($data);
					if ($user['role_id'] == 1) {
						
						redirect('admin');

					} else {
						
						redirect('user');

					}
				

				} else {

					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password !</div>');
					redirect('auth');

				}
				

			} else {
				
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email has not been activated !</div>');
				redirect('auth');

			}
			
		} else {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered !</div>');
			redirect('auth');

		}
		

	}

	public function registration(){

		if ($this->session->userdata('email')) {
			
			redirect('user');

		}

		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
			'is_unique' => 'This email already registred !',
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[repassword]', [
			'matches' => 'Password dont match !',
			'min_length' => 'Password too short !',
		]);
		$this->form_validation->set_rules('repassword', 'Repeat Password', 'required|trim|matches[password]');

		if ($this->form_validation->run() == FALSE) {

			$data['title'] = "WPU User Registration";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration');
			$this->load->view('templates/auth_footer');
			
		} else {

			$email = $this->input->post('email', TRUE);

			$data = [
				'name' => htmlspecialchars($this->input->post('name', TRUE)),
				'email' => htmlspecialchars($email),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 0,
				'created_date' => time(),
			];

			// siapkan token untuk verifikasi
			$token = base64_encode(random_bytes(32));

			$token_user = [
				'email' => $email,
				'token' => $token,
				'created_date' => time()
			];

			$insert = $this->db->insert('users', $data);
			$this->db->insert('user_tokens', $token_user);

			$this->_sendEmail($token, 'verify');


			if ($insert) {
				
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation, your account has been created. Please activate your account. cek your email !</div>');

			} else {
				
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to register account !</div>');

			}
			
			redirect('auth');

		}

	}

	private function _sendEmail($token, $type){
		
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'gilacoc1122@gmail.com',
			'smtp_pass' => 'Merdeka45',
			'smtp_port' => 465,
			'mailtype' 		=> 'html',
			'charset' 	=> 'utf-8',
			'newline' 	=> "\r\n"
		];

		$this->load->library('email');
		$this->email->initialize($config);


		$this->email->from('gilacoc1122@gmail.com', 'Yudhistira Gilang Adisetyo');
		$this->email->to($this->input->post('email'));

		if ($type == 'verify') {

			$this->email->subject('Account verifications');
			$this->email->message('Click this link to verify your account ! <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>
');

		} else if($type == 'forgot'){

			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password ! <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>
');

		}
		

		if ($this->email->send()) {
			
			return TRUE;

		} else {
			
			echo $this->email->print_debugger();

		}
		

	}

	public function verify(){
		
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();
		if ($user) {
			
			$user_token = $this->db->get_where('user_tokens', ['token' => $token])->row_array();

			if ($user_token) {
				
				if ((time() - $user_token['created_date']) < (60*60*24))  {
					
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$success = $this->db->update('users');

					$this->db->delete('user_tokens', ['email' => $email]);

					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your account has been activated.</div>');
					redirect('auth');

				} else {

					$failed = $this->db->delete('users', ['email' => $email]);
					$failed_token = $this->db->delete('user_tokens', ['email' => $email]);
					
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed, token experied.</div>');
					redirect('auth');

				}
				
			} else {
				
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed, wrong token.</div>');
				redirect('auth');

			}
			
		} else {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed, wrong email.</div>');
			redirect('auth');

		}
		

	}

	public function logout(){
		
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out.</div>');
		redirect('auth');

	}

	public function blocked(){
		
		$data['title'] = "Access Blocked";
		$this->load->view('auth/blocked', $data);

	}

	public function forgotPassword(){
		
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

		if ($this->form_validation->run() == FALSE) {
			
			$data['title'] = "Forgot Password";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgot-password');
			$this->load->view('templates/auth_footer');

		} else {

			$email = $this->input->post('email');
			$user = $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();

			if ($user) {

				$token = base64_encode(random_bytes(32));
				$user_token =[
					'email' => $email,
					'token' => $token,
					'created_date' => time()
				];
				
				$this->db->insert('user_tokens', $user_token);

				$this->_sendEmail($token, 'forgot');

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset password.</div>');
				redirect('auth/forgotPassword');

			}else{

				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email not registered or activated.</div>');
				redirect('auth/forgotPassword');

			}

		}

	
	}

	public function resetPassword(){
		
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {

			$user_token = $this->db->get_where('user_tokens', ['email' => $email, 'token' => $token])->row_array();

			if($user_token){

				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();

			}else{
				
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed, wrong email or token.</div>');
				redirect('auth');
			
			}
		
		}else{

			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed, wrong email.</div>');
			redirect('auth');
		
		}
	}

	public function changePassword(){

		if (!$this->session->userdata('reset_email')) {
			redirect('auth/');
		}

		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[repassword]', [
			'matches' => 'Password dont match !',
			'min_length' => 'Password too short !',
		]);
		$this->form_validation->set_rules('repassword', 'Repeat Password', 'required|trim|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			
			$data['title'] = "Chage Password";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/change-password');
			$this->load->view('templates/auth_footer');

		} else {

			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('users');

			$this->session->unset_userdata('reset_email');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed</div>');
			redirect('auth/');

		}

	}

}
