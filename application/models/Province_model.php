<?php

class Province_model extends CI_Model {

    private $table;
	private $id;

    public function __construct() {
        parent::__construct();
        $this->table = TABLE_PROVINCES;
        $this->id = 'province_id';
    }

    public function get()
    {
        $this->db->select('provinces.*,countries.name as country');
        $this->db->join('countries','countries.country_id = provinces.country_id AND countries.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('provinces.active', ACTIVE);
    	$this->db->order_by('provinces.name','asc');
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
        $this->db->select('provinces.*,countries.name as country');
        $this->db->join('countries','countries.country_id = provinces.country_id AND countries.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('provinces.active', ACTIVE);
    	$this->db->where('provinces.'.$this->id, $id);
    	$query = $this->db->get($this->table);
    	return $query->row();
    }

    public function edit($data, $id)
    {
    	$this->db->where($this->id, $id);
    	$this->db->update($this->table, $data);
    	return $this->db->insert_id();
    }
}