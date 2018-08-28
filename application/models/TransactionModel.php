<?php

class TransactionModel extends MY_Model
{
	protected $table = "transaction";
	protected $appends 	= array();

	public function product(){
		return $this->hasOne('ProductModel', 'id', 'id_product');
	}

	public function scopeMaster($query){
		return $query->where("master",NULL);
	}
}