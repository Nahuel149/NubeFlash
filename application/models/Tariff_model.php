<?php

class Tariff_model extends CI_Model {

    private $table;
	private $id;

    /**
     * Constructor
     * 
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->table = TABLE_TARIFF;
        $this->id = 'tariff_id';
    }

    /**
     * Get all tariffs
     * 
     * weights are in grams (g) and volumes in cubic centimeters (cm³)
     * 
     * @access public
     * @return array
     */
    public function get()
    {
        $this->db->select('tariff.*, tariff.province_name_manual, tariff.destination_name_manual, tariff.postal_code_manual, destinations.name as destination, destinations.postal_code, countries.name as country, provinces.name as province');
        $this->db->join('destinations','destinations.destination_id = tariff.destination_id AND destinations.active = "'.ACTIVE.'"', 'LEFT');
        $this->db->join('countries','countries.country_id = tariff.country_id AND countries.active = "'.ACTIVE.'"', 'LEFT');
        $this->db->join('provinces','provinces.province_id = tariff.province_id AND provinces.active = "'.ACTIVE.'"', 'LEFT');
    	$this->db->where('tariff.active', ACTIVE);
    	$this->db->order_by('tariff.tariff_id','asc');
    	$query = $this->db->get($this->table);
    	return $query->result();
    }

    /**
     * Insert a new tariff
     * 
     * @access public
     * @param array $data Data to insert with weight in grams (g) and volume in cubic centimeters (cm³)
     * @return int
     */
    public function insert($data)
    {
    	$this->db->insert($this->table, $data);
    	return $this->db->insert_id();
    }

    /**
     * Find a tariff by ID
     * 
     * @access public
     * @param int $id Tariff ID
     * @return object Tariff with weight in grams (g) and volume in cubic centimeters (cm³)
     */
    public function find($id)
    {
        $this->db->select('tariff.*, tariff.province_name_manual, tariff.destination_name_manual, tariff.postal_code_manual, destinations.name as destination, destinations.postal_code, countries.name as country, provinces.name as province');
        $this->db->join('destinations','destinations.destination_id = tariff.destination_id AND destinations.active = "'.ACTIVE.'"', 'LEFT');
        $this->db->join('countries','countries.country_id = tariff.country_id AND countries.active = "'.ACTIVE.'"', 'LEFT');
        $this->db->join('provinces','provinces.province_id = tariff.province_id AND provinces.active = "'.ACTIVE.'"', 'LEFT');
    	$this->db->where('tariff.active', ACTIVE);
    	$this->db->where('tariff.'.$this->id, $id);
    	$query = $this->db->get($this->table);
    	return $query->row();
    }

    /**
     * Edit a tariff
     * 
     * @access public
     * @param array $data New data with weight in grams (g) and volume in cubic centimeters (cm³)
     * @param int $id Tariff ID
     * @return int
     */
    public function edit($data, $id)
    {
    	$this->db->where($this->id, $id);
    	$this->db->update($this->table, $data);
    	return $this->db->insert_id();
    }

    /**
     * Get shipping cost
     * 
     * @access public
     * @param array $params Parameters with weight in grams (g) and volume in cubic centimeters (cm³)
     * @return object
     */
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