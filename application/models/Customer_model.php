<?php

class Customer_model extends CI_Model {

    private $table;
	private $id;

    public function __construct() {
        parent::__construct();
        $this->table = TABLE_CUSTOMERS;
        $this->id = 'customer_id';
    }

    public function get($conditions = null)
    {
    	$this->db->where('active', ACTIVE);
    	
    	// Apply additional conditions if provided
    	if (is_array($conditions)) {
    	    foreach ($conditions as $field => $value) {
    	        if ($field == 'id') {
    	            $this->db->where($this->id, $value);
    	        } else {
    	            $this->db->where($field, $value);
    	        }
    	    }
    	}
    	
    	$this->db->order_by('social_reason','asc');
    	$query = $this->db->get($this->table);
    	return $query->result();
    }

    public function insert($data)
    {
    	$this->db->insert($this->table, $data);
    	return $this->db->insert_id();
    }

    public function find($id)
    {
    	$this->db->where('active', ACTIVE);
    	$this->db->where($this->id, $id);
    	$query = $this->db->get($this->table);
    	return $query->row();
    }

    public function edit($data, $id)
    {
        try {
            $this->db->where($this->id, $id);
            $this->db->update($this->table, $data);
            return $this->db->affected_rows() > 0;
        } catch (Exception $e) {
            log_message('error', 'Database error in Customer_model::edit: ' . $e->getMessage());
            throw $e;
        }
    }
}