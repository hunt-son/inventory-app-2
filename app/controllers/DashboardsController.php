<?php

class DashboardController extends \BaseController {

	/**
	 * Display a listing of dashboards
	 *
	 * @return Response
	 */
	public function index()
	{
        $products = Product::all();
        $records = Records::all();
        $projections = Projections::all();

		return View::make('dashboards.index', compact('records', 'products', 'projections'));
	}

	/**
	 * Show the form for creating a new dashboard
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('dashboards.create');
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
		$dashboard = Dashboard::findOrFail($id);

		return View::make('dashboards.show', compact('dashboard'));
	}

	/**
	 * Show the form for editing the specified dashboard.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$dashboard = Dashboard::find($id);

		return View::make('dashboards.edit', compact('dashboard'));
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
		Dashboard::destroy($id);

		return Redirect::route('dashboards.index');
	}

}
