<?php
/**
 * Created by PhpStorm.
 * User: ppetrov
 * Date: 19.04.18
 * Time: 10:36
 */

class Office_model extends UI_Model {

    public function getIds() {
        $sql = 'SELECT id FROM up_offices';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getAll() {
        $sql = 'SELECT * FROM up_offices';
        $query = $this->db->query($sql);
        return $query->result();
    }
}