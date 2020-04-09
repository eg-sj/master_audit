<?php 
use RestServer\RestController;
require APPPATH.'/libraries/RestController.php';
require APPPATH.'/libraries/Format.php';

class PwAll extends RestController{
	public function __construct(){
		parent::__construct();
		$this->load->model('pwModel','pw');
	}

	public function index_get(){
		$pw_id = $this->get('pw_id');
		$tahun = $this->get('tahun');
		if(empty($tahun) OR is_null($tahun)){
			$tahun = date('Y');
		}

		if (is_null($pw_id)){
			$data = $this->pw->getPwAll($tahun);			
		}else{
			$data = $this->pw->getPwDetail($pw_id);
		}
		
		if($data){
			$this->response([
				'status' 	=> TRUE,
				'data' 		=> $data
			], RestController::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> TRUE,
				'pesan' 	=> 'Data kosong',
				'data'		=> array()
			], RestController::HTTP_OK);
		}
	}


	public function index_post(){
		$data_pw = [
			'pkpt_id' =>$this->post('pkpt_id'),
			'kecamatan_kd' =>$this->post('kecamatan_kd'),
			'pw_kegiatan' =>$this->post('pw_kegiatan'),
			'pw_objek' =>$this->post('pw_objek'),
			'penugasan_kd' =>$this->post('penugasan_kd'),
			'wil_kd' =>$this->post('wil_kd'),
			'tahun' =>$this->post('tahun'),
			'pw_lokasi' =>$this->post('pw_lokasi'),
			'pw_sasaran' =>$this->post('pw_sasaran'),
			// 'pw_kartu_no' =>$this->post('pw_kartu_no'),
			'pw_tgl_awal' =>$this->post('pw_tgl_awal'),
			'pw_tgl_akhir' =>$this->post('pw_tgl_akhir'),
			'pw_tgl_laporan' =>$this->post('pw_tgl_laporan')
			
		];

		if($this->pw->createPw($data_pw)>0){
			$this->response([
				'status' => TRUE,
				'pesan' => 'Data berhasil ditambahkan'
			],RestController::HTTP_CREATED);
		} else {
			$this->response([
				'status' => TRUE,
				'pesan' => 'Data gagal ditambahkan'
			],RestController::HTTP_BAD_REQUEST);
		}
	}

	public function index_put(){
		$pw_id = $this->put('pw_id');
		$data_pw = [
			'pkpt_id' =>$this->put('pkpt_id'),
			'kecamatan_kd' =>$this->put('kecamatan_kd'),
			'pw_kegiatan' =>$this->put('pw_kegiatan'),
			'pw_objek' =>$this->put('pw_objek'),
			'penugasan_kd' =>$this->put('penugasan_kd'),
			'wil_kd' =>$this->put('wil_kd'),
			'tahun' =>$this->put('tahun'),
			'pw_lokasi' =>$this->put('pw_lokasi'),
			'pw_sasaran' =>$this->put('pw_sasaran'),
			// 'pw_kartu_no' =>$this->put('pw_kartu_no'),
			'pw_tgl_awal' =>$this->put('pw_tgl_awal'),
			'pw_tgl_akhir' =>$this->put('pw_tgl_akhir'),
			'pw_tgl_laporan' =>$this->put('pw_tgl_laporan')
			
		];
		$result = $this->pw->updatePw($data_pw, $pw_id);

		if($result>0){
			$this->response([
				'status' => TRUE,
				'pesan' => 'Data berhasil perbaharui'
			],RestController::HTTP_CREATED);
		} else {
			$this->response([
				'status' => TRUE,
				'pesan' => 'Data gagal diperbaharui'
			],RestController::HTTP_OK);
		}
	}

	public function index_delete(){
		$pw_id = $this->delete('pw_id');
		echo "pw_id=".$pw_id;

		if(is_null($pw_id)){
			$this->response([
				'status' =>FALSE,
				'pesan' => 'pw_id belum di isi'
			],RestController::HTTP_BAD_REQUEST);
		} else {
			if($this->pw->deletePw($pw_id)>0){
				$this->response([
					'status' => TRUE,
					'pesan' => 'Data berhasil di hapus'
				],RestController::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'pesan' => 'data tidak ditemukan'
				], RestController::HTTP_NOT_FOUND);
			}
		}
	}


}