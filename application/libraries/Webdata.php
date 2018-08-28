<?php

class Webdata {

	function __construct() {
		$this->ci =& get_instance(); 
		$this->ci->load->library('blade');
		$this->ci->load->library('defuselib');
	}

	public function load($type="public"){
		$__CONFIG		= ConfigModel::first();
		
		$this->errorForm();
		
		$this->ci->blade->share('__MENU','home');
		$this->ci->blade->share('__CONFIG',$__CONFIG);

		$csrf_name 	= $this->ci->security->get_csrf_token_name();
		$csrf_hash 	= $this->ci->security->get_csrf_hash();
		$html 		= '<div style="display:none !important;"><input type="hidden" name="'.$csrf_name.'" value="'.$csrf_hash.'"></div>';

		$this->ci->blade->share('csrf_name',$csrf_name);
		$this->ci->blade->share('csrf_hash',$csrf_hash);
		$this->ci->blade->share('csrf_input',$html);

		if(!$this->ci->session->userdata('auth_user')){
			redirect('account/login');
		}

		if($this->ci->session->userdata('auth_user')){
			$__USER 	= UserModel::where('email',$this->ci->defuselib->decrypt($this->ci->session->userdata('auth_user')))->first();
			$this->ci->blade->share('__USER',$__USER);
			$this->ci->blade->share('__AUTH',true);
		}

		$this->ci->blade->share('ctrl',$this->ci);
	}

	public function user()
	{
		if($this->ci->session->userdata('auth_user')){
			$__USER 	= UserModel::where('email',$this->ci->defuselib->decrypt($this->ci->session->userdata('auth_user')))->first();
			return $__USER;
		}
		return;
	}

	public function show_404($page='website.error.404',array $data=[]){
		$this->load();
		http_response_code();
		http_response_code(404);
		$data['__MENU'] 	= '404';
		echo $this->ci->blade->draw($page,$data);	
		exit();
	}

	private function errorForm(){
		$hasError 				= false;
		$hasSuccess 			= false;
		$errors 				= [];

		if($this->ci->session->userdata('hasSuccess')){
			$hasSuccess 		= $this->ci->session->userdata('hasSuccess');
		}


		if($this->ci->session->userdata('hasError')){
			$hasError 			= $this->ci->session->userdata('hasError');
		}

		if($this->ci->session->userdata('errors')){
			$errors 			= $this->ci->session->userdata('errors');
		}

		$this->ci->blade->share('hasError',$hasError);
		$this->ci->blade->share('hasSuccess',$hasSuccess);
		$this->ci->blade->share('errors',$errors);
	}
}