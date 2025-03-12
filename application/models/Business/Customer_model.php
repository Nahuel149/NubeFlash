<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
    
    private $table = 'customers';
    private $primary_key = 'customer_id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->where('active', 1);
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        $this->db->where($this->primary_key, $id);
        $this->db->where('active', 1);
        return $this->db->get($this->table)->row();
    }

    public function get_by_email($email) {
        $this->db->where('email', $email);
        $this->db->where('active', 1);
        return $this->db->get($this->table)->row();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['active'] = 1;
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $data = array(
            'active' => 0,
            'deleted_at' => date('Y-m-d H:i:s')
        );
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }

    public function get_customer_tokens($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('active', 1);
        return $this->db->get('token_customers')->result();
    }

    public function validate_token($token) {
        $this->db->select('c.*');
        $this->db->from($this->table . ' c');
        $this->db->join('token_customers tc', 'c.customer_id = tc.customer_id');
        $this->db->where('tc.token', $token);
        $this->db->where('tc.active', 1);
        $this->db->where('c.active', 1);
        return $this->db->get()->row();
    }

    public function get_shipping_info($customer_id) {
        $this->db->select('c.*, co.name as country_name, p.name as province_name');
        $this->db->from($this->table . ' c');
        $this->db->join('countries co', 'c.country_id = co.country_id', 'left');
        $this->db->join('provinces p', 'c.province_id = p.province_id', 'left');
        $this->db->where('c.' . $this->primary_key, $customer_id);
        $this->db->where('c.active', 1);
        return $this->db->get()->row();
    }
} 