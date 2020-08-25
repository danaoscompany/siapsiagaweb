<?php

class Admin extends CI_Controller {

	public function login() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$expiry = $this->input->post('expiry');
		$admins = $this->db->query("SELECT * FROM `admins` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
		if (sizeof($admins) > 0) {
			$admin = $admins[0];
			echo json_encode(array(
				'response_code' => 1,
				'user_id' => intval($admin['id'])
			));
		} else {
			echo json_encode(array(
				'response_code' => -2
			));
		}
	}

	public function get_users() {
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$users = $this->db->query("SELECT * FROM `users` ORDER BY `email` ASC LIMIT " . $start . "," . $length)->result_array();
		for ($i=0; $i<sizeof($users); $i++) {
		}
		echo json_encode($users);
	}

	public function get_users_by_email() {
		$email = $this->input->post('email');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->result_array();
		for ($i=0; $i<sizeof($users); $i++) {
		}
		echo json_encode($users);
	}
	
	public function add_user() {
		$email = $this->input->post('email');
		if ($this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->num_rows() > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
			return;
		}
		$this->db->insert('users', array(
			'email' => $email
		));
		echo json_encode(array(
			'response_code' => 1
		));
	}
	
	public function update_user() {
		$id = intval($this->input->post('id'));
		$email = $this->input->post('email');
		if ($this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->num_rows() > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
			return;
		}
		$this->db->where('id', $id);
		$this->db->update('users', array(
			'email' => $email
		));
		echo json_encode(array(
			'response_code' => 1
		));
	}
	
	public function delete_user() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('users');
	}

	public function get_admins() {
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$admins = $this->db->query("SELECT * FROM `admins` ORDER BY `email` ASC LIMIT " . $start . "," . $length)->result_array();
		for ($i=0; $i<sizeof($admins); $i++) {
		}
		echo json_encode($admins);
	}
	
	public function add_admin() {
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if ($this->db->query("SELECT * FROM `admins` WHERE `email`='" . $email . "'")->num_rows() > 0) {
			echo json_encode(array(
				'response_code' => -1
			));
			return;
		}
		$this->db->insert('admins', array(
			'name' => $name,
			'email' => $email,
			'password' => $password
		));
		echo json_encode(array(
			'response_code' => 1
		));
	}
	
	public function update_admin() {
		$id = intval($this->input->post('id'));
		$changed = intval($this->input->post('changed'));
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if ($changed == 1) {
			if ($this->db->query("SELECT * FROM `admins` WHERE `email`='" . $email . "'")->num_rows() > 0) {
				echo json_encode(array(
					'response_code' => -1
				));
				return;
			}
		}
		$this->db->where('id', $id);
		$this->db->update('admins', array(
			'name' => $name,
			'email' => $email,
			'password' => $password
		));
		echo json_encode(array(
			'response_code' => 1
		));
	}
	
	public function delete_admin() {
		$id = intval($this->input->post('id'));
		$this->db->where('id', $id);
		$this->db->delete('admins');
	}
}
