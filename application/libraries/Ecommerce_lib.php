<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ecommerce_lib{
	
	public function __construct(){
		
	}

	public function __get($var){
		return get_instance()->$var;
	}	

	public function paginacion_producto($producto){
		$producto = $this->codegen_model->row('ecommerce_productos','*','id = '.$producto);
		$productos = $this->codegen_model->get('ecommerce_productos','*','categoria_id = "'.$producto->categoria_id.'" AND subcategoria_id = "'.$producto->subcategoria_id.'"');
		$anterior 	= 0;
		$siguiente 	= 0;
		$ultimo 	= end($productos);
		foreach ($productos as $key => $value) {						
			if($productos[$key]->id == $producto->id) {
				if(isset($productos[$key - 1])) $anterior = $productos[$key - 1]->id;
				if(isset($productos[$key + 1])) $siguiente = $productos[$key + 1]->id;
			}
		}

		$productos = array(
			'anterior' => $this->codegen_model->row('ecommerce_productos','id, nombre','id = '.$anterior),
			'siguiente' => $this->codegen_model->row('ecommerce_productos','id, nombre','id = '.$siguiente)
		);

		return $productos;
	}
}