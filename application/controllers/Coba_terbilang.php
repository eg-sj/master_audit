<?php 
use RestServer\RestController;
require APPPATH.'/libraries/RestController.php';
require APPPATH.'/libraries/Format.php';

class Coba_terbilang extends RestController{
	function index_get()
	{
		echo ucwords(terbilang(87,5));
	}
}