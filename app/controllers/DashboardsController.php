<?php

class DashboardsController extends \BaseController {

	/**
	 * Display a listing of dashboards
	 *
	 * @return Response
	 */
	public function index()
	{

        $products = Product::all();
        $records = Record::all();
        $manufacturers = Manufacturer::all();

		return View::make('Dashboard.index', compact('records', 'products', 'manufacturers'));

	}

	/**
	 * Show the form for creating a new dashboard
	 *
	 * @return Response
	 */
	public function create()
	{

        return 'success';
	}

	/**
	 * Store a newly created dashboard in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Dashboard::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Dashboard::create($data);

		return Redirect::route('dashboards.index');
	}

	/**
	 * Display the specified dashboard.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

        $products = Product::all();
        $records = Record::all();
        $manufacturers = Manufacturer::all();


        return View::make('Dashboard.index', compact('records', 'products', 'manufacturers'));
	}

	/**
	 * Show the form for editing the specified dashboard.
	 *
	 * @param  int  $id
	 * @return Response
	 */
        public function edit($product_id)
    {
        $records = Record::where('product_id', $product_id)->get();
        $products = Product::where('product_id', $product_id)->first();

        return View::make('dashboard.edit', compact('records', 'products'));
    }

	/**
	 * Update the specified dashboard in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$dashboard = Dashboard::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Dashboard::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$dashboard->update($data);

		return Redirect::route('dashboards.index');
	}

	/**
	 * Remove the specified dashboard from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(Product::where('id', $id)->delete() == true) {
            Record::where("id", $id)->delete();
            Daily::where("id", $id)->delete();
            Flash::success('You have deleted a product!');
            return "success";
        } else {
            return "failure";
        }
	}

}
