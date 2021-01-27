<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI_Controller extends CI_Controller {
	
	protected $_language = 'en';
	
	protected $_header = 'header';
	protected $_user = null;
	
	protected $_layout = 'layout';
	/*
	 * Available types : html, json
	 */
	protected $_outputType = 'html';
	
	protected $_headerJs = array();
	protected $_headerCss = array();
	
	protected $_footerJs = array();
	
	protected $viewParams = array();
	protected $jsonParams = array();
	protected $headerParams = array();
	
	protected $recentObjects = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('pagination');
		$this->load->library('authorization');
//        $this->load->model('Location_model');
//        $locations = $this->Location_model->getAll();
		
		$this->_user = $this->authorization->getUser();
		 $this->viewParams['user'] = $this->_user;
		
		$this->viewParams['isPopup'] 	= $this->input->is_ajax_request();
		
		$this->viewParams['bodyClass'] 			= false;
		$this->viewParams['pageTitle'] 			= false;
		$this->viewParams['extendedMeta']		= false;
		$this->viewParams['canonical']			= false;
		$this->viewParams['language']			= $this->_language;
		$this->viewParams['pageDescription'] 	= '';
		$this->viewParams['pageKeywords'] 		= '';
		$this->viewParams['og'] 				= false;

//		$this->viewParams['locations'] 	= $locations;

		$this->viewParams['isInfinite'] = $this->input->get_post('infinite', false);
		
		if($this->input->is_ajax_request()){
			$this->_layout = false;
		}
		
		if($this->input->get('doprofiler', false) && $this->_user->is_admin){
//		if($this->input->get('doprofiler', false)){
			$this->output->enable_profiler(TRUE);
		}
		
	}
	
	public function setOutput($output = 'output'){
		$this->_outputType = $output;
	}
	
	public function setLayout($enable = true){
		$this->_layout = $enable;
	}
	
	public function layout($viewId){
		
		if($this->_outputType == 'json'){
			return $this->json();
		}
		
		if($this->_layout === false){
			return $this->load->view($viewId, $this->viewParams);
		} else {
			$this->viewParams['CONTENT'] = $viewId;

			$this->load->view($this->_layout, $this->viewParams);

		}
	}
	
	public function printoutput($output){
		
		if($this->_outputType == 'json'){
			return $this->json();
		}

		$this->viewParams = array_merge($this->viewParams, $output);
		$this->load->view($this->_layout, $output);
	}
	
	/*
	 * Send data as JSON output
	 * @param $data array Json data to serilize
	 */
	public function json($data = false){
		if($data !== false){
			echo json_encode($data);
			exit;
		}
		unset($this->viewParams['user']);
		unset($this->viewParams['recentObjects']);
		//$output = array_merge()
		$output = array(
			'data' => $this->viewParams,
			'error' => array_key_exists('error', $this->viewParams) ? $this->viewParams['error'] : false,
		);
		echo json_encode($output);
		exit;
	}
	
	public function requireSession(){
		if($this->authorization->isLogged()) {
			return true;
		}
		if($msgData = $this->session->flashdata('message')){
			$this->viewParams['message'] = $msgData;
		}
		if($this->_outputType == 'json'){
			$this->viewParams['error'] = array('auth'=>true, 'message'=>'');
			$this->json();
		} else if($this->input->is_ajax_request()){
			$this->load->library('user_agent');
			redirect(site_url('user/login?continue=' . urldecode($this->agent->referrer())));
		} else {
			redirect(site_url('user/login?continue=' . urldecode(current_url())));
		}
	}
	
	public function show_404($viewId){
		return $this->showError(404, $viewId);
	}
	
	public function showError($code, $viewId){
		set_status_header($code);
		if (ob_get_level() > $this->ob_level + 1) {
			ob_end_flush();
		}
		ob_start();
		$this->layout($viewId);
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
		exit;
	}
	
	protected function setHeaderJs($files){
		$this->_headerJs = $files;
	}
	
//	protected function headerData($headerData = array()){
//
//		return array_merge($defaultHeaderData, $headerData);
//	}
	
	protected function loadHeader($headerData = array()){
		
		$defaultHeaderData = array();
		$defaultHeaderData['language'] = $this->_language;
		$defaultHeaderData['logoutUrl'] = $this->fb_connect->fbLogoutURL;
		$defaultHeaderData['user'] = $this->viewParams['user'];
		
		if($msgData = $this->session->flashdata('message')){
			$defaultHeaderData['message'] = $msgData;
			//$defaultHeaderData['externs'] = $this->_headerJs;
		}
		
		$this->load->view('parts/' . $this->_header, array_merge($defaultHeaderData, $headerData));
	}
	
	protected function userMenu(){
		
	}

    public function outputJSON($data){
        header('Content-type: application/json');
        echo json_encode($data);
    }
}