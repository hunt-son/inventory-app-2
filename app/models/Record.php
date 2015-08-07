<?php

class Record extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['status', 'amount', 'authorization', 'inhouse', 'amount', 'action', 'product_id'];


    public function dashboard(){
        return $this -> belongsTo('Dashboard');
    }

    public function daily(){
        return $this -> belongsTo('Daily');
    }

}