<?php

class Slider_model extends CI_Model {

    private $table;
	private $id;

    public function __construct() {
        parent::__construct();
        $this->table = TABLE_IMAGE_GALLERY;
        $this->id = 'id_image';
    }

    public function get()
    {
    	$this->db->where('active', ACTIVE);
    	$this->db->order_by('id_image','desc');
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
    	$this->db->where($this->id, $id);
    	$this->db->update($this->table, $data);
    	return $this->db->insert_id();
    }

}