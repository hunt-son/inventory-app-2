

@extends('layouts.base')
@section('body')

    <div class="mt-50 daily">
        <img id="record_button" src="/images/green_ball.png">
        <div class="row">
        <form class="horizontal_inventory_form " action="/records" method="POST" style="display: none;">
            <p class="collapsable">[collapse]</p>
            <fieldset class="the-fieldset">
                <div class="row">
                <h2 class="the-legend">Add a New Record</h2>
                </div>
                <div class="recordInputs">
                    <div class="col col-lg-2"></div>
                    <div class="col col-lg-2">
                        <input type="number" class="form-control" id="inputAmount" placeholder="Enter an Amount" name="amount">
                    </div>
                    <div class="col col-lg-1"><strong>
                        <select name="action" class="selectpicker">
                            <option value="trials">trials</option>
                            <option value="rebills">rebills</option>
                            <option value="dp">dp</option>
                            <option value="returned">returned</option>
                            <option value="received">bottles received</option>
                        </select>
                            </strong>
                    </div>
                    <div class="col col-lg-2"></div>
                    <div class="col col-lg-1">
                        <h4>of</h4>
                    </div>
                    <div class="col col-lg-2">
                        <select class="selectpicker" name="product_id">
                            @if ($products->count())
                                @foreach( $products as $product )
                                    <option value="{{$product->product_id}}">{{$product->name}}</option>
                                @endforeach
                            @else <option value="null">No Products Exist</option>
                            @endif
                        </select>
                    </div>
                    <div class="col col-lg-1">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                 </div>
            </fieldset>
        </form>
        </div>

        <div class="accordian">
            <div class="products" id="mainTables" style="padding-bottom: 20px;">
                <div class="row">
                    <legend style="padding-left: 40px;">Products <span class="pull-right"><h6 class="slidable">[slide]</h6></span></legend>
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1">
                            <div class="tab-content">
                                <div class="tab-pane active" id="1">
                                    <table class="table" id="table-entries" >
                                        <thead align="center" style="font-family:times; color:black; background-color:#ffffff">
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th>Running Inventory</th>
                                            <th>Days Left</th>
                                            <th>Weekly Average</th>
                                            <th>Change</th>
                                        </tr>
                                        </thead>

                                        <div class="row-selector">
                                            @if ($products->count())
                                                <tbody align="center" style="font-family:verdana; color:black; background-color:#ffffff">
                                                @foreach( $products as $product )
                                                    <tr style="text-align: left;" rel="{{ $product->id }}">
                                                        <td>{{ strtoupper($product->name) }}</td>
                                                        <td>{{ $product -> inhouse }}</td>
                                                        <td>{{$product -> daysleft}}</td>
                                                        <td>{{$product -> weekly_average}}</td>
                                                        <td>{{$product -> change}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            @endif
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="records" style="padding-bottom: 20px;">
                <div class="row">
                    <legend style="padding-left: 40px;">Daily Inventory Log <span class="pull-right"><h6 class="slidable2">[slide]</h6></span></legend>
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered dataTable" style="text-align: center;" id="recordsTable" >
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Trials</th>
                                    <th>Rebills</th>
                                    <th>DPs</th>
                                    <th>Bottles Returned</th>
                                    <th>Running Inventory</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($dailys->count())
                                    <?php $totalProducts = 0;
                                    $total = 0; ?>
                                    @foreach( $dailys as $daily )
                                        <tr>
                                            <td>{{$daily->name}}</td>
                                            <td>{{abs($daily->trials)}}</td>
                                            <td>{{abs($daily->rebills) }}</td>
                                            <td>{{abs($daily->dp) }}</td>
                                            <td>{{$daily->returned}}</td>
                                            <td>{{$daily->inhouse}}</td>
                                            <td>{{$daily->today}}</td>
                                        </tr>
                                        <?php $totalProducts = $totalProducts + 1; ?>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop