<?php
	
	function is_logged_in(){
		
		$ci = get_instance();
		if (!$ci->session->userdata('email')) {
			
			redirect('auth');

		}else{

			$role = $ci->session->userdata('role_id');
			$menu = $ci->uri->segment(1);
			$queryMenu = $ci->db->get_where('user_menus', ['menu' => $menu])->row_array();
			$menu_id = $queryMenu['id'];
			$userAccess = $ci->db->get_where('user_access_menus', [
				'role_id' => $role,
				'menu_id' => $menu_id
			]);

			if ($userAccess->num_rows() < 1) {
				
				redirect('auth/blocked');

			}
		
		}
		
	}

	function check_access($role_id, $menu_id){
		
		$ci = get_instance();
		$userAccess = $ci->db->get_where('user_access_menus', [
				'role_id' => $role_id,
				'menu_id' => $menu_id
			]);

		if ($userAccess->num_rows() > 0) {
				
			return 'checked="checked"';

		}
		
	}

?>