<?php

use Laracasts\Flash\Flash;
use Laracasts\Flash\FlashNotifier;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class Dashboard extends \Eloquent {
    use SoftDeletingTrait;



    protected $table = 'products';
    protected $dates = ['deleted_at'];

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

    public function getCreatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }


    public function products() {
        $this->hasMany('Product');
    }

}

