<?php 
use RestServer\RestController;
require APPPATH.'/libraries/RestController.php';
require APPPATH.'/libraries/Format.php';

class PwDetail extends RestController{
	public function __construct(){
		parent::__construct();
		$this->load->model('pwModel','pw');
	}

	public function index_get(){
		$pkpt_id = $this->get('pkpt_id');
		
		if(!is_null($pkpt_id)){
			$data = $this->pw->getPwDetail($pkpt_id);
		}else{
			$data = '';
		}

		if($data){
			$this->response([
				'status' 	=> TRUE,
				'data' 		=> $data
			], RestController::HTTP_OK);
		} else {
			$this->response([
				'status' 	=> FALSE,
				'pesan' 	=> 'Data tidak ditemukan'
			], RestController::HTTP_NOT_FOUND);
		}
	}

	public function index_post(){
		$data_pw = [
			'pkpt_objek'=>$this->post('pkpt_objek'),
			'penugasan_kd'=>$this->post('penugasan_kd'),
			'pkpt_lokasi'=>$this->post('pkpt_lokasi'),
			'tahun'=>$this->post('tahun'),
			'rmp'=>$this->post('rmp'),
			'rpl'=>$this->post('rpl')
		];

		if($this->pw->createPwAll($data_pw)>0){
			$this->response([
				'status' => TRUE,
				'pesan' => 'Data berhasil ditambahkan'
			],RestController::HTTP_CREATED);
		} else {
			$this->response([
				'status' => FALSE,
				'pesan' => 'Data gagal ditambahkan'
			],RestController::HTTP_BAD_REQUEST);
		}
	}

	public function index_put(){
		$pkpt_id = $this->put('pkpt_id');
		$data_pw = [
			'pkpt_objek'=>$this->put('pkpt_objek'),
			'penugasan_kd'=>$this->put('penugasan_kd'),
			'pkpt_lokasi'=>$this->put('pkpt_lokasi'),
			'tahun'=>$this->put('tahun'),
			'rmp'=>$this->put('rmp'),
			'rpl'=>$this->put('rpl')
		];

		if($this->pw->updatePwAll($data_pw, $pkpt_id)>0){
			$this->response([
				'status' => TRUE,
				'pesan' => 'Data berhasil perbaharui'
			],RestController::HTTP_CREATED);
		} else {
			$this->response([
				'status' => FALSE,
				'pesan' => 'Data gagal diperbaharui'
			],RestController::HTTP_BAD_REQUEST);
		}
	}

	public function index_delete(){
		$pkpt_id = $this->delete('pkpt_id');
		if(is_null($pkpt_id)){
			$this->response([
				'status' =>FALSE,
				'pesan' => 'pkpt_id belum di isi'
			],RestController::HTTP_BAD_REQUEST);
		} else {
			if($this->pw->deletePwAll($pkpt_id)>0){
				$this->response([
					'status' => TRUE,
					'pesan' => 'Data berhasil di hapus'
				],RestController::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'pesan' => 'pkpt_id tidak ditemukan'
				], RestController::HTTP_NOT_FOUND);
			}
		}
	}

	
}