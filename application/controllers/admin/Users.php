<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'application/core/UI_Admin.php';

class Users extends UI_Admin {

	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('up_users');
		$crud->set_subject('User');
		$crud->limit(100);
		$crud->columns('id','displayname','is_admin','is_system');
		$crud->field_type('password', 'password');
		
		$crud->callback_before_insert(array($this, 'encryptPasswordCallback'));
		$crud->callback_before_update(array($this, 'encryptPasswordCallback'));
		$crud->callback_edit_field('password',array($this,'decryptPasswordCallback'));
		//$crud->set_relation('user_id','users','displayname');
		$output = $crud->render();
		
		$this->groceryOutput($output);
	}
	
	public function encryptPasswordCallback($postArray, $primary_key = null) {
		if($postArray['password'] != ''){
			$postArray['password'] = md5($postArray['password']);
		} else {
			unset($postArray['password']);
		}
		return $postArray;
	}
	
	public function decryptPasswordCallback($postArray, $primary_key = null) {
		return '<input type="password" name="password" value="" />';
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */