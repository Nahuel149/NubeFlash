<?php
class Sudaca_backend_md extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function groups_getAll(){
        $user_row = $this->ion_auth->user()->row();
        if (!$this->ion_auth->in_group(1, $user_row->id)){
            $query = $this->db
                            ->where('id_group !=', '1')
                            ->get('groups');                            
        }
        else{
            $query = $this->db->get('groups');
        }
        return $query->result();
    }


    function users_getAllRol($group_id)
    {
        $query = $this->db
                    ->select('us.*,gro.name as nombre_grupo')
                    ->join('users_groups us_gro','us_gro.user_id = us.id')
                    ->join('groups gro','gro.id = us_gro.group_id')
                    ->where('us_gro.group_id', $group_id)
                    ->where('us.deleted',0)
                    ->get('users us');
        return $query->result();
    }


    function menus_getAll(){
        $query = $this->db
                        ->select('m1.description AS parent_descr, m.id_menu AS id, m.description AS descr, m.*')
                        ->join('menus m1', 'm1.id_menu = m.parent', 'left')
                        ->get('menus m');
        return $query->result();
    }

    function menus_getForPermisos(){
        $user_row = $this->ion_auth->user()->row();
        if (!$this->ion_auth->in_group(1, $user_row->id)){
            $grupo = $this->ion_auth->get_users_groups($user_row->id)->result();
            foreach ($grupo as $f) {
                $g_id = $f->id;    
            }

            $query = $this->db
                        ->select('m1.description AS parent_descr, m.id_menu AS id, m.description AS descr, m.*')
                        ->join('menus m1', 'm1.id_menu = m.parent', 'left')
                        ->join('permissions p', 'p.id_menu = m.id_menu')
                        ->where('m.active', 1)
                        ->where('p.id_group', $g_id)
                        ->get('menus m');
        }else{
            $query = $this->db
                        ->select('m1.description AS parent_descr, m.id_menu AS id, m.description AS descr, m.*')
                        ->join('menus m1', 'm1.id_menu = m.parent', 'left')
                        ->where('m.active', 1)
                        ->get('menus m');
        }    
        return $query->result();
    }

    function permisos_getAll(){
        $user_row = $this->ion_auth->user()->row();
        if (!$this->ion_auth->in_group(1, $user_row->id)){
          $query = $this->db
                        ->select('p.*, g.name AS grupo, m.description AS menu')
                        ->join('groups g','p.id_group = g.id_group')
                        ->join('menus m', 'p.id_menu = m.id_menu')
                        ->where('p.id_group !=', 1)
                        ->get('permissions p');
        }else{
          $query = $this->db
                        ->select('p.*, g.name AS grupo, m.description AS menu')
                        ->join('groups g','p.id_group = g.id_group')
                        ->join('menus m', 'p.id_menu = m.id_menu')
                        ->get('permissions p');      
        }
        
        return $query->result();
    }

    function permisos_buscar(/*$perpage,$start*/){
        $query = $this->db
                        ->select('permissions.id AS id, menus.descripcion AS menu, groups.id AS id_grupo, groups.description AS grupo, permisos.read AS Leer, 
                            permissions.insert AS Insertar, permissions.update AS Actualizar, permisos.delete AS Borrar, permisos.exportar AS Exportar, permisos.imprimir AS Imprimir')
                        ->join('menus',     'menus.id = permissions.menu_id', 'inner')
                        ->join('groups',    'groups.id = permissions.group_id', 'inner');
        if($where = $this->input->post('buscar', TRUE))
            $query = $this->db->where('permissions.id =', $where)
                            ->or_where("menus.descripcion LIKE '%".$where."%'")
                            ->or_where("groups.description LIKE '%".$where."%'");
        $query = $this->db
                        ->get('permissions');
        return $query->result('array');
    }

    function permisos_getByLink($link){
        $query = $this->db
                    ->select('id_menu')
                    ->where('link',$link)
                    ->get('menus');
        return $query->row();
    }

    function permisos_buscarPermiso($url, $perfil){
        $query = $this->db
                        ->select('p.read')
                        ->join('menus m', 'm.id_menu = p.id_menu')
                        ->where('p.id_group', $perfil)
                        ->like('m.link', $url)
                        ->get('permissions p');
        return $query->row();
    }

    function permisos_buscarGrupo($usuario){
        $query = $this->db
                        ->select('id_group')
                        ->where('id_user', $usuario)
                        ->get('users_groups');
        return $query->row();
    }

    function users_getAll(){
        $user_row = $this->ion_auth->user()->row();
        if (!$this->ion_auth->in_group(1, $user_row->id)){
            $query = $this->db
                            ->select('u.*, g.name AS nombre_grupo')
                            ->join('users_groups up', 'up.id_user = u.id_user')
                            ->join('groups g', 'g.id_group = up.id_group')
                            ->where('g.id_group !=', 1)
                            ->get('users u');
        }
        else{
            $query = $this->db
                            ->select('u.*, g.name AS nombre_grupo')
                            ->join('users_groups up', 'up.id_user = u.id_user')
                            ->join('groups g', 'g.id_group = up.id_group')                            
                            ->get('users u');            
        }
        
        $results = $query->result();
        
        // Initialize default values for any fields that might be accessed
        foreach ($results as $user) {
            $user->foto = '';
            $user->telefono = '';
            $user->phone = '';
        }
        
        return $results;
    }
}