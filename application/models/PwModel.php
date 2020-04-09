<?php 
class PwModel extends CI_Model{
	public function getPwAll($tahun = 0){
		$query = $this->db->query("
			SELECT * 
			FROM dat_pw 
			WHERE tahun = $tahun
			");
		return $query->result_array();
	}

	public function getPwDetail($pw_id = 0){
		$query = $this->db->query("
			SELECT A.*, B.penugasan_nama, C.kecamatan_nama, D.wil_nama, D.wil_rm
			FROM dat_pw A
			LEFT JOIN ref_penugasan B
				ON A.penugasan_kd = B.penugasan_kd
			LEFT JOIN ref_kecamatan C
				ON A.kecamatan_kd = C.kecamatan_kd
			LEFT JOIN ref_wilayah D
				ON A.wil_kd = D.wil_kd
			WHERE A.pw_id = $pw_id
			ORDER BY A.pw_id
			LIMIT 1
		");
		return $query->row_array();
	}

	public function createPw($data_pw){
		$this->db->insert('dat_pw', $data_pw);
		return $this->db->affected_rows();
	}

	public function updatePw($data_pw, $pw_id){
		$this->db->where('pw_id', $pw_id);
		$this->db->update('dat_pw', $data_pw);
		return $this->db->affected_rows();
	}

	public function deletePw($pw_id){
		$this->db->where('pw_id',$pw_id);
		$this->db->delete('dat_pw');
		return $this->db->affected_rows();
	}


	// pengawasan Tim
	
	public function getPwTim($pw_id = 0){
		$query = $this->db->query("
						SELECT A.*, B.pangkat_nama, B.pangkat_golruang, C.kt_kode, C.kt_nama
						FROM dat_pw_tim A
						LEFT JOIN ref_pangkat B
							ON A.pangkat_id = B.pangkat_id
						LEFT JOIN ref_tim C 
							ON A.kt_tim = C.kt_tim
						WHERE A.pw_id = $pw_id
						ORDER BY A.kt_tim, A.jabatan_jenis_id
		");
			return $query->result_array();
	}

	public function getPwTimDetail($pw_tim_id = 0){
			$query = $this->db->query("
						SELECT A.*, B.pangkat_nama, B.pangkat_golruang, C.kt_kode, C.kt_nama
						FROM dat_pw_tim A
						LEFT JOIN ref_pangkat B
							ON A.pangkat_id = B.pangkat_id
						LEFT JOIN ref_tim C 
							ON A.kt_tim = C.kt_tim
						WHERE A.pw_tim_id = $pw_tim_id
						ORDER BY A.kt_tim, A.jabatan_jenis_id
						LIMIT 1
		");
			return $query->row_array();
	}

	public function createPwTim($data_pw_tim){
		$this->db->insert('dat_pw_tim',$data_pw_tim);
		return $this->db->affected_rows();
	}

	public function updatePwTim($data_pw_tim, $pw_tim_id){
		$this->db->update('dat_pw_tim',$data_pw_tim,['pw_tim_id'=>$pw_tim_id]);
		return $this->db->affected_rows();
	}

	public function deletePwTim($pw_tim_id){
		$this->db->delete('dat_pw_tim',['pw_tim_id'=>$pw_tim_id]);
		return $this->db->affected_rows();
	}


}