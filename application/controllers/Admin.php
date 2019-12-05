<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){

		parent::__construct();

		is_logged_in(); 

	}

	public function index(){
		
		$data['title'] = "Dashboard";
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer');

	}

	public function roles(){

		$data['title'] = "Roles";
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['roles'] = $this->db->get('user_roles')->result_array();
		
		$this->form_validation->set_rules('role', 'Role', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/roles', $data);
			$this->load->view('templates/footer');

		} else {

			$success = $this->db->insert('user_roles', ['role' => $this->input->post('role')]);
			
			if ($success) {

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation, new role has been created.</div>');
				redirect('admin/roles');

			} else {
				
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to add new role !</div>');
				redirect('admin/roles');

			}
			
		}

	}

	public function roleAccess($role_id){

		$data['title'] = "Role Access";
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['roles'] = $this->db->get_where('user_roles', ['id' => $role_id] )->row_array();

		$this->db->where('id !=', 1);
		$data['menus'] = $this->db->get('user_menus')->result_array();
			
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role_access', $data);
		$this->load->view('templates/footer');

	}

	public function changeAccess(){
		
		$role_id = $this->input->post('roleId');
		$menu_id = $this->input->post('menuId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$result = $this->db->get_where('user_access_menus', $data);
		if ($result->num_rows() < 1) {
			
			$this->db->insert('user_access_menus', $data);

		} else {
			
			$this->db->delete('user_access_menus', $data);

		}
		
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access has been changed.</div>');
	}

	public function deleteRole($id){

		$hapus = $this->db->delete('user_roles', array('id' => $id));

		if ($hapus) {
			
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been deleted.</div>');
			redirect('admin/roles');

		} else {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to delete role.</div>');
			redirect('admin/roles');

		}
		

	}

}