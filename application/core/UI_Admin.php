<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI_Admin extends UI_Controller {
	
	public function __construct()
	{
		$this->_layout = 'admin/layout.php';
		
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		
		$this->_viewParams['pageTitle'] = '';
		$this->_viewParams['bodyClass'] = '';
		$this->_viewParams['language'] = 'en';
        $this->viewParams['userName'] = $this->session->username;

        $this->load->library('grocery_CRUD');
//		if(!$this->_user || !$this->_user->is_admin){
		if(!$this->_user){
			redirect(site_url('user/login?continue=' . urldecode(current_url())));
		}
		
	}
	
	public function groceryOutput($output = null)
	{
		if($output){

			$this->_viewParams['js_files'] = $output->js_files;
			$this->_viewParams['js_lib_files'] = $output->js_lib_files;
			$this->_viewParams['js_config_files'] = $output->js_config_files;
			$this->_viewParams['css_files'] = $output->css_files;
			$this->_viewParams['output'] = $output->output;
            // $this->_viewParams['offices'] = $this->getOffices();
            // $this->_viewParams['currencyTypes'] = $this->getCurencyTypes();
            $this->_viewParams['userName'] = $this->session->username;
		}
		$this->load->view($this->_layout, $this->_viewParams);	
	}

	public function additionalConfig($crud) {

        // $crud
        //     ->field_type('created_by', 'hidden')
        //     ->field_type('created_date', 'hidden')
        //     ->field_type('updated_by', 'hidden')
        //     ->field_type('updated_date', 'hidden');

        $crud
            ->unset_read()
            ->unset_export()
            ->unset_print();

        $crud
            ->set_lang_string('form_update_changes','Запазване')
            ->set_lang_string('form_save_and_go_back','Запазване и връщане към списъка')
            ->set_lang_string('form_update_and_go_back','Запазване и връщане към списъка')
            ->set_lang_string('form_save','Запазване')
            ->set_lang_string('form_add','Добавяне на запис')
            ->set_lang_string('form_edit','Редактиране на запис')
            ->set_lang_string('list_actions','Опции')
            ->set_lang_string('list_edit','Редактиране')
            ->set_lang_string('list_delete','Изтриване')
            ->set_lang_string('list_add','Добавяне')
            ->set_lang_string('list_search','Търсене')
            ->set_lang_string('list_clear_filtering','Изчистване на търсенето')
            ->set_lang_string('list_page','Страница')
            ->set_lang_string('list_paging_of','от')
            ->set_lang_string('form_cancel','Изход');
    }
}