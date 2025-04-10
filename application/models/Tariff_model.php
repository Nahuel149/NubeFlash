<?php

class Tariff_model extends CI_Model {

    private $table;
	private $id;

    public function __construct() {
        parent::__construct();
        $this->table = TABLE_TARIFF;
        $this->id = 'tariff_id';
    }

    public function get()
    {
        $this->db->select('tariff.*,
            destinations.name as destination,
            destinations.postal_code,
            countries.name as country,
            provinces.name as province,
            COALESCE(destinations.name, tariff.destination_name_manual) as display_destination,
            COALESCE(provinces.name, tariff.province_name_manual) as display_province,
            COALESCE(destinations.postal_code, tariff.postal_code_manual) as display_postal_code');
        $this->db->join('destinations','destinations.destination_id = tariff.destination_id AND destinations.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('countries','countries.country_id = tariff.country_id AND countries.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('provinces','provinces.province_id = tariff.province_id AND provinces.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('tariff.active', ACTIVE);
    	$this->db->order_by('tariff.tariff_id','asc');
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
        $this->db->select('tariff.*,
            destinations.name as destination,
            destinations.postal_code,
            countries.name as country,
            provinces.name as province,
            COALESCE(destinations.name, tariff.destination_name_manual) as display_destination,
            COALESCE(provinces.name, tariff.province_name_manual) as display_province,
            COALESCE(destinations.postal_code, tariff.postal_code_manual) as display_postal_code');
        $this->db->join('destinations','destinations.destination_id = tariff.destination_id AND destinations.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('countries','countries.country_id = tariff.country_id AND countries.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('provinces','provinces.province_id = tariff.province_id AND provinces.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('tariff.active', ACTIVE);
    	$this->db->where('tariff.'.$this->id, $id);
    	$query = $this->db->get($this->table);
    	return $query->row();
    }

    public function edit($data, $id)
    {
    	$this->db->where($this->id, $id);
    	$this->db->update($this->table, $data);
    	return $this->db->insert_id();
    }

    public function getShippingCost($params)
    {
        $this->db->select('tariff.*,,destinations.name as destination,destinations.postal_code,countries.name as country,provinces.name as province');
        $this->db->join('destinations','destinations.destination_id = tariff.destination_id AND destinations.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('countries','countries.country_id = tariff.country_id AND countries.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('provinces','provinces.province_id = tariff.province_id AND provinces.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('tariff.active', ACTIVE);
        if(!empty($params['country']))
        {
            $this->db->where('tariff.country_id',$params['country']);
        }
        if(!empty($params['postal_code']))
        {
            $this->db->where('destinations.postal_code',$params['postal_code']);
        }
        if(!empty($params['weight']))
        {
            $this->db->where('tariff.weight >=',$params['weight']);
        }
        if(!empty($params['volume']))
        {
            $this->db->where('tariff.volume >=',$params['volume']);
        }
        $this->db->order_by('tariff.tariff_price','asc');
    	$query = $this->db->get($this->table);
    	return $query->row();
    }
}