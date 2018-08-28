<?php
class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->webdata->load();
    }

    public function index()
    {
    	$data['__MENU']		= 'home';
    	$data['product']	= ProductModel::desc()->get();
    	$data['invoice']	= $this->input->cookie('invoice');
    	$data['prod']		= TransactionModel::desc()->where('invoice',$data['invoice'])->get();
       	echo $this->blade->draw('website.home.index',$data);
    }

    public function system($url='index')
    {
    	if($url=='addItem' && $this->input->is_ajax_request()){
    		$qty 		= (($this->input->post('qty')) ? $this->input->post('qty') : 1);
    		$id_product 	= $this->input->post('id_product');
    		$invoice 	= $this->input->post('invoice');

    		$product 		= ProductModel::find($id_product);

    		if(!isset($product->id)) {
    			$json['message']	= 'Product tidak ditemukan';
    			$this->restapi->error($json);
    		}

    		$user 	= @$this->webdata->user();

            $invo           = TransactionModel::where('invoice',$invoice)->where('id_product',$id_product)->first();
            if(!isset($invo->id)){
                $transaction                = new TransactionModel;
                $transaction->id_user       = $user->id;
                $transaction->id_product    = $id_product;
                $transaction->total         = ($qty*$product->price);
                $transaction->qty           = $qty;
                $transaction->invoice       = $invoice;
                $transaction->save();
            }else{
                $invo->qty           = ($invo->qty+$qty);
                $invo->total         = ($invo->qty*$product->price);
                $invo->update();
            }


    		$json['message']	= 'Data telah ditambah';
    		$json['html']		= TransactionModel::where('invoice',$invoice)->master()->first();
    		$this->restapi->success($json);
    	}else if($url=='setCookieInvoice' && $this->input->is_ajax_request()){
    		$this->input->set_cookie('invoice',getInvoice(6),36000);
            $this->restapi->success("ok");
    	}else{
    		echo "work";
    	}
    }
}