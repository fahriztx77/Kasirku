<?php
class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    	if(!$this->session->userdata('auth_user')){
    		redirect('account/login');
    	}
    }

    public function login($url=null)
    {

    	if($this->session->userdata('auth_user')){
    		redirect(base_url());
    	}

    	if($url == 'submit' && $this->input->is_ajax_request()){
    		$email 		= $this->input->post('email');
    		$pass 		= $this->input->post('password');

    		$cek 		= UserModel::where('email',$email)->first();

    		if(!@$cek->id){
    			$data['message'] 	= 'Email/Password salah!';
    			$this->restapi->error($data);
    		}

    		if($pass !== DefuseLib::decrypt(@$cek->password)){
    			$data['message']	= 'Email/Password salah!';
    			$this->restapi->error($data);
    		}

    		$this->session->set_userdata('auth_user',DefuseLib::encrypt($cek->email));

    		$data['message']	= 'Selamat datang '.$cek->name.' !';
    		$data['url']		= base_url();
    		$this->restapi->success($data);

    	}else{
	    	$data['__CONFIG']	= ConfigModel::first();
	    	echo $this->blade->draw('website.account.login',$data);
    	}
    }

    public function logout()
    {
    	$this->session->unset_userdata('auth_user');
        redirect('account/login');
    }
}