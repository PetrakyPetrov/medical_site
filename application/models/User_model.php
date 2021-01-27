<?php
class User_model extends UI_Model {


	public $user_id = "";
	public $full_name = "";
	public $pwd = "";
	public $fb_uid = "";

	public function createUser($dbValues = array()) {
		$data = array(
			'username'=> (isset($dbValues['username']) ? $dbValues['username'] : ''),
			'first_name'=> (isset($dbValues['first_name']) ? $dbValues['first_name'] : ''),
			'last_name'=> (isset($dbValues['last_name']) ? $dbValues['last_name'] : ''),
			// 'created_date'=> date('Y-m-j H:i:s', time()),
			// 'updated_date'=> date('Y-m-j H:i:s', time()),
		);
		
		$insert = $this->db->insert('users', $data);
		if($insert){
			return $this->db->insert_id();
		}
		return false;
		
	}
	
	public function updateUser($dbValues = array()) {
		$data = array(
            'username'=> (isset($dbValues['username']) ? $dbValues['username'] : ''),
            'first_name'=> (isset($dbValues['first_name']) ? $dbValues['first_name'] : ''),
            'last_name'=> (isset($dbValues['last_name']) ? $dbValues['last_name'] : ''),
            // 'created_date'=> date('Y-m-j H:i:s', time()),
            // 'updated_date'=> date('Y-m-j H:i:s', time()),
		);
		
		$insert = $this->db->update('up_users', $data, array(
			'id'=>$dbValues['user_id']
		));
		$userData = $this->getUserInfo($dbValues['user_id']);
		$this->getInstance()->authorization->startSession($userData);
		return false;
		
	}
		
	public function getUser($uid){
		$sql = "SELECT * FROM up_users WHERE id=? LIMIT 1";
		$q = $this->db->query($sql, array($uid));
		return $q->row();
	}
	
	public function getSystemUsers(){
		$sql = "SELECT id, displayname FROM up_users WHERE is_system = 1 OR is_admin = 1";
//		$sql = "SELECT id, displayname FROM users ";
		$q = $this->db->query($sql, array($uid));
		return $q->result();
	}
	
	public function getUserInfo($uid){
		$userId = $this->getInstance()->authorization->getUserId();
		$sql = "SELECT 
			u.*, cf.id AS follow_id
			FROM up_users u 
			LEFT JOIN collection_follow cf
				ON (cf.followed_id = u.id AND cf.user_id = ?)	
			WHERE u.id=? LIMIT 1";
		$q = $this->db->query($sql, array($userId, $uid));
		return $q->row();
	}
	
	public function getUserIdByPass($username, $password) {
		$sql = "SELECT * FROM up_users WHERE username = ? AND password = ?";
		$usrQry = $this->db->query($sql, array($username, md5($password)));
		if($usrQry->num_rows < 1) {
			return $usrQry->row();
		} else {
			return false;
		}
	}
 }