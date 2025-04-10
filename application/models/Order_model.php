<?php

class Order_model extends CI_Model {

    private $table;
	private $id;

    public function __construct() {
        parent::__construct();
        $this->table = TABLE_ORDER;
        $this->id = 'order_id';
    }

    public function get($params = null)
    {
        $this->db->select('orders.*,tariff.tariff_price as price,destinations.name as destination,destinations.postal_code,countries.name as country,provinces.name as province,statuses.name as status');
        $this->db->join('tariff','tariff.tariff_id = orders.tariff_id AND tariff.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('destinations','destinations.destination_id = tariff.destination_id AND destinations.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('countries','countries.country_id = tariff.country_id AND countries.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('provinces','provinces.province_id = tariff.province_id AND provinces.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('statuses','statuses.status_id = orders.status_id AND statuses.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('orders.active', ACTIVE);
        if(!empty($params['where']))
        {
            $this->db->where($params['where']);
        }
    	$this->db->order_by('orders.order_id','asc');
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
        $this->db->select('orders.*,tariff.tariff_price as price,destinations.name as destination,destinations.postal_code,countries.name as country,provinces.name as province,statuses.name as status');
        $this->db->join('tariff','tariff.tariff_id = orders.tariff_id AND tariff.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('destinations','destinations.destination_id = tariff.destination_id AND destinations.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('countries','countries.country_id = tariff.country_id AND countries.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('provinces','provinces.province_id = tariff.province_id AND provinces.active = "'.ACTIVE.'"','LEFT');
        $this->db->join('statuses','statuses.status_id = orders.status_id AND statuses.active = "'.ACTIVE.'"','LEFT');
    	$this->db->where('orders.active', ACTIVE);
    	$this->db->where('orders.'.$this->id, $id);
    	$query = $this->db->get($this->table);
    	return $query->row();
    }

    public function edit($data, $id)
    {
    	$this->db->where($this->id, $id);
    	$this->db->update($this->table, $data);
    	return $this->db->insert_id();
    }

    // public function getShippingCost($params)
    // {
    //     $this->db->select('tariff.*,,destinations.name as destination,destinations.postal_code,countries.name as country,provinces.name as province');
    //     $this->db->join('destinations','destinations.destination_id = tariff.destination_id AND destinations.active = "'.ACTIVE.'"','LEFT');
    //     $this->db->join('countries','countries.country_id = tariff.country_id AND countries.active = "'.ACTIVE.'"','LEFT');
    //     $this->db->join('provinces','provinces.province_id = tariff.province_id AND provinces.active = "'.ACTIVE.'"','LEFT');
    // 	$this->db->where('tariff.active', ACTIVE);
    //     if(!empty($params['country']))
    //     {
    //         $this->db->where('tariff.country_id',$params['country']);
    //     }
    //     if(!empty($params['postal_code']))
    //     {
    //         $this->db->where('destinations.postal_code',$params['postal_code']);
    //     }
    //     if(!empty($params['weight']))
    //     {
    //         $this->db->where('tariff.weight',$params['weight']);
    //     }
    //     if(!empty($params['volume']))
    //     {
    //         $this->db->where('tariff.volume',$params['volume']);
    //     }
    // 	$query = $this->db->get($this->table);
    // 	return $query->row();
    // }
}