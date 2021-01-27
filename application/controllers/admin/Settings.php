<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'application/core/UI_Admin.php';

class Settings extends UI_Admin {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	private function hideFields($crud, array $fields){
	    foreach ($fields as $field){
            $crud->field_type($field, 'hidden');
        }
    }

	public function _example_output($output = null)
	{
		$this->load->view('admin/settings.php',$output);


	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function offices_management(){
		try{
			$crud = new Grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('up_offices');
            $crud->set_relation('location_id','locations','name');
			$crud->set_subject('Office');
			$crud->required_fields('name');
			$crud->columns('name', 'address', 'phone_number', 'fax_number', 'work_time', 'latitude', 'longitude', 'location_id');

            $this->hideFields($crud, ['created_by', 'created_date', 'updated_by', 'updated_date']);

            $output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function locations_management(){
        $crud = new grocery_CRUD();

        $crud->set_theme('datatables');
        $crud->set_table('up_locations');

        $crud->required_fields('name');
        $crud->columns('name');
        $this->hideFields($crud, ['created_by', 'created_date', 'updated_by', 'updated_date']);

        $output = $crud->render();
        $this->_example_output($output);
	}

	public function users_management(){
        $crud = new grocery_CRUD();

        $crud->set_theme('datatables');
        $crud->set_table('up_users');

        $crud->required_fields('username', 'password','first_name','last_name');
        $crud->columns('id', 'username','first_name','last_name');
        $this->hideFields($crud, ['created_by', 'created_date', 'updated_by', 'updated_date']);

        $crud->field_type('password', 'password');

        $crud->callback_before_insert(array($this, 'encryptPasswordCallback'));
        $crud->callback_before_update(array($this, 'encryptPasswordCallback'));
        $crud->callback_edit_field('password',array($this,'decryptPasswordCallback'));

        $output = $crud->render();
        $this->_example_output($output);
	}

	public function currencies_management(){
        $crud = new grocery_CRUD();

        $crud->set_table('up_currencies');
        $crud->columns('code','name','description', 'img_url', 'type');
        $this->hideFields($crud, ['created_by', 'created_date', 'updated_by', 'updated_date']);
        $crud->set_field_upload('img_url','assets/uploads/files');

        $output = $crud->render();
        $this->_example_output($output);
	}

    public function rates_management(){
        $crud = new grocery_CRUD();

        $crud->set_table('up_rates');
        $crud->columns('currency_id','location_id','office_id', 'buy', 'sell');
        $this->hideFields($crud, ['created_by', 'created_date', 'updated_by', 'updated_date']);

        $crud->set_relation('currency_id','currencies','name');
        $crud->set_relation('location_id','locations','name');
        $crud->set_relation('office_id','offices','name');
        $crud->required_fields('currency_id','location_id','office_id', 'buy', 'sell');

        $output = $crud->render();
        $this->_example_output($output);
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