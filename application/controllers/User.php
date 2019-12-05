<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){

		parent::__construct();
		
		is_logged_in();
		
	}

	public function index(){
		
		$data['title'] = "My Profile";
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/index', $data);
		$this->load->view('templates/footer');

	}

	public function edit(){
		
		$data['title'] = "Edit Profile";
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');

		} else {
			
			// upload dan update
			$name = $this->input->post('name');
			$email = $this->input->post('email');

			$upload_image = $_FILES['image'];

			if ($upload_image) {
				
				$config['upload_path'] = './assets/img/profiles/';
				$config['allowed_types'] = 'jpg|png';
				$config['max_size']     = '1024';

				$this->load->library('upload', $config);

				echo"sini ";

				//upload gambar
				if ($this->upload->do_upload('image')){

					// delete old image
					$old_image = $data['user']['image'];

					if ($old_image != 'default.jpg') {
						
						unlink(FCPATH . 'assets/img/profiles/' . $old_image);

					}

					// update database
					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);

                }else{

                	echo $this->upload->display_errors();

                }

			}
			
			$this->db->set('name', $name);
			$this->db->where('email', $email);
			$update = $this->db->update('users');

			if ($update) {
				
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated.</div>');

			} else {
				
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to update profile !</div>');

			}
			redirect('user');

		}
		
	}

	public function changePassword(){
		
		$data['title'] = "Change Password";
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		

		$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|trim|min_length[3]|matches[repeat_password]',[
			'matches' => 'Password dont match !',
			'min_length' => 'Password too short !',
		]);
		$this->form_validation->set_rules('repeat_password', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password]', [
			'matches' => 'Password dont match !',
			'min_length' => 'Password too short !',
		]);

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/changepassword', $data);
			$this->load->view('templates/footer');

		} else {
			
			$current_password = $this->input->post('current_password');
			$new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
			$repeat_password = $this->input->post('repeat_password');

			if (password_verify($current_password, $data['user']['password'])) {

				if ($current_password == $repeat_password) {
					
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password dont be same with current password !</div>');
					redirect('user/changepassword');

				} else {

					$this->db->set('password', $new_password);
					$this->db->where('email', $data['user']['email']);
					$update = $this->db->update('users');

					if ($update) {
						
						$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your password has been updated.</div>');
						redirect('user/changepassword');
						// redirect('auth/logout');

					}else{

						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to update password !</div>');
						redirect('user/changepassword');

					}

				}

			}else{

				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password !</div>');
				redirect('user/changepassword');
			}

		}

	}

}