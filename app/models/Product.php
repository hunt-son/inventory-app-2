<?php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;


class Product extends \Eloquent implements StaplerableInterface {
    use EloquentTrait;
    use SoftDeletingTrait;

    protected $table = 'products';
    protected $dates = ['deleted_at'];


    protected $fillable = ['name', 'product_id',  'site_link', 'logo', 'product_description', 'price_per_bottle'];

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];


    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('logo', [
            'styles' => [
                'prompt' => '380',
                'thumb' => '100',
                'medium' => '200'
            ]
        ]);

        parent::__construct($attributes);

    }


    public function dashboard()
    {
        $this->belongsTo('Dashboard');
    }
    public function manufacturer()
    {
        $this->hasOne('Manufacturer');
    }
}