<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

	public function getMenu(){
		
		return $this->db->get('user_menus')->result_array();

	}

	public function getSubMenu(){
		
		$this->db->select('menu.menu, sub.title, sub.url, sub.icon, sub.is_active, sub.menu_id, sub.id AS id');
		$this->db->from('user_menus AS menu');
		$this->db->join('user_sub_menus AS sub', 'menu.id=sub.menu_id');
		$this->db->order_by('sub.menu_id', 'ASC');
		return $this->db->get()->result_array();

	}

}