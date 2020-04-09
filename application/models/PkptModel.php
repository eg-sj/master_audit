<?php 
class PkptModel extends CI_Model{
	public function getPkpt($tahun = 0){
		return $this->db->query("
			SELECT A.pkpt_id, B.penugasan_kd, C.wil_kd, C.wil_nama, A.pkpt_objek, B.penugasan_nama, A.tahun, A.rmp, A.rpl, A.pkpt_laporan, B.penugasan_laporan, A.status
			FROM dat_pkpt A
			LEFT JOIN ref_penugasan B
			ON A.penugasan_kd = B.penugasan_kd
			LEFT JOIN ref_wilayah C
			ON A.wil_kd = C.wil_kd
			WHERE A.tahun = $tahun
			ORDER BY A.pkpt_id
			")->result_array();
	}

	public function getPkptDetail($pkpt_id = 0){
		return $this->db->query("
			SELECT A.pkpt_id, B.penugasan_kd, C.wil_kd, C.wil_nama, A.pkpt_objek, B.penugasan_nama, A.tahun, A.rmp, A.rpl, A.pkpt_laporan, B.penugasan_laporan, A.status
			FROM dat_pkpt A
			LEFT JOIN ref_penugasan B
			ON A.penugasan_kd = B.penugasan_kd
			LEFT JOIN ref_wilayah C
			ON A.wil_kd = C.wil_kd
			WHERE A.pkpt_id = $pkpt_id
			LIMIT 1
			")->row_array();
	}

	public function createPkptAll($data_pkpt){
		$this->db->insert('dat_pkpt',$data_pkpt);
		return $this->db->affected_rows();
	}

	public function updatePkptAll($data_pkpt, $pkpt_id){
		$this->db->update('dat_pkpt',$data_pkpt,['pkpt_id'=>$pkpt_id]);
		return $this->db->affected_rows();
	}

	public function deletePkptAll($pkpt_id){
		$this->db->delete('dat_pkpt',['pkpt_id'=>$pkpt_id]);
		return $this->db->affected_rows();
	}


	
	// public function getPkptTim($pkpt_id=0){
	// 	if($pkpt_id == 0){
	// 			// $query = $this->db->query("
	// 		// 	SELECT A.pkpt_id, A.pkpt_tim_id, D.kt_nama, D.kt_kode, A.jml_tim, A.jml_hari, (B.uang_saku + B.uang_makan + B.transport + B.penginapan + B.kompensasi) as tarif, (A.jml_tim * A.jml_hari * (B.uang_saku + B.uang_makan + B.transport + B.penginapan + B.kompensasi)) as total_tarif
	// 		// 	FROM ref_tim D
	// 		// 	LEFT JOIN pkpt_tim A
	// 		// 	on A.kt_tim = D.kt_tim
	// 		// 	LEFT JOIN dat_tarif B
	// 		// 	on A.tarif_id = B.tarif_id
	// 		// 	LEFT JOIN dat_pkpt C
	// 		// 	on A.pkpt_id = C.pkpt_id
	// 		// 	WHERE B.tahun = C.tahun
	// 		// 	ORDER BY D.kt_kode
	// 		// 	");
	// 		return array();
	// 	}else{
			
	// 		$query = $this->db->query("
	// 			SELECT D.*, 
	// 			-- (select A.* from pkpt_tim A where A.kt_tim = D.kt_tim)


	// 			A.*, (B.uang_saku + B.uang_makan + B.transport + B.penginapan + B.kompensasi) as tarif, (A.jml_tim * A.jml_hari * (B.uang_saku + B.uang_makan + B.transport + B.penginapan + B.kompensasi)) as total_tarif
	// 			FROM ref_tim D
	// 			LEFT JOIN pkpt_tim A
	// 			on A.kt_tim = D.kt_tim
	// 			LEFT JOIN dat_tarif B
	// 			on A.tarif_id = B.tarif_id
	// 			LEFT JOIN dat_pkpt C
	// 			on A.pkpt_id = C.pkpt_id
	// 			WHERE B.tahun = C.tahun
	// 			AND A.pkpt_id = $pkpt_id
	// 			ORDER BY D.kt_tim	ASC
	// 			");
	// 		return $query->result_array();
	// 	}
	// }


	public function getPkptTim($pkpt_id=0, $kt_tim=0){
		$queryRefTim= $this->db->query("
					SELECT A.*
					FROM ref_tim A
					WHERE A.kt_tim = $kt_tim
					LIMIT 1
					");
				$dataRefTim = $queryRefTim->row_array();

		$query = $this->db->query("
			SELECT A.*, 
			(SELECT kt_kode FROM ref_tim B WHERE A.kt_tim = B.kt_tim) AS kt_kode,
			(SELECT kt_nama FROM ref_tim B WHERE A.kt_tim = B.kt_tim) AS kt_nama,
			(SELECT (uang_saku + uang_makan + transport + penginapan + kompensasi) FROM  dat_tarif C WHERE A.kt_tim = C.kt_tim) AS tarif,
			(SELECT A.jml_hari * (uang_saku + uang_makan + transport + penginapan + kompensasi) FROM  dat_tarif C WHERE A.kt_tim = C.kt_tim) AS total_tarif
			FROM dat_pkpt_tim A
			WHERE A.pkpt_id = '$pkpt_id'
			AND A.kt_tim = '$kt_tim'
			LIMIT 1
			");
		$query = $query->row_array();

		$data_kembali = array(
				'kt_kode' => $dataRefTim['kt_kode'],
				'kt_nama' => $dataRefTim['kt_nama'],
				'kt_tim' => $dataRefTim['kt_tim'],
				'pkpt_tim_id' => $query['pkpt_tim_id'], 
				'pkpt_id' => $query['pkpt_id'],
				'jml_tim' =>$query['jml_tim'],
				'jml_hari' =>$query['jml_hari'],
				'tahun' =>$query['tahun'],
				'tarif' =>$query['tarif'],
				'total_tarif' =>$query['total_tarif']
		);
		return $data_kembali;

	}

	public function getPkptTim1($pkpt_id=0, $kt_tim=0){
			if($kt_tim == 0){
				return array(
				'pkpt_tim_id' => "", 
				'pkpt_id' => "",
				'kt_tim' =>"",
				'tarif_id' =>"",
				'jml_tim' =>"",
				'jml_hari' =>"",
				'tahun' =>"",
				'kt_kode' =>"",
				'kt_nama' =>"",
				'tarif' =>"",
				'total_tarif' =>""
				);
			}else{
				$query = $this->db->query("
					SELECT A.*, 
					(SELECT kt_kode FROM ref_tim B WHERE A.kt_tim = B.kt_tim) AS kt_kode,
					(SELECT kt_nama FROM ref_tim B WHERE A.kt_tim = B.kt_tim) AS kt_nama,
					(SELECT (uang_saku + uang_makan + transport + penginapan + kompensasi) FROM  dat_tarif C WHERE A.tarif_id = C.tarif_id) AS tarif,
					(SELECT A.jml_hari * (uang_saku + uang_makan + transport + penginapan + kompensasi) FROM  dat_tarif C WHERE A.tarif_id = C.tarif_id) AS total_tarif
					FROM dat_pkpt_tim A
					WHERE A.pkpt_id = $pkpt_id
					AND A.kt_tim = $kt_tim
					LIMIT 1
					");
				return $query->row_array();

			}
		



				// -- (B.uang_saku + B.uang_makan + B.transport + B.penginapan + B.kompensasi) as tarif
				// -- (A.jml_tim * A.jml_hari * (B.uang_saku + B.uang_makan + B.transport + B.penginapan + B.kompensasi)) as total_tarif
				// FROM ref_tim D
				// -- LEFT JOIN pkpt_tim A
				// -- on A.kt_tim = D.kt_tim
				// -- LEFT JOIN dat_tarif B
				// -- on A.kt_tim = B.kt_tim
				// -- 	AND A.tahun = B.tahun
				// -- LEFT JOIN dat_pkpt C
				// -- on A.pkpt_id = C.pkpt_id
				// -- WHERE B.tahun = C.tahun
				// -- AND A.pkpt_id = '$pkpt_id'
				// -- AND A.kt_tim = '$kt_tim'
				// ORDER BY D.kt_tim	ASC
				// LIMIT 1
			// 	");
			// return $query->row_array();
	}

	// public function getPkptTim($pkpt_id=0, $kt_tim=0){

			
	// 		$query = $this->db->query("
	// 			SELECT D.*, 
	// 			-- (select A.* from pkpt_tim A where A.kt_tim = D.kt_tim)


	// 			A.*, (B.uang_saku + B.uang_makan + B.transport + B.penginapan + B.kompensasi) as tarif, (A.jml_tim * A.jml_hari * (B.uang_saku + B.uang_makan + B.transport + B.penginapan + B.kompensasi)) as total_tarif
	// 			FROM ref_tim D
	// 			LEFT JOIN pkpt_tim A
	// 			on A.kt_tim = D.kt_tim
	// 			LEFT JOIN dat_tarif B
	// 			on A.kt_tim = B.kt_tim
	// 				AND A.tahun = B.tahun
	// 			LEFT JOIN dat_pkpt C
	// 			on A.pkpt_id = C.pkpt_id
	// 			WHERE B.tahun = C.tahun
	// 			AND A.pkpt_id = '$pkpt_id'
	// 			AND A.kt_tim = '$kt_tim'
	// 			ORDER BY D.kt_tim	ASC
	// 			LIMIT 1
	// 			");
	// 		return $query->row_array();
	// }

		// if ($pkpt_id>0) {
		// 	$kondisi = "AND A.pkpt_id = '".$pkpt_id."'";
		// } else {$kondisi = "";}

	public function createPkptTim($data_pkpt_tim){
		$insert_query = $this->db->insert('dat_pkpt_tim', $data_pkpt_tim);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		return $insert_query;
	}
	
	public function updatePkptTim($data_pkpt_tim){
		$kunci = array (
			'pkpt_id' => $data_pkpt_tim['pkpt_id'],
			'kt_tim' => $data_pkpt_tim['kt_tim']
		);

		$this->db->where($kunci);
		$this->db->update('dat_pkpt_tim',$data_pkpt_tim);
		return $this->db->affected_rows();
	}
	
	public function deletePkptTim($pkpt_tim_id){
		$this->db->delete('dat_pkpt_tim',['pkpt_tim_id'=>$pkpt_tim_id]);
		return $this->db->affected_rows();
	}
	


}