<?php

function add_quotes($str) {
    return sprintf("'%s'", $str);
}

$three_week_average = []; $past_three_weeks = []; $days_til_empty = [];

    $product_id = $products->product_id;
    $fourty_five_day_average = Record::where(function($query) use ($product_id)
    {
        $query->where('product_id', $product_id);
        $query->where('updated_at', '>=' , Carbon\Carbon::now() -> subdays(45));
    })->avg('amount');

    if ($fourty_five_day_average != 0) {
        $product_days_til_empty = ($products->inhouse) / $fourty_five_day_average;
    }

    else $product_days_til_empty = 0;


    $product_past_three_weeks = Record::where(function($query) use($product_id) {
        $query->where('product_id', $product_id);
        $query->where('updated_at', '>=' , Carbon\Carbon::now() -> subweeks(3));
    })->avg('amount');

    $three_week_product_average = 0;
    for($three_weeks = Carbon\Carbon::now()->subWeeks(21); $three_weeks->lte(Carbon\Carbon::now()); $three_weeks->addWeeks(3)) {
        $thisAverage = Record::where(function($query) use ($product_id, $three_weeks)
        {
            $query->where('product_id', $product_id);
            $query->where('updated_at', '<=', $three_weeks->addWeeks(3));
            $three_weeks->subWeeks(3);
            $query->where('updated_at', '>=', $three_weeks);
        }) -> avg('amount');

        $three_week_product_average = $thisAverage + $three_week_product_average;



    }
    array_push($three_week_average, $three_week_product_average);
    array_push($past_three_weeks, $product_past_three_weeks);
    array_push($days_til_empty, $product_days_til_empty);


?>


@extends('layouts.base')

@section('body')


    {{--loop logic:--}}
    {{--1) go through the table for each corresponding id that hasn't been chosen yet--}}
    {{--2) extract the date and amount--}}
    {{--3) use the numbers and a good algorithm to record a prediction--}}
    {{--4) create the table--}}
    {{--5) go to the next id--}}
    <div class="mt-50">
        <div class="row">
            <div class="col-xs-6 col-lg-3">
                <img src="{{'/pictures/'.$products->name.".jpg"}}">
            </div>
            <div class="col col-lg-4">
                <h2>Description</h2>
                <h4>{{$products->name}}</h4>
                <p>{{$products->description}}</p>
            </div>
        </div>
        <div class="row" style="margin-top: 50px;">
            <div class="col col-lg-6">
                <h2 style="text-align: center">Product Information</h2>
                <div style="align-content: center; text-align: center">
                        <ul class="lineBreak uiList">
                            <li>Product ID:  {{$product_id}}</li>
                            <li>Date Created:  {{$products->created_at}}</li>
                            <li>Three Week Average: {{$three_week_average[0]}}</li>
                            <li>Fourty Five Day Average: {{$fourty_five_day_average[0]}}</li>
                            <li>Days Until Empty: {{$days_til_empty[0]}}</li>
                            <li>Total Sold To Date:  {{$products->total_sold}}</li>
                            <li>Price Per Bottle: {{$products->price_per_bottle}}</li>
                            <li>Manufacturer Name: {{$products->manufacturer}}</li>
                        </ul>


                </div>
            </div>
        </div>
    </div>
@stop