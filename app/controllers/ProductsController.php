<?php

class ProductsController extends \BaseController {

	/**
	 * Display a listing of products
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = Product::all();

		return View::make('Dashboard.index', compact('products'));
	}

	/**
	 * Show the form for creating a new product
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('products.create');
	}

	/**
	 * Store a newly created product in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Product::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		Product::create($data);

        $name=strtolower($data['name']);
        $image = imagecreatefrompng(public_path().'/system/Product/logos/000/000/00'.$data['product_id'].'/thumb/'.$name.'.png');
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
        imagejpeg($bg, public_path().'/pictures/'.$data['name'].".jpg", $quality);
        imagedestroy($bg);

        if (Product::where('type', '=', Input::get('type'))->exists() or Product::where('product_id', '=', Input::get('product_id'))->exists()) {
            Flash::error('This Product or Product ID Already Exists');
        }

		return 'success';
	}

	/**
	 * Display the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = Product::findOrFail($id);

		return View::make('products.show', compact('product'));
	}

	/**
	 * Show the form for editing the specified product.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::find($id);

		return View::make('products.edit', compact('product'));
	}

	/**
	 * Update the specified product in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$product = Product::findOrFail($id);
		$validator = Validator::make($data = Input::all(), Product::$rules);


		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$product->update($data);

		return Redirect::route('Dashboard.index');
	}

	/**
	 * Remove the specified product from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id)
    {
        Product::where('id', $id)->forceDelete();
        Record::where('id', $id)->forceDelete();
        Daily::where('id', $id)->forceDelete();
        Flash::success('this product has been permanently removed from the inventory database');
        return 'success';
    }

}
