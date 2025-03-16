<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {

	private $table;
	private $id;

    public function __construct() {
        parent::__construct();
        $this->table = 'faqs';
        $this->id = 'id_faw';
    }

	public function get($params)
	{
		if (!empty($params['where'])) {
			$this->db->where($params['where']);
		}
		$query = $this->db->get('faqs');
		return $query->result();
	}

	public function add($data)
    {
    	$this->db->insert($this->table, $data);
    	return $this->db->insert_id();
    }

    public function find($params)
    {
		
    	if (!empty($params['where'])) {
			$this->db->where($params['where']);
		}
		$query = $this->db->get('faqs');
		return $query->row();
    }

    public function edit($data, $params)
    {
    	$this->db->where($params['where']);
		$this->db->update('faqs', $data);
    }

}

/* End of file Faqs_model.php */
/* Location: ./application/models/Faqs_model.php */