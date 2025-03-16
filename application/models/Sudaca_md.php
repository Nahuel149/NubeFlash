<?php
class Sudaca_md extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);    
    }

    function getOpciones($id){
        $query = $this->db
                        ->select('*')
                        ->where('opcion_id =', $id)
                        ->get('opciones_variables');
        return $query->result();
    }

    function contador($id, $campo, $tabla){
        $query = $this->db->query('
                        SELECT COUNT(id) AS cantidad
                        FROM '.$tabla.'
                        WHERE '.$campo.' = '.$id);
        return $query->row();
    }
    
    function getUltimosAccesos($id_user, $limit = 10, $date_from = null, $date_to = null) {
        $this->db->select('al.*, m.description as menu_description')
            ->from('activity_log al')
            ->join('menus m', 'm.link = al.action', 'left')
            ->where('al.id_user', $id_user)
            ->order_by('al.created_at', 'DESC');
            
        // Add date filters if provided
        if ($date_from && $date_to) {
            $this->db->where('DATE(al.created_at) >=', $date_from);
            $this->db->where('DATE(al.created_at) <=', $date_to);
        }
        
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }    

    function getAccesosDirectosPadres($id){
        $query = $this->db
                        ->select('p.*, m.id_menu, m.description, m.dashboard, m.active, m.iconpath')
                        ->join('menus m', 'm.id_menu = p.id_menu')
                        ->join('users_groups ug', 'ug.id_group = p.id_group')
                        ->where('ug.id_user', $id)
                        ->where('m.parent', 0)
                        ->where('p.read', 1)
                        ->where('m.dashboard', 1)
                        ->where('m.active', 1)
                        ->order_by('m.status')
                        ->get('permissions p');
        return $query->result();
    }

    function getAccesosDirectosHijos($id){
        $query = $this->db
                        ->select('p.*, m.link, m.description, m.dashboard, m.parent, m.iconpath')
                        ->join('menus m', 'm.id_menu = p.id_menu')
                        ->join('users_groups ug', 'ug.id_group = p.id_group')
                        ->where('ug.id_user', $id)
                        ->where('m.parent !=', 0)
                        ->where('p.read', 1)
                        ->where('m.dashboard', 1)
                        ->where('m.active', 1)
                        ->order_by('m.order, m.description')
                        ->get('permissions p');
        return $query->result();
    }

    function getMenus($id){
        $query = $this->db
                        ->select('p.*, m.id_menu, m.link, m.description, m.dashboard, m.active, m.iconpath')
                        ->join('menus m', 'm.id_menu = p.id_menu')
                        ->join('users_groups ug', 'ug.id_group = p.id_group')
                        ->where('ug.id_user', $id)
                        ->where('m.active', 1)
                        ->where('p.read', 1)
                        ->order_by('m.order, m.description')
                        ->get('permissions p');
        return $query->result();
    }

    function getSubmenus($id, $parent){
        $query = $this->db
                        ->select('p.*, m.link, m.description, m.dashboard, m.parent, m.iconpath')
                        ->join('menus m', 'm.id_menu = p.id_menu')
                        ->join('users_groups ug', 'ug.id_group = p.id_group')
                        ->where('ug.id_user', $id)
                        ->where('m.parent', $parent)
                        ->where('p.read', 1)
                        ->where('m.active', 1)
                        ->order_by('m.order, m.description')
                        ->get('permissions p');
        return $query->result();
    }

}