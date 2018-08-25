<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	#Declaración de variables de autenticación
	public $login = '';
	public $trankey = '';
	public $seed = '';
	public $transactionKey = '';

	public function __construct()
	{
	        parent::__construct();
	        $this->load->library("Nusoap_library"); //cargando mi biblioteca
	        #Asignación de valores de autenticación
	        $this->login = '6dd490faf9cb87a9862245da41170ff2';
			$this->trankey = '024h1IlD';
			$this->seed = date('c');
			$this->transactionKey = sha1($this->seed.$this->trankey,false);			
	}

	public function index()
	{	
		#Obtención del listado de bancos mediante el método getBankList.
		$cliente = new nusoap_client("https://test.placetopay.com/soap/pse/?wsdl",true);   
		$params = array(
						'auth'=>array(
										'login'=>$this->login,
										'tranKey'=>$this->transactionKey,
										'seed'=>$this->seed
									)
					);

		
		$listaBancos = $cliente->call('getBankList',$params);
		$data=$listaBancos;
		$this->load->view('pasarela',$data);
	}

	public function crearTransaccion(){

		$cliente = new nusoap_client("https://test.placetopay.com/soap/pse/?wsdl",true);
        
        #datos transacción
        $bankCode = $this->input->post('bankCode');
		$bankInterface = $this->input->post('bankInterface');
		$ip = $_SERVER['REMOTE_ADDR'];
		$agente = $_SERVER['HTTP_USER_AGENT'];

		#Creación de la transacción y obtención de la URL a la cual se debe redirigir a través del método createTransaction.
		$params = array(
						'auth'=>array(
										'login'=>$this->login,
										'tranKey'=>$this->transactionKey,
										'seed'=>$this->seed
									),
						'transaction'=>array(
										'bankCode'=>$bankCode,
										'bankInterface'=>$bankInterface,
										'returnURL'=>'https://registro.pse.com.co/PSEUserRegister/',
										'reference'=>'123456789',
										'description'=>'pago de pruebas',
										'language'=>'EN',
										'currency'=>'COP',
										'totalAmount'=>100000,
										'taxAmount'=>20000,
										'devolutionBase'=>0,
										'tipAmount'=>0,
										'payer'=>array(
											'documentType'=>'CC',
											'document'=>'1040735600',
											'firstName'=>'David',
											'lastName'=>'sanchez',
											'company'=>'particular',
											'emailAddress'=>'dssb_1989@hotmail.com',
											'address'=>'la estrella',
											'city'=>'la estrella',
											'province'=>'antioquioa',
											'country'=>'CO',
											'phone'=>'123456789',
											'mobile'=>'3125545455',
											'postalCode'=>'0005'

										),
										'buyer'=>array(
											'documentType'=>'CC',
											'document'=>'1040735600',
											'firstName'=>'David',
											'lastName'=>'sanchez',
											'company'=>'particular',
											'emailAddress'=>'dssb_1989@hotmail.com',
											'address'=>'la estrella',
											'city'=>'la estrella',
											'province'=>'antioquioa',
											'country'=>'CO',
											'phone'=>'123456789',
											'mobile'=>'3125545455',
											'postalCode'=>'0005'
										),
										'shipping'=>array(
											'documentType'=>'CC',
											'document'=>'1040735600',
											'firstName'=>'David',
											'lastName'=>'sanchez',
											'company'=>'particular',
											'emailAddress'=>'dssb_1989@hotmail.com',
											'address'=>'la estrella',
											'city'=>'la estrella',
											'province'=>'antioquioa',
											'country'=>'CO',
											'phone'=>'123456789',
											'mobile'=>'3125545455',
											'postalCode'=>'0005'
										),
										'ipAddress'=>$ip,
										'userAgent'=>$agente,
										'additionalData'=>array()

						)
					);

		$respuesta = $cliente->call('createTransaction',$params);
		$respuesta = json_encode($respuesta);
		echo $respuesta;		
	}
}
