<?php 
use RestServer\RestController;
require APPPATH.'/libraries/RestController.php';
require APPPATH.'/libraries/Format.php';

class GenCrud extends RestController{
	public function __construct(){
		parent::__construct();
		$this->load->model('GenCrudModel');
	}

	public function index_post(){
		$kunci = json_decode($this->post('kunci'), TRUE) ;
		$data = json_decode($this->post('data'), TRUE);
		$tabel = $this->post('tabel');
		// print_r($dataput);


		$result = $this->GenCrudModel->createGenCrud($kunci, $tabel, $data);

		if($result>0){
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
	

	public function index_put(){
		$dataput['kunci'] = $kunci = json_decode($this->put('kunci'), TRUE) ;
		$dataput['data'] = $data = json_decode($this->put('data'), TRUE);
		$dataput['tabel'] = $tabel = $this->put('tabel');
		// print_r($dataput);


		$result = $this->GenCrudModel->updateGenCrud($kunci, $tabel, $data);

		if($result>0){
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
		$dataput['kunci'] = $kunci = json_decode($this->delete('kunci'), TRUE);

		if(is_null($kunci)){
			$this->response([
				'status' =>FALSE,
				'pesan' => 'subjek_id belum di isi'
			],RestController::HTTP_BAD_REQUEST);
		} else {
			if($this->genCrudModel->deleteGenCrud($kunci)>0){
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