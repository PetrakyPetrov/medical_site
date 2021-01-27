<?php
class Item_model extends UI_Model {
	
	private function _queryBuilder($data, $byPost = false){
		$whereString = ' WHERE 1 ';
		$groupString = '';
		$orderString = ' i.name DESC';
		
		if(array_key_exists('order', $data)){
			$orderString = $data['order'] . $orderString;
		}
		
		return array(
			'whereString' => $whereString, 
			'groupString'=>$groupString, 
			'orderString'=>$orderString
		);
	}
	
	public function getList($data = array(), $id = false){
		$offset = 0;
		$limit = 16;
		
		$request = $this->getRequest();
		$offset = $request->limit;
		
		$userId = $this->getInstance()->authorization->getUserId();
		
		$searchQuery = $this->_queryBuilder($data);
			
		
		if(array_key_exists('start', $data)){
			$offset = $data['start'];
		}
		if(array_key_exists('limit', $data)){
			$limit = $data['limit'];
		}
		
		$sql = 'SELECT 
			i.*,
			(SELECT path FROM media WHERE media.item_id = i.id AND media.is_cover = 1 LIMIT 1 ) AS media
			FROM items i
			' . $searchQuery['whereString'] . '
			' . $searchQuery['groupString'] . '
			ORDER BY ' . $searchQuery['orderString'] . ' LIMIT '.$offset.', '.$limit.'
		';
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	public function countList($data = array(), $id = false){

		$request = $this->getRequest();
		$offset = $request->limit;
		
		$userId = $this->getInstance()->authorization->getUserId();
		
		$searchQuery = $this->_queryBuilder($data);
			
		
		if(array_key_exists('start', $data)){
			$offset = $data['start'];
		}
		if(array_key_exists('limit', $data)){
			$limit = $data['limit'];
		}
		
		$sql = 'SELECT 
			COUNT(i.id) AS total
			FROM items i
			' . $searchQuery['whereString'] . '
			' . $searchQuery['groupString'] . '';
		$query = $this->db->query($sql);
		$r = $query->row();
		return $r->total;
	}
	
	public function getItem($id){
		$sql = 'SELECT 
			i.*
			FROM items i WHERE id = ? OR url_key = ? LIMIT 1';
			
		$query = $this->db->query($sql, array($id, $id));
		$itemRow = $query->row();
		if(!$itemRow){
			return false;
		}
		
		$sql = 'SELECT 
			i.*
			FROM item_facilities i WHERE item_id = ? ';
			
		$query = $this->db->query($sql, array($itemRow->id));
		$itemRow->facilities = array();
		foreach($query->result() as $row){
			$itemRow->facilities[] = $row->facility_id;
		}
		
		return $itemRow;
	}
	
	
	
	
	public function getAvailableFacilities(){
		$sql = 'SELECT * FROM facilities';
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function getSelectedFacilities($itemId){
		$sql = 'SELECT i.*, f.name, f.description, f.icon FROM item_facilities i LEFT JOIN facilities f ON (f.id = i.facility_id) WHERE i.item_id=?';
		$query = $this->db->query($sql, array($itemId));
		return $query->result();
	}
	
	
	public function insertMedia($values, $itemId){
		$masterData = array();
		
		foreach($this->db->query("SHOW COLUMNS FROM `media`")->result() as $dbField){
			$objectFields[] = $dbField->Field;
		}
		
		foreach($objectFields as $field){
			if(isset($values[$field])){
				$masterData[$field] = (($values[$field]) ? $values[$field] : '');
			}
		}
		$masterData['item_id'] = $itemId;
		
		$insert = $this->db->insert('media', $masterData);
		$this->checkMainImage($masterData['item_id']);
		return $this->db->insert_id();
	}
	
	public function checkMainImage($id){
		$sql = "SELECT p.id, p.is_cover FROM media p WHERE p.item_id=? AND p.is_cover = 1 LIMIT 1";
		$query = $this->db->query($sql, array($id));
		$item = $query->row();
		if(!$item){
			$this->db->query('UPDATE media p SET p.is_cover = 1 WHERE p.item_id = ? LIMIT 1', array($id));
		}
	}
	
	public function setMainImage($itemId, $imageId){
		$this->db->query('UPDATE media p SET p.is_cover = 0 WHERE p.item_id = ?', array($itemId));
		$this->db->query('UPDATE media p SET p.is_cover = 1 WHERE p.id = ?', array($imageId));
	}
	
	public function setSliderImage($imageId, $isSlide = false){
		$slide = ($isSlide) ? 1 : 0;
		$this->db->query('UPDATE media p SET p.is_slider = ? WHERE p.id = ?', array($slide, $imageId));
	}
	
	public function getMedia($itemId){
		$sql = 'SELECT * FROM media WHERE item_id=? ORDER BY order_key ASC';
		$query = $this->db->query($sql, array($itemId));
		return $query->result();
	}
	
	public function getMediaItem($id){
		$sql = 'SELECT * FROM media WHERE id=?';
		$query = $this->db->query($sql, array($id));
		return $query->row();
	}
	
	public function deleteMedia($itemId){
		$sql = 'DELETE FROM media WHERE id=?';
		$query = $this->db->query($sql, array($itemId));
		return true;
	}
	
	public function sortMediaOrder($id, $sortOrder, $collectionId) {
		$this->db->update('video_post', array(
			'sort_order' => (int)$sortOrder
		), array('video_id' => (string)$id, 'collection_id' => $collectionId));
	}
	
	public function setImageOrder($id, $sortOrder) {
		$this->db->update('media', array(
			'order_key' => (int)$sortOrder
		), array('id' => (string)$id));
	}
	
	public function update($values, $id = false){
	
		$objectFields = array();
		$isInsert = true;
		//$this->db->query("SHOW COLUMNS FROM `collections`");
		foreach($this->db->query("SHOW COLUMNS FROM `items`")->result() as $dbField){
			$objectFields[] = $dbField->Field;
		}
		
		$masterData = array(
			'date_added'=> date('Y-m-j H:i:s', time()),
			'date_modified'=> date('Y-m-j H:i:s', time()),
		);
		
		foreach($objectFields as $field){
			if(isset($values[$field])){
				$masterData[$field] = (($values[$field]) ? $values[$field] : '');
			}
		}
		
		
		if(!empty($id)){
			unset($masterData['date_created']);
			$insert = $this->db->update('items', $masterData, array('id'=>(int)$id));
		} else {
			$insert = $this->db->insert('items', $masterData);
			$id = $this->db->insert_id();
		}
		if($values['facility']){
			$this->db->delete('item_facilities', array('item_id' => (int)$id));
			foreach($values['facility'] as $facilityId){
				$this->db->insert('item_facilities', array(
					'item_id' => $id,
					'facility_id' => $facilityId
				));
			}
		}
		
		
		return $id;
		
	}
	
		

 }