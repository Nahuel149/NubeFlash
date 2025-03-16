<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auditoria_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_activity_logs($filters = array()) {
        $this->db->select('al.*, u.username')
                 ->from('activity_log al')
                 ->join('users u', 'u.id_user = al.id_user', 'left')
                 ->where('al.deleted_at IS NULL');
        
        // Apply filters
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(al.created_at) >=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(al.created_at) <=', $filters['date_to']);
        }
        
        if (!empty($filters['user_id'])) {
            $this->db->where('al.id_user', $filters['user_id']);
        }
        
        if (!empty($filters['action'])) {
            $this->db->where('al.action', $filters['action']);
        }
        
        $this->db->order_by('al.created_at', 'DESC');
        
        return $this->db->get()->result();
    }
    
    public function get_distinct_actions() {
        return $this->db->distinct()
                        ->select('action')
                        ->from('activity_log')
                        ->where('deleted_at IS NULL')
                        ->get()
                        ->result();
    }
    
    public function add_log($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('activity_log', $data);
    }
} 