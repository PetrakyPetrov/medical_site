<?php
class Request_Model extends CI_Model {
	
	public $_request = null;
	
	public function __construct() {
		parent::__construct();
		$this->init();
    }
	
	public function getRequest(){
		return $this->_request;
	}
	
	public function init(){
		
		$this->load->helper('cookie');
		$this->_request = new Request_Model_Item($this->input);
		
	}
}

class Request_Model_Item {
	
	private $sortings = array('Newest', 'Newest', 'Price: Low to High', 'Price: High to Low', 'Rating');
	private $filters = array('All Prices', 'Only Free', '$0 - $2', '$2 - $5', '$5 and higher');
	private $aditional_order = array();
	public $filter = array();
	public $limit = 0;
	public $sort = 0;
	
	private $sorting_order = null;
	
	
	private $_sortings = array(0=>'a.release_date DESC', 
			1=>'a.release_date DESC', 
			2=>'a.new_price ASC', 
			3=>'a.new_price DESC', 
			4=>'a.rating_countall DESC, a.rating DESC');
	
	public function __construct($parent_caller){
		$this->aditional_order[] = '';
		$this->sort = ($parent_caller->get('sort')) ? $parent_caller->get('sort') : 0;
		
		//$this->_priceDropFilter = ($parent_caller->get('pdf') || $parent_caller->get('pdf') == 0) ? $parent_caller->get('pdf') : (get_cookie('pdf') ? get_cookie('pdf') : 0);
		
		$this->filter = ($parent_caller->get('filter')) ? $parent_caller->get('filter') : 0;
		$this->limit = intval($parent_caller->get('page'));
		
		$this->view_type = (get_cookie('viewmode')) ? get_cookie('viewmode') : 'brief';
		$this->view_type = ($this->view_type != 'brief' && $this->view_type != 'expanded') ? 'brief' : $this->view_type;
		
		//$this->current_page;
		
		$this->sort_text = (@$this->sortings[$this->sort]) ? $this->sortings[$this->sort] : $this->sortings[0];
		$this->filter_text = (@$this->filters[$this->filter]) ? $this->filters[$this->filter] : $filters[0];
		
		$this->queryText = ($parent_caller->get('q')) ? $parent_caller->get('q') : null;
	}
	
	public function disablePriceDropFilter(){
		$this->_priceDropFilter = 10;
	}
	
	public function resetPriceDropFilter(){
		$this->_priceDropFilter = 0;
	}
	
	public function _getResultPerPage(){
		return 10;
	}
	
	public function _startResult(){
		return $this->limit + 1;
	}
	
	public function _endResult(){
		return $this->limit + $this->_getResultPerPage();
	}
	
	
	public function getCurrentPage(){
		return ($this->limit > 0) ? floor( $this->limit / $this->_getResultPerPage() ) + 1 : 1;
	}
	
	/*public function setSorting( $sorting = null ){
		$this->sort = ($sorting) ? $sorting : 0;
		$this->sortText = (@$this->sortings[$this->sort]) ? $this->sortings[$this->sort] : $this->sortings[0];
	}*/
	
	public function setSorting($sort_text){
		//if($this->sorting_order != null && $this->sorting_order != ''){
		//	$this->aditional_order[] = $sort_text;
		//} else {
			$this->sorting_order = $sort_text;

		//}
		//return ' ORDER BY ' . $this->_sortings[$this->sort] . implode(", " , $this->aditional_order);
	}
	
	public function getSorting($default_order=false){
		if(!$this->sorting_order || $this->sorting_order == ''){
			return ' ORDER BY ' . $default_order . implode(", " , $this->aditional_order);
		}
		return ' ORDER BY ' . $this->sorting_order . implode(", " , $this->aditional_order);
	}
	
	
	public function getSqlSort( ){
		return ' ORDER BY ' . $this->_sortings[$this->sort] . implode(", " , $this->aditional_order);
	}
	
	public function pushSqlSort($order){
		$this->aditional_order[] = $order;
	}
	
	public function getSqlFilters( ){
		$eq = ($this->_priceDropFilter == 1) ?  ' AND a.new_price < a.old_price ' : '';
		$eq .= $this->_filters[$this->filter];
		return $eq;
	}
	
	
}

?>