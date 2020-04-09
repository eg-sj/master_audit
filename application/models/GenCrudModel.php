<?php 

class GenCrudModel extends CI_Model {

	public function getGenCrud($id=0, $tabel=0, $kunci=0){
		$query = $this->db->query("
				SELECT *
				FROM $tabel 
				WHERE $kunci = $id
				LIMIT 1
				");
		$query->row_result();

	}

	public function createGenCrud($data=0, $tabel=0){
		$this->db->insert($tabel, $data);
		return $this->db->affected_rows();
	}

	public function updateGenCrud($kunci=0, $tabel=0, $data=0){
		// print_r($kunci);echo "<br>";
		// print_r($tabel);echo "<br>";
		// print_r($data);echo "<br>";

		$this->db->where($kunci);
		$this->db->update($tabel, $data);
		return $this->db->affected_rows();


	}

	public function deleteGenCrud($tabel=0, $id=0, $kunci=0){
		$this->db->where($kunci, $id);
		$this->db->delete($tabel);
		return $this->db->affected_rows();
	}
}