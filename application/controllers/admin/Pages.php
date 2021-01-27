<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'application/core/UI_Admin.php';

class Pages extends UI_Admin {

	function __construct() {
		parent::__construct();
        $this->load->model('Page_model');
	}
	
	public function index(){
		$parentId = $this->input->get('parentId', 0);
		$this->viewParams['items'] = $this->Page_model->getList();
		$this->viewParams['pageTitle'] = 'Pages';
		$this->viewParams['createUrl'] = 'create';
		$this->viewParams['editUrl'] = 'edit';
		$this->viewParams['lookupUrl'] = 'index';
		$this->layout('admin/pages/list');
	}
	
	public function create(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('item_model');
		$this->viewParams['itemId'] = '';
		$this->viewParams['item'] = false;
		$this->viewParams['isFluid'] = true;
		//$this->viewParams['facilityList'] = $this->item_model->getAvailableFacilities();
		$this->viewParams['itemMedia'] = array();
		
		$this->layout('admin/pages/edit');
	}
	
	public function edit($id = false){
		if(!$id){
			show_404();
		}
		
		$this->load->model('page_model');
		$item = $this->page_model->getItem($id);
		if(!$item) {
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->viewParams['isFluid'] = true;
		$this->viewParams['item'] = $item;
		$this->viewParams['itemId'] = $id;
		
		$this->layout('admin/pages/edit');
	}
	
	public function getimages($id = false){
		if(!$id){
			show_404();
		}
		
		$this->load->model('item_model');
		$item = $this->item_model->getItem($id);
		if(!$item) {
			show_404();
		}

		$this->viewParams['itemId'] = $id;
		$images = $this->item_model->getMedia($id);
		
		$output = array();
		foreach($images as $image){
			$output[] = array(
				'is_cover' => $image->is_cover ? true : false, 
				'is_slider' => $image->is_slider ? true : false, 
				'id' => $image->id, 
				'path' => str_replace('uploads/', 'uploads/thumb/', $image->path), 
			);
		
		}
		$this->viewParams['images'] = $output;
		$this->json();
	}
	
	public function update($id = false){
		$post = $_POST;
		$this->load->model('page_model');
		$id 			= $this->input->post('id', false);
		$backtolist 	= $this->input->post('backtolist', false);
		$publish 		= $this->input->post('publish', false);
		$unpublish 		= $this->input->post('unpublish', false);
		
		if($post){
			if($publish){
				$post['is_published'] = 1;
			} else if($unpublish){
				$post['is_published'] = 0;
			}
			$itemId = $this->page_model->update($post, $id);
		}
		if($this->input->is_ajax_request()){
			$this->json(array(
				'success'=>true,
				'id'=>$itemId
			));
			return true;
		}
		if($backtolist){
			redirect(admin_url('/pages'));
		} else {
			redirect(admin_url('/pages/edit/' . $itemId));
		}
	}

	public function imagechooser() {
        $images = $this->Page_model->getAllImages();
        $this->viewParams['images'] = $images;
//        $this->layout('imagechooser');
        $imgs['images'] = $images;
        $this->load->view('imagechooser', $imgs);
    }

    public function uploadimage() {
        //$data = array();
//        site_url('/admin/pages/uploadimage')

        $number_of_files_uploaded = count($_FILES['file']['name']);
        $config = array(
            'allowed_types' => 'jpg|png|jpeg',
            'max_size'      => 3000,
            'overwrite'     => FALSE,
            'upload_path'   => 'assets/uploads/images/content_builder/'
        );
        $this->load->library('upload', $config);

        for ($i = 0; $i < $number_of_files_uploaded; $i++) {
            $_FILES['f']['name'] = $_FILES['file']['name'][$i];
            $_FILES['f']['type'] = $_FILES['file']['type'][$i];
            $_FILES['f']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
            $_FILES['f']['error'] = $_FILES['file']['error'][$i];
            $_FILES['f']['size'] = $_FILES['file']['size'][$i];
            $config['file_name'] = $_FILES['file']['name'][$i];

            $this->upload->initialize($config);
            if ($this->upload->do_upload('f')) {
                $data['error_code'] = 0;
                $data['msg'] = "uploaded";
                $final_files_data[] = $this->upload->data();
                $this->Page_model->insertContentImage('assets/uploads/images/content_builder/'.$_FILES['f']['name']);
//                $this->Page_model->insertContentImage(site_url('/admin/pages/uploadimage/'.$image));
            } else {
                $data['error_code'] = 1;
                $data['msg'] = "invalid file type";
                $data['status'] = $this->upload->display_errors();
                $data['status']->success = FALSE;
            };
        }

        $this->outputJSON($data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */