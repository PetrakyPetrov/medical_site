<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends UI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$this->viewParams['pageTitle'] = 'New page2';
		$this->layout('welcome_message');
	}
	
	public function login()	{
		
		$continueTo = $this->input->get_post('continue', '/');
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		$this->load->model('User_model');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error text-danger">', '</div>');
		
		$viewParams['pageTitle'] = 'Login';
		$viewParams['continueTo'] = $continueTo;
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('user/login', $viewParams);
		} else {
			$username = $this->form_validation->set_value('username', '');
			$password = $this->form_validation->set_value('password', '');
			if($userId = $this->User_model->getUserIdByPass(trim($username), trim($password))){

				$user = $this->User_model->getUser($userId->id);

				$this->load->library('authorization');
				$this->authorization->startSession($user);
				$continueTo = '/admin';
				
				redirect(urldecode($continueTo));
				return true;
			} else {
				$viewParams['errorCode'] = 'Невалиден потребител или парола';
				// $this->layout('user/login');
				$this->load->view('user/login', $viewParams);
			}
		}
	}
	
	public function logout() {
		$this->authorization->destroySession();
		$this->session->sess_destroy();
		$data['logged_out'] = TRUE;
		unset($_SESSION['gledameLogged']);
		unset($_SESSION['userData']);
		$continueTo = $this->input->get_post('continue', '/');
		redirect(urldecode($continueTo));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */