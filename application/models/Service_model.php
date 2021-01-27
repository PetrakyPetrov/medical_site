<?php

class Service_model extends UI_Model {

    public function getAll() {
        $sql = 'SELECT * FROM up_services';
        $query = $this->db->query($sql);
        return $query->result();
    }
}