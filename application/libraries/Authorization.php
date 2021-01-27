<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Authorization {

	private $_loggedLocaly = false;
	private $_loggedFacebook = false;
	private $_logged = false;
	private $user_id;
	private $points;
	private $username;
	private $email;
	private $accounttype;
	private $siteID;
	private $_instance;
	
	private $_is_admin = false;
	
	private $_sessionFields = array('id','username','first_name', 'last_name', 'is_admin');
//	private $_sessionFields = array('id','username','first_name', 'is_admin', 'fb_post', 'description');

	function __construct() {
		if (!session_id()) {
			//session_start();
		}
		$this->_instance =& get_instance();
		//$this->_instance->load->library('fb_connect');
		$this->checkLogin();
	}
	
	function getId() {
		return $this->user_id;
	}
	
	function getUserId() {
		return $this->user_id;
	}
	
	function isLogged() {
		return $this->_logged;
	}
	
	function isAdmin() {
		return $this->_is_admin;
	}
	
	function getUsername() {
		return $this->username;
	}
	
	function getSiteId() {
		return $this->siteID;
	}
	
	function getEmail()	{
		return $this->email;
	}
	
	public function getUser(){
		if(!$this->isLogged()){
			return false;
		}
		return $_SESSION['userData'];
	}
	
	public function startSession($userData){
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		
		$sessionData = array();
		foreach($this->_sessionFields as $key){
			$sessionData[$key] = $userData->{$key};
		}
		$sessionData['userId'] = $userData->id;
		
		$CI->session->set_userdata($sessionData);
		$_SESSION['gledameLogged'] = true;
		$_SESSION['userData'] = $userData;
	}
	
	public function destroySession(){
		$CI =& get_instance();
		$CI->load->library('session');
		$_SESSION['gledameLogged'] = false;
		unset($_SESSION['userData']);
		$CI->session->sess_destroy();
	}
	
	function checkLogin() {



		
		if(isset($_SESSION['gledameLogged'])){
			$this->_logged = true;
			$this->user_id = $_SESSION['userData']->id;
			return true;
		}
		
		$CI =& get_instance();

		$CI->load->database();
		$CI->load->library('session');
		$userId = $CI->session->userdata('userId');
		
		if($userId){
			$CI->load->model('user_model');
			$userData = $CI->user_model->getUser($userId);
			if($userData){
				$this->startSession($userData);
				$this->user_id = $userData->id;
				$this->_logged = true;
			} else {
				$CI->session->set_userdata('userId', null);
			}
		}
		
	}
	
	function redirectLogin() {
		$CI =& get_instance();
		$url_crypt = base64_encode($CI->uri->uri_string());
		redirect('account/login?rd='.$url_crypt);
	}

	
	function performLogout() 
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$CI->session->sess_destroy();
	}
}
?>
