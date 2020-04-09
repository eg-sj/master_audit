<?php 
class RefModel extends CI_Model{
	
	public function getRef($tabel=0){
		
		return $this->db->get($tabel)->result_array();
	}

} 
