<?php

class ProductModel extends MY_Model
{
	protected $table = "product";
	protected $appends 	= array('price_text');

	public function getPricetextAttribute()
	{
		return "Rp. ".number_format($this->price,0,',','.');
	}
}