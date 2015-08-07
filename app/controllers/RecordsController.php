<?php

class RecordsController extends \BaseController {

	/**
	 * Display a listing of records
	 *
	 * @return Response
	 */
	public function index()
	{
		$records = Record::all();

		return View::make('Dashboard.index', compact('records'));
	}

	/**
	 * Show the form for creating a new record
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('records.create');
	}

	/**
	 * Store a newly created record in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        if (Input::all() != null) {
            $validator = Validator::make($data = Input::all(), Record::$rules);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
        }
            $data['amount'] = (int)$data['amount'];
            $data['product_id'] = (int)$data['product_id'];
            if ($data['action'] == 'trials' or $data['action'] == 'rebills' or $data['action'] == 'dp') {
                $data['amount'] = -1 * $data['amount'];
            }


        $product = Product::where('product_id',Input::get('product_id'))->first();

        $product_id = $data['product_id'];

        $inhouse = $product->inhouse = Record::where(function($query) use ($product_id, $data)
        {
            $query->where('product_id', $product_id);
            $query->where('action',$data['action']);
        })->sum('amount') + $data['amount'];
        $data['authorization'] = Auth::user()->username;
        Record::create($data);

            $positive_values =  Record::where(function($query) use ($product_id) {
                $query->where('product_id', $product_id);
                    $query->where('action', 'trials')->orWhere('action', 'rebills')->orWhere('action', 'dps');
            }) ->sum('amount');
            $negative_values = Record::where(function($query) use ($product_id) {
                $query->where('product_id', $product_id);
                $query->where('action', 'returned');
            }) ->sum('amount');

        if ($data['action'] != 'received') {
            $total_sold = -$data['amount'] + $positive_values - $negative_values;
        }
        else $total_sold = 0;


        $fourty_five_day_average = Record::where(function($query) use ($product_id) {
            $query->where('updated_at', '>=', Carbon\Carbon::now()->subdays(45));
            $query->where('product_id', $product_id);
        }) ->avg('amount');

        if ($fourty_five_day_average != 0)
            {
                $daysleft = ($inhouse) / $fourty_five_day_average;
            }
            else $daysleft = 0;


        //actually average over 6 weeks
        $average_this_week =  number_format(Record::where(function($query) use ($product_id)
        {
            $query->where('product_id',  $product_id);
            $query->where('created_at', '>=', Carbon\Carbon::now()->subWeeks(6));
        })->avg('amount'), 2);
        //actually the same as average_this_week (for now)
        $average_last_week = number_format(Record::where(function($query) use ($product_id)
        {
            $query->where('product_id',  $product_id);
            $query->where('created_at', '>=', Carbon\Carbon::now()->subWeeks(6));
        })->avg('amount'), 2);
        $one_week_change = 0;
        if ($average_this_week != 0)
        {
            $one_week_change = ($average_this_week - $average_last_week) * 100 /$average_this_week;
        }


    if ($total_sold != 0) {
        Product::where("product_id", $product_id)->update(
            array(
                "inhouse" => $inhouse,
                "daysleft" => $daysleft,
                "weekly_average" => $fourty_five_day_average,
                "change" => $one_week_change,
                "total_sold" => $total_sold
            )
        );
    }
        else {
            Product::where("product_id", $product_id)->update(
                array(
                    "inhouse" => $inhouse,
                    "daysleft" => $daysleft,
                    "weekly_average" => $fourty_five_day_average,
                    "change" => $one_week_change
                )
            );
        }

        $today =  Carbon\carbon::today()->toFormattedDateString();
        $daily = [];
        $daily["inhouse"] = $inhouse;
        $daily[$data['action']] = $data['amount'];
        $daily['today'] = $today;
        $daily['product_id'] = $data['product_id'];

        $dailyRecord = Daily::where(function($query) use ($product_id, $today) {
            $query->where('product_id',$product_id);
            $query->where('today', '==', $today);});
        if($dailyRecord->exists()) {
            $dailyRecord->update(
                array(
                    "inhouse" => $inhouse,
                    $data['action'] => $data['amount'],
                    'today' => $today,
                    'product_id' => $product_id
                )
            );
        }
        else {Daily::create($daily); }



		return Redirect::route('daily.index');
	}

	/**
	 * Display the specified record.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record = Record::findOrFail($id);

		return View::make('records.show', compact('record'));
	}

	/**
	 * Show the form for editing the specified record.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$record = Record::find($id);

		return View::make('records.edit', compact('record'));
	}

	/**
	 * Update the specified record in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$record = Record::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Record::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$record->update($data);

		return Redirect::route('records.index');
	}

	/**
	 * Remove the specified record from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Record::destroy($id);

		return Redirect::route('Dashboard.index');
	}

}
