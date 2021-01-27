<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends UI_Controller{

	public function index(){
		$services = $this->db->get_where('up_services', ['is_active' => 1]);
		$this->viewParams['services'] = $services->result();
		// $this->viewParams['contacts']['email'] = "luchi@care.com";
		$this->viewParams['contacts']['email'] = "luchi@care.com";
		$this->viewParams['contacts']['address'] = "5400 Плевен, ул. Александър Стамболийски №5";
		$this->viewParams['contacts']['phone'] = "0888888888/0777777777";
	    $this->layout('welcome_message');
	}
}
