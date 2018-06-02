<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Modal extends CI_Model{

	public function __construct() {
		parent::__construct();
		$this->load->database(); 
	}

	public function checkLogin($credential) {

		$sql = $this->db->get_where('tbl_user', $credential);
		$row = $sql->row();
		return $row;
	}

}