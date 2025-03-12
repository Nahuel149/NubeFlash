<?php

class Destination_model extends CI_Model {

    private $table;
	private $id;

    public function __construct() {
        parent::__construct();
        $this->table = TABLE_DESTINATIONS;
        $this->id = 'destination_id';
    }

    public function get()
    {
        $this->db->select('destinations.*,provinces.name as province');
        $this->db->join('provinces','provinces.province_id = destinations.province_id AND provinces.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('destinations.active', ACTIVE);
    	$this->db->order_by('destinations.name','asc');
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
        $this->db->select('destinations.*,provinces.name as province');
        $this->db->join('provinces','provinces.province_id = destinations.province_id AND provinces.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('destinations.active', ACTIVE);
    	$this->db->where($this->id, $id);
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