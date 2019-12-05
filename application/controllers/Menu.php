<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct(){

		parent::__construct();
		
		is_logged_in();
		
	}

	public function index(){
		
		$data['title'] = "Menu Management";
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['menu'] = $this->db->get('user_menus')->result_array();

		$this->form_validation->set_rules('menu', 'Menu', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('menu/index', $data);
			$this->load->view('templates/footer');

		} else {

			$success = $this->db->insert('user_menus', ['menu' => $this->input->post('menu')]);
			
			if ($success) {

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation, new menu has been created.</div>');
				redirect('menu');

			} else {
				
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to add new menu !</div>');
				redirect('menu');

			}
			
		}

	}

	public function submenu(){
		
		$data['title'] = "Submenu Management";
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->model('Menu_model', 'menu');
		$data['menu'] = $this->menu->getMenu();
		$data['submenu'] = $this->menu->getSubMenu();

		$this->form_validation->set_rules('menu', 'Menu', 'required|trim');
		$this->form_validation->set_rules('title', 'Title', 'required|trim');
		$this->form_validation->set_rules('url', 'Url', 'required|trim');
		$this->form_validation->set_rules('icon', 'Icon', 'required|trim');
		$this->form_validation->set_rules('is_active', 'Is Active', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('menu/submenu', $data);
			$this->load->view('templates/footer');

		} else {

			$success = $this->db->insert('user_sub_menus', [
							'menu_id' => $this->input->post('menu'),
							'title' => $this->input->post('title'),
							'url' => $this->input->post('url'),
							'icon' => $this->input->post('icon'),
							'is_active' => $this->input->post('is_active'),
						]);
			
			if ($success) {

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation, new submenu has been created.</div>');
				redirect('menu/submenu');

			} else {
				
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to add new submenu !</div>');
				redirect('menu/submenu');

			}
			
		}

	}

	public function deleteMenu($id){

		$hapus = $this->db->delete('user_menus', array('id' => $id));

		if ($hapus) {
			
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been deleted.</div>');
			redirect('menu');

		} else {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to delete menu.</div>');
			redirect('menu');

		}

	}

	public function deleteSubMenu($id){
		
		$hapus = $this->db->delete('user_sub_menus', array('id' => $id));

		if ($hapus) {
			
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu has been deleted.</div>');
			redirect('menu/submenu');

		} else {
			
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to delete submenu.</div>');
			redirect('menu/submenu');

		}

	}

}