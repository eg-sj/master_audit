<?php 
use RestServer\RestController;
require APPPATH.'/libraries/RestController.php';
require APPPATH.'/libraries/Format.php';

class RefAll extends RestController{
	public function __construct(){
		parent::__construct();
		$this->load->model('refModel');
	}

	public function index_get(){
		$tabel = $this->get('tabel') ;
		if (substr($tabel, 0, 4) == 'ref_') 
		{$data = $this->refModel->getRef($tabel);}
			else
		{$data = array();}

		if($data){
			$this->response([
				'status' => TRUE,
				'data' => $data
			], RestController::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'pesan' => 'Data tidak ditemukan'
			], RestController::HTTP_NOT_FOUND);
		}
	}


}