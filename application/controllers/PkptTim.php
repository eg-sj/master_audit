<?php 
use RestServer\RestController;
require APPPATH.'/libraries/RestController.php';
require APPPATH.'/libraries/Format.php';

class PkptTim extends RestController{
	public function __construct(){
		parent::__construct();
		$this->load->model('pkptModel','pkpt');
	}

	public function index_get(){
		$pkpt_id = $this->get('pkpt_id');
		$kt_tim = $this->get('kt_tim');
		$data = $this->pkpt->getPkptTim($pkpt_id, $kt_tim);


		if($data){
			$this->response([
				'status' 	=> TRUE,
				'data' 		=> $data
			], RestController::HTTP_OK);
		} else {
			// $data_ganti['kt_kode'] = $data_ganti['kt_nama'] = $data_ganti['pkpt_tim_id'] = $data_ganti['pkpt_id'] = "";
			// $data_ganti['tahun'] =  "";
			// $data_ganti['kt_tim'] = $kt_tim;
			// $data_ganti['tarif_id'] = $data_ganti['jml_tim'] = $data_ganti['jml_hari'] = $data_ganti['tarif'] = $data_ganti['total_tarif'] = 0;

			$data_ganti = array(
				'pkpt_tim_id' => "", 
				'pkpt_id' => $pkpt_id,
				'kt_tim' =>$kt_tim,
				'tarif_id' =>"",
				'jml_tim' =>"",
				'jml_hari' =>"",
				'tahun' =>"",
				'kt_kode' =>"",
				'kt_nama' =>"",
				'tarif' =>"",
				'total_tarif' =>""


				// 'kt_kode' => 0, 
				// 'pkpt_tim_id' => 0, 
				// 'pkpt_id' => $pkpt_id, 
				// 'tahun' => 0, 
				// 'jml_tim' => 0, 
				// 'tahun' => 0, 
				// 'kt_nama' => ""
			);

			$this->response([
				'status' 	=> TRUE,
				'pesan' 	=> 'Data kosong',
				'data' 	=> $data_ganti

			], RestController::HTTP_OK);
		}

		// print_r($data);
	}


	// public function index_get(){
	// 	$pkpt_id = $this->get('pkpt_id');
	// 	$kt_tim=0;

	// 	$this->get('kt_tim')!==null?$kt_tim = $this->get('kt_tim'):$kt_tim = 0;

	// 	$data = $this->pkpt->getPkptTim($pkpt_id, $kt_tim);


	// 	if($data AND $kt_tim>0){
	// 		$this->response([
	// 			'status' 	=> TRUE,
	// 			'data' 		=> $data
	// 		], RestController::HTTP_OK);
	// 	} else {
	// 		// $data_ganti['kt_kode'] = $data_ganti['kt_nama'] = $data_ganti['pkpt_tim_id'] = $data_ganti['pkpt_id'] = "";
	// 		// $data_ganti['tahun'] =  "";
	// 		// $data_ganti['kt_tim'] = $kt_tim;
	// 		// $data_ganti['tarif_id'] = $data_ganti['jml_tim'] = $data_ganti['jml_hari'] = $data_ganti['tarif'] = $data_ganti['total_tarif'] = 0;

	// 		$data_ganti = array(
	// 			'kt_kode' => 0, 
	// 			'pkpt_tim_id' => 0, 
	// 			'pkpt_id' => $pkpt_id, 
	// 			'tahun' => 0, 
	// 			'jml_tim' => 0, 
	// 			'tahun' => 0, 
	// 			'kt_nama' => ""
	// 		);

	// 		$this->response([
	// 			'status' 	=> TRUE,
	// 			'pesan' 	=> 'Data kosong',
	// 			'data' 	=> array($data_ganti)

	// 		], RestController::HTTP_OK);
	// 	}

	// 	print_r($data);
	// }


	public function index_post(){
		$data_pkpt_tim = [
			// 'pkpt_tim_id' => $this->post('pkpt_tim_id'),
			'pkpt_id' => $this->post('pkpt_id'),
			'kt_tim' => $this->post('kt_tim'),
			// 'tarif_id' => $this->post('tarif_id'),
			'jml_tim' => $this->post('jml_tim'),
			'jml_hari' => $this->post('jml_hari')
		];

		$pkpt_id = 	$this->post('pkpt_id');
		$kt_tim = 	$this->post('kt_tim');
		// $all=$this->post();
		$ada = $this->pkpt->getPkptTim($pkpt_id, $kt_tim);
		// echo "ada = "; echo $ada['pkpt_id']; 
		// // echo "<br>";
		// echo $pkpt_id;
		// echo $kt_tim;

		if ($ada['pkpt_id']>0) {
			// echo "aksi = update";
			$aksi = $this->pkpt->updatePkptTim($data_pkpt_tim);

			if($aksi>0){
				$this->response([
					'status' => TRUE,
					'pesan' => 'Data berhasil update'
				],RestController::HTTP_CREATED);
			} else {
				$this->response([
					'status' => FALSE,
					'pesan' => 'Data gagal update'
				// ],RestController::HTTP_BAD_REQUEST);
				],RestController::HTTP_OK);
			}

		} else {
			// echo "aksi = insert";
			$aksi = $this->pkpt->createPkptTim($data_pkpt_tim);
			if($aksi>0){
				$this->response([
					'status' => TRUE,
					'pesan' => 'Data berhasil ditambahkan'
				],RestController::HTTP_CREATED);
			} else {
				$this->response([
					'status' => FALSE,
					'pesan' => 'Data gagal ditambahkan'
				// ],RestController::HTTP_BAD_REQUEST);
				],RestController::HTTP_OK);
			}

		}

	}

// 	public function index_put(){
// 		$data_pkpt_tim = [
// 			'pkpt_id' => $this->put('pkpt_id'),
// 			'kt_tim' => $this->put('kt_tim'),
// 			// 'tarif_id' => $this->put('tarif_id'),
// 			'jml_tim' => $this->put('jml_tim'),
// 			'jml_hari' => $this->put('jml_hari')
			
// 		];
// 		// $this->pkpt->createPkptTim($data_pkpt_tim);
// 		// $this->pkpt->updatePkptTim($data_pkpt_tim);
// // print_r($data_pkpt_tim);


// 		if($data_pkpt_tim){
// 			$this->response([
// 				'status' => TRUE,
// 				'pesan' => 'Data berhasil perbaharui'
// 			],RestController::HTTP_CREATED);
// 		} else {
// 			$this->response([
// 				'status' => FALSE,
// 				'pesan' => 'Data gagal diperbaharui'
// 			],RestController::HTTP_BAD_REQUEST);
// 		}

// 	}

	public function index_delete(){
		$pkpt_tim_id = $this->delete('pkpt_tim_id');
		if(is_null($pkpt_id)){
			$this->response([
				'status' =>FALSE,
				'pesan' => 'pkpt_id belum di isi'
			],RestController::HTTP_BAD_REQUEST);
		} else {
			if($this->pkpt->deletePkptTim($pkpt_tim_id)>0){
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