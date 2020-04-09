<?php 
use RestServer\RestController;
require APPPATH.'/libraries/RestController.php';
require APPPATH.'/libraries/Format.php';

class PkptAll extends RestController{
	public function __construct(){
		parent::__construct();
		$this->load->model('pkptModel','pkpt');
	}

	public function index_get(){
		$tahun = $this->get('tahun');
		if (empty($tahun) OR is_null($tahun)) {
			$tahun = date("Y");
		}
		
		$data = $this->pkpt->getPkpt($tahun);
		// $data = $this->pkpt->getPkpt($tahun);
		
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
		$data_pkpt = [
			'pkpt_objek'=>$this->post('pkpt_objek'),
			'penugasan_kd'=>$this->post('penugasan_kd'),
			'wil_kd'=>$this->post('wil_kd'),
			'tahun'=>$this->post('tahun'),
			'rmp'=>$this->post('rmp'),
			'rpl'=>$this->post('rpl'),
			// 'status'=>$this->post('status')
		];

		if($this->pkpt->createPkptAll($data_pkpt)>0){
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
		$pkpt_id = $this->put('pkpt_id');
		$data_pkpt = [
			'pkpt_objek'=>$this->put('pkpt_objek'),
			'penugasan_kd'=>$this->put('penugasan_kd'),
			'wil_kd'=>$this->put('wil_kd'),
			'tahun'=>$this->put('tahun'),
			'rmp'=>$this->put('rmp'),
			'rpl'=>$this->put('rpl'),
			// 'status'=>$this->put('status')
		];
		// print_r($data_pkpt);
		$result = $this->pkpt->updatePkptAll($data_pkpt, $pkpt_id);

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
		$pkpt_id = $this->delete('pkpt_id');
		if(is_null($pkpt_id)){
			$this->response([
				'status' =>FALSE,
				'pesan' => 'pkpt_id belum di isi'
			],RestController::HTTP_BAD_REQUEST);
		} else {
			if($this->pkpt->deletePkptAll($pkpt_id)>0){
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