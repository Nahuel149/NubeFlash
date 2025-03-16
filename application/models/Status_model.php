<?php

class Status_model extends CI_Model {
    private $table;
	private $id;

    public function __construct() {
        parent::__construct();
        $this->table = 'statuses';
        $this->id = 'status_id';
    }

    public function get($order = [], $where = [], $active = false) {
        $this->db->select('*');
        if ($active) {
            $this->db->where('active', ACTIVE);
        }
        foreach ($where as $value) {
            $this->db->where($value);
        }
        foreach ($order as $key => $value) {
            $this->db->order_by($key, $value);
        }
    	$query = $this->db->get($this->table);
    	return $query->result();
    }
}