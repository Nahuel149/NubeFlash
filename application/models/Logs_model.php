<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logs_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_login_attempts($filters = array()) {
        $this->db->select('la.*, u.username')
                 ->from('login_attempts la')
                 ->join('users u', 'u.id_user = la.id_user', 'left');
        
        if (!empty($filters['date_from'])) {
            $this->db->where('FROM_UNIXTIME(la.time) >=', $filters['date_from'] . ' 00:00:00');
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where('FROM_UNIXTIME(la.time) <=', $filters['date_to'] . ' 23:59:59');
        }
        
        $this->db->order_by('la.time', 'DESC');
        
        return $this->db->get()->result();
    }
    
    public function get_login_errors($filters = array()) {
        $this->db->select('*')
                 ->from('login_errors');
        
        if (!empty($filters['date_from'])) {
            $this->db->where('date >=', $filters['date_from'] . ' 00:00:00');
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where('date <=', $filters['date_to'] . ' 23:59:59');
        }
        
        $this->db->order_by('date', 'DESC');
        
        return $this->db->get()->result();
    }
    
    public function get_login_attempts_errors($filters = array()) {
        $this->db->select('lae.*, u.username')
                 ->from('login_attempts_errors lae')
                 ->join('users u', 'u.id_user = lae.id_user', 'left')
                 ->where('lae.deleted_at IS NULL');
        
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(lae.created_at) >=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(lae.created_at) <=', $filters['date_to']);
        }
        
        $this->db->order_by('lae.created_at', 'DESC');
        
        return $this->db->get()->result();
    }
} 