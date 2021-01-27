<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI_Model extends CI_Model {
		
	protected $_request = null;
	protected $_language = 'tr';
	
	const REPOST = 1;
	
	const FOLLOW = 2;
	const UNFOLLOW = 3;
	
	const FOLLOW_USER = 4;
	const UNFOLLOW_USER = 5;
	
	const ADDVIDEO = 6;
	
	const ADDCOLLECTION = 7;
	
	const LIKEVIDEO = 8;
	const UNLIKEVIDEO = 9;
	
	const COMMENTVIDEO = 10;	
	
	private $_instance;
	
	function __construct(){
		parent::__construct();
	}
	
	public function setLanguage($lang){
		$this->_language = $lang;
	}
	
	public function getInstance(){
		if(!$this->_instance){
			$this->_instance =& get_instance();
		}
		return $this->_instance;
	}
	
	public function getRequest(){
		$CI =& get_instance();
		if(null === $this->_request){
			$CI->load->model('Request_Model');
			$this->_request = $CI->Request_Model->getRequest();
		}
		return $this->_request;
	}
//	public function addSystemHistory($date = null, $userId = null, $to, $type, $pin_id = 0, $board_id = 0, $comment = '') {
//
//		$userId = ($userId) ? $userId : $this->getInstance()->authorization->getUserId();
//		$date = ($date) ? $date : date('Y-m-j H:i:s', time());
//
//		if($to == $userId) {
//			return;
//		} else if(!$userId) {
//			return;
//		}
//
//		$this->db->insert('user_feed', array(
//			'date_added' => $date,
//			'from_user_id' => (int)$userId,
//			'to_user_id' => (int)$to,
//			'action_type' => (int)$type,
//			'video_id' => (int)$pin_id,
//			'collection_id' => (int)$board_id,
//			'comment' => $comment
//		));
//
//		$historyId = $this->db->insert_id();
//	}
//
//	public function addHistory($to, $type, $pin_id = 0, $board_id = 0, $comment = '') {
//
//		$userId = $this->getInstance()->authorization->getUserId();
//
//		if($to == $userId) {
//			return;
//		} else if(!$userId) {
//			return;
//		}
//
//		$this->db->insert('user_feed', array(
//			'date_added' => date('Y-m-j h:i:s', time()),
//			'from_user_id' => (int)$userId,
//			'to_user_id' => (int)$to,
//			'action_type' => (int)$type,
//			'video_id' => (int)$pin_id,
//			'collection_id' => (int)$board_id,
//			'comment' => $comment
//		));
//
//		$historyId = $this->db->insert_id();
//		/*
//		if($historyId) {
//			switch($type){
//
//			}
//			if(self::FOLLOW == $type) {
//				$db->delete('users_history', array('to_user_id = ?' => (string)$to,'from_user_id = ?' => (string)JO_Session::get('user[user_id]'), 'history_action = ?' => self::UNFOLLOW, 'board_id = ?' => (string)$board_id));
//			} elseif(self::UNFOLLOW == $type) {
//				$db->delete('users_history', array('to_user_id = ?' => (string)$to,'from_user_id = ?' => (string)JO_Session::get('user[user_id]'), 'history_action = ?' => self::FOLLOW, 'board_id = ?' => (string)$board_id));
//			} elseif(self::FOLLOW_USER == $type) {
//				$db->delete('users_history', array('to_user_id = ?' => (string)$to,'from_user_id = ?' => (string)JO_Session::get('user[user_id]'), 'history_action = ?' => self::UNFOLLOW_USER));
//			} elseif(self::UNFOLLOW_USER == $type) {
//				$db->delete('users_history', array('to_user_id = ?' => (string)$to,'from_user_id = ?' => (string)JO_Session::get('user[user_id]'), 'history_action = ?' => self::FOLLOW_USER));
//			} elseif(self::LIKEPIN == $type) {
//				$db->delete('users_history', array('to_user_id = ?' => (string)$to,'from_user_id = ?' => (string)JO_Session::get('user[user_id]'), 'history_action = ?' => self::UNLIKEPIN, 'pin_id = ?' => (string)$pin_id));
//			} elseif(self::UNLIKEPIN == $type) {
//				$db->delete('users_history', array('to_user_id = ?' => (string)$to,'from_user_id = ?' => (string)JO_Session::get('user[user_id]'), 'history_action = ?' => self::LIKEPIN, 'pin_id = ?' => (string)$pin_id));
//			}
//		}
//		*/
//	}
}