<?php 
use RestServer\RestController;
require APPPATH.'/libraries/RestController.php';
require APPPATH.'/libraries/Format.php';

class PwTim extends RestController{
	public function __construct(){
		parent::__construct();
		$this->load->model('pwModel','pw');
	}

	public function index_get(){
		$pw_id = $this->get('pw_id');
		$pw_tim_id = $this->get('pw_tim_id');
		if(is_null($pw_tim_id)){
			$data = $this->pw->getPwTim($pw_id);
		}else{
			$data = $this->pw->getPwTimDetail($pw_tim_id);
		}

		if($data){
			$this->response([
				'status' => TRUE,
				'data' => $data
			], RestController::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'data' => array()
			], RestController::HTTP_OK);
		}
	}

	public function index_post(){
		$data_pw_tim = [
			'kt_tim' => $this->post('kt_tim'),
			'pw_id' => $this->post('pw_id'),
			'nip' => $this->post('nip'),
			'nama' => $this->post('nama'),
			'pangkat_id' => $this->post('pangkat_id'),
			'jabatan_nama' => $this->post('jabatan_nama')
		];

		if($this->pw->createPwTim($data_pw_tim)>0){
			$this->response([
				'status' => TRUE,
				'pesan' => 'data telah ditambahkan'
			], RestController::HTTP_CREATED);
		}else{
			$this->response([
				'status' => FALSE,
				'pesan' => 'data gagal ditambahkan'
			], RestController::HTTP_BAD_REQUEST);
		}
	}

	public function index_put(){
		$pw_tim_id = $this->put('pw_tim_id');
		$data_pw_tim = [
			'kt_tim' => $this->put('kt_tim'),
			'pw_id' => $this->put('pw_id'),
			'nip' => $this->put('nip'),
			'nama' => $this->put('nama'),
			'pangkat_id' => $this->put('pangkat_id'),
			'jabatan_nama' => $this->put('jabatan_nama')
		];
		
		if($this->pw->updatePwTim($data_pw_tim, $pw_tim_id)>0){
			$this->response([
				'status' => TRUE,
				'pesan' => 'data telah diperbaharui'
			], RestController::HTTP_CREATED);
		}else{
			$this->response([
				'status' => FALSE,
				'data' => array()
			], RestController::HTTP_OK);
		}
	}

	public function index_delete(){
		$pw_tim_id = $this->delete('pw_tim_id');
		if(is_null($pw_tim_id)){
			$this->response([
				'status' => FALSE,
				'pesan' => 'pw_tim_id belum diinput'
			], RestController::HTTP_BAD_REQUEST);
		}else{
			if($this->pw->deletePwTim($pw_tim_id)>0){
				$this->response([
					'status' => TRUE,
					'pesan' => 'data berhasil dihapus'
				], RestController::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'pesan' => 'data tidak ditemukan'
				], RestController::HTTP_NOT_FOUND);
			}
		}
	}


}