<?php

class Sudaca_ecommerce_md extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function login($usuario, $password, $campo){
        $query = $this->db
                        ->select('*')
                        ->where($campo, $usuario)
                        ->where('password', $password)
                        ->where('tipo_usuario_id',2)
                        ->get('ecommerce_usuarios');
        if ($query->num_rows() > 0){
            return $query->row();
        }

        else return null;

    }

}