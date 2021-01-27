<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Authadmin {
	var $_logged = false;
	var $user_id;
	var $points;
	var $username;
	var $accounttype;
	
	var $_is_admin = false;

	
	function Authadmin($user_id = null)	{
		$this->checkLogin();
	}

	function getId()
	{
		return $this->user_id;
	}
	
	function isLogged()
	{
		return $this->_logged;
	}
	
	function isAdmin()
	{
		return $this->_is_admin;
	}
	
	function getUsername()
	{
		return $this->username;
	}
	
	function checkLogin()
	{
		if($_SESSION['AUID'] && $_SESSION['APASSWORD'] && $_SESSION['AMID']){
			if($_SESSION['AMID'] == md5($_SESSION['AUID'].$_SESSION['APASSWORD'])){
				$this->_logged		=	true;
				return true;
			}
		}
		$CI =& get_instance();
		$CI->load->library('session');
		if($CI->session->userdata('AUID') && $CI->session->userdata('APASSWORD') && $CI->session->userdata('AMID')) {
			if($CI->session->userdata('AMID') == md5($CI->session->userdata('AUID').$CI->session->userdata('APASSWORD'))) {
				$this->_logged		=	true;
				$this->user_id		=	1;
				$this->username		=	'admin';
				$this->_is_admin	=	true;

			/* Else Check if is admin */
			} else {
				$this->_logged = false;
			}
		} else {
			$this->_logged = false;
		}
	}
	
	function redirectLogin() {
		$CI =& get_instance();
		$url_crypt = base64_encode($CI->uri->uri_string());
		redirect('admin/account/login?rd='.$url_crypt);
	}
	
	function redirectAdminLogin() {
		$CI =& get_instance();
		$url_crypt = base64_encode($CI->uri->uri_string());
		redirect('admin/account/login?rd='.$url_crypt);
	}
	
	function performLogin($username, $password) 
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library('session');
		
		$password 	= 	md5($password);
		$Q	= "SELECT id, username FROM admin WHERE username='$username' AND password='$password'";

		$query = $CI->db->query($Q);
		if($query->num_rows() > 0) {	
			$row = $query->row_array();
			$user_id	=	$row['id'];
			$username	=	$row['username'];
			$time_now	=	time();
						
			$session_data = array(
                   	//'username'  => 'johndoe',
                   	'email'     => 'johndoe@some-site.com',
                   	'SIAS' =>  base64_encode(encrypt_akula(PWD_CRYPT, $user_id).";P:".encrypt_akula(PWD_CRYPT, $username).";"),
				   	'IAD' => $user_id,
				   	'UAD' => encrypt_akula(PWD_CRYPT, $user_id),
					'UAN' => encrypt_akula(PWD_CRYPT, $username)
             );
			$CI->session->set_userdata($session_data);
			$this->checkLogin();
			return LOGIN_SUCCESS;
		} else {
			return ERROR_WRONG_CREDIT;
		}
	}
	
	function performLogout() 
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$CI->session->sess_destroy();
	}
}
?>
