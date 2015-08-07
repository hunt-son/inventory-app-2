<?php
$user = Auth::user();
 $deleted_products = Product::onlyTrashed()->get();
?>



@extends('layouts.base')
@section('body')
@section('body')
     <div class="mt-50">
        <div class="row">
            <div class="col col-lg-3">
                <div class="row">
                    <ul class="nav nav-pills nav-stacked" id="nav-menu">
                        <li class="current active" id="products-tab"><a href="products">Products <span class="sr-only">(current)</span></a></li>
                        <li><a href="records">Inventory Log</a></li>
                        <li id="forms"><a href="availableForms">Forms</a></li>
                        <li><a href="supplyChain">Product Supply Chain</a></li>
                        @if(Auth::getUser()->hasRole('Owner') and Product::onlyTrashed()->first() != null)
                        <li><a href="deletedInventory">Deleted Products</a></li>
                         @endif
                    </ul>
                </div>
            </div>
            <div class="col col-lg-9">
                <div class="row">
                    <div class="products_container" id="products">
                        <div class="row"><button class="btn btn-default pull-left"  style="margin-left: 25px; margin-bottom: 20px;"><a href="/?forms" id="showAvailableForms">New Product</a></button></div>
                        @foreach( $products as $product )
                            <div class="col-xs-6 col-lg-3 thumbnail" id="thumbnail" rel="{{$product->id}}">
                                @if ($user->hasRole('Owner'))
                                <a href="" class="glyphicon glyphicon-remove" data-href="" data-toggle="modal" data-target="#{{$product->product_id}}"><i class="fa fa-trash"></i></a>
                                <div class="modal fade" id="{{$product->product_id}}" tabindex="-1" role="dialog" aria-labelledby="confirmDelete"  aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                                            </div>

                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this product?</p>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <a class="btn btn-danger confirm-remove">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="glyphicon glyphicon-edit" data-placement="bottom" data-toggle="popover" data-title="Edit Your Product" data-container="body" type="button" data-html="true" href="#"></a>

                                <div id="" class="hide popover-content">
                                    <div class="form-group">
                                        <label>Change</label>
                                        <select class="form-control change_input">
                                            <option value="text" rel="text">Name</option>
                                            <option value="text-area" rel="text-area">Description</option>
                                            <option value="select" rel="select">Manufacturer</option>
                                            <option value="browse" rel="browse">Image</option>
                                        </select>
                                        <h4>to</h4>
                                        {{Form::open(['url' => '/products/'.$product->id, 'method' => 'PUT', 'name'=>'editProduct', 'files' => true]) }}
                                        <div class="input-fields">
                                            <div class="current_input" id="text" style="display:none;">
                                                <input type="text" class="form-control" style="width:200px;" name="name" value="{{$product->name}}">
                                            </div>
                                            <div id="text-area" style="display:none;"><textarea type="text" class="form-control" name="description">{{$product->description}}</textarea></div>
                                            <div id="select" style="display:none;">
                                                <select name="manufacturer" class="selectpicker">
                                                    @if ($manufacturers->count())
                                                        @foreach( $manufacturers as $manufacturer )
                                                            <option value="{{$manufacturer->name}}"<? $product->manufacturer == $manufacturer->name ? ' selected="selected"' : '' ?>>{{$manufacturer->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group" id="browse" style="display:none;">
                                                {{ Form::label('logo', 'Product Image') . Form::file('logo', $attributes = array('id' =>'thisImage')) }}
                                                <p class="help-block">png or jpg files are accepted.</p>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="margin-top: 7px;">Modify »</button>
                                        {{Form::close()}}
                                    </div>
                                </div>
                                @endif
                                <a href="/Dashboard/{{ $product->product_id  }}/edit">
                                <img src="{{'/pictures/'.$product->name.".jpg"}}">
                                <h3>{{$product->name}}</h3>
                                <ul class="move-left">
                                    <li>Running Inventory: {{$product->inhouse}}</li>
                                    <li>Days Left: {{$product->daysleft}}</li>
                                </ul>
                            </a>
                        </div>
                        @endforeach
                    </div>

                </div>

                <div class="products_container" id="availableForms">
                    <div class="row">
                        <div class="navbarForForms">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active-form" id="NewProduct"><a href="#">New Product</a></li>
                                <li id="NewManufacturer"><a href="#">New Manufacturer</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">

                        <div class="active-form aForm" id="formNewProduct">
                            {{Form::open(['url' => action('ProductsController@store'), 'method' => 'POST', 'name'=>'newProduct', 'files' => true]) }}
                            <fieldset class="the-fieldset">
                                <div class="row">
                                    <h2 style="text-align: center; padding-bottom: 10px;">Create a New Product</h2>
                                    <div class="col-xs-11 col-xs-offset-1">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" id="thisName">
                                        <label>Product ID</label>
                                        <input type="text" name="product_id" id="thisId">
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('logo', 'Product Image') . Form::file('logo', $attributes = array('id' =>'thisImage')) }}
                                        <p class="help-block">png or jpg files are accepted.</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Product Description</label>
                                        <textarea class="form-control" name="description" rows="2" placeholder="Describe What The Product Does"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Site Link</label>
                                        {{Form::url('site_link', 'http://', array('id' => "thisLink", )) }}
                                    </div>
                                    <div class="form-group">
                                        <label>Price Per Bottle</label>
                                        <input type="currency" name="price_per_bottle" id="thisPrice" placeholder="$$">
                                    </div>
                                    <div class="form-group">
                                        <label>Manufacturer</label>
                                        <select class="selectpicker" id="select" name="manufacturer">
                                            @if ($manufacturers->count())
                                                @foreach( $products as $product )
                                                    <option value={{$product->manufacturer}}>{{$product->manufacturer}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="button-group pull-right" style="padding-bottom: 20px;">
                                        <input type="submit" class="btn btn-primary submitButton" value="Submit" style="margin-left:10px; position: relative;">
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                    </div>
                                </div>
                            </fieldset>
                            {{Form::close()}}
                        </div>
                        <div class="aForm"  id="formNewManufacturer">
                            {{Form::open(['url' => action('ManufacturersController@store'), 'method' => 'POST', 'name'=>'newManufacturer']) }}
                            <fieldset class="the-fieldset">
                                <div class="row">
                                    <h2 class="text-center" style="padding-bottom: 10px;">Manufacturer Information</h2>
                                    <div class="manufacturer_container">

                                        <div class="col col-lg-3"></div>
                                        <div class="col col-lg-9">
                                            <div class="form-group">
                                                <label class="control-label" for="name">Name:</label><input type="text" name="name" class="fom-control" ><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="address">Address:</label><input type="text" name="address" class="fom-control" ><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="city">City:</label><input type="text" name="city" class="fom-control0" ><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="state">State:</label><input type="text" name="state" class="fom-control" ><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="zip">Zip Code:</label><input type="text" name="zip" class="fom-control" ><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="website">Website:</label><input type="url" name="website" class="fom-control" ><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="phone">Phone Number:</label><input type="text" name="phone" class="fom-control" ><br>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="email">Email:</label><input type="text" name="email" class="fom-control" ><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom: 20px;">
                                    <div class="button-group pull-right">
                                        <input type="submit" class="btn btn-primary submitButton" value="Submit" style="margin-left:10px; position: relative;">
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                    </div>
                                </div>
                            </fieldset>
                            {{Form::close()}}
                            </div>
                    </div>
                </div>

                <div id="records" class="products_container">
                    <div class="row">
                        <div class="col col-lg-1"></div>
                        <div class="col col-lg-11">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered dataTable" style="text-align: center;" id="recordsTable" >
                                <thead  >
                                <tr>
                                    <th>Product Name</th>
                                    <th>Action</th>
                                    <th>Quantity</th>
                                    <th>Authorization</th>
                                    <th>Time Recorded</th>
                                    <th>Remove?</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($products->count())
                                    <?php $totalProducts = 0;
                                    $total = 0; ?>
                                    @foreach( $records as $entry )
                                        <tr>
                                            <td>{{$entry->name}}</td>
                                            <td>{{$entry->action}}</td>
                                            <td>{{abs($entry->amount) }}</td>
                                            <td>{{$entry->authorization}}</td>
                                            <td>{{$entry->updated_at}}</td>
                                            <td><span rel="{{$entry->id}}" class="glyphicon glyphicon-remove" id="record-{{$entry->id}}"></span></td>
                                        </tr>
                                        @if ($user->hasRole('Owner'))
                                            <script>$('#record-{{$entry->id}}').addClass('record-remove');</script>
                                        @else
                                            <script>$('#record-{{$entry->id}}').click(function() {alert('You have to be an Owner to delete a record');}); </script>
                                        @endif
                                        <?php $totalProducts = $totalProducts + 1; ?>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="howManyRecordsExist">
                                @if (! $products->count()) {{'There are no records currently'}} @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div id="supplyChain" class="products_container">
                    <h1 style="text-align: center;"><u>Manufacturers</u></h1>
                    <div class="row">
                    @foreach($manufacturers as $info)
                            <div class="col col-lg-1"></div>
                        <div class="information col-xs-3">
                            <h2>
                                <span>
                                    <div>{{$info->name}}</div>
                                </span>
                            </h2>
                            <div class="addressinfo">
                                <address class="bid-add-text">
                                    <span>
                                        {{$info->address}}
                                    <br>
                                    </span>
                                    <span>
                                        {{$info->city}}, {{strtoupper($info->state)}} {{$info->zip}}
                                        <br>
                                    </span>
                                    <span>
                                        {{$info->phone}}
                                        <br>
                                    </span>
                                    <span>
                                        <a href="email:" + {{$info->email}}>{{$info->email}}</a>
                                    </span>
                                </address>
                            </div>
                            <p><a class="manufacturerWebsite" href={{$info->wesite}}>Visit Website</a></p>
                        </div>

                    @endforeach
                    </div>
                    <div class="product_location">
                        <h1 style="text-align: center"><u>Products</u></h1>
                            <ul class="uiList lineBreak">
                                @foreach($products as $product)
                                <div class="row"><li class="form-group"><label for="name" class="col-xs-2">Name</label><span class="col-xs-2">{{$product->name}}</span><label for="manufacturer" class="col-xs-2 col-xs-offset-1">Manufacturer</label><span class="col-xs-2">{{$product->manufacturer}}</span></li></div>
                                @endforeach
                            </ul>

                    </div>
                </div>
                <div class="products_container" id="deletedInventory">
                    <table class="table" id="table-entries" >
                        <thead align="center" style="font-family:times; color:black; background-color:#ffffff">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Product Information</th>
                            <th scope="col">Records History</th>
                            <th scope="col">Remove Permanently</th>
                        </tr>
                        </thead>

                        <div class="row-selector">
                                <tbody align="center" style="font-family:verdana; color:black; background-color:#ffffff; text-align: left;">

                                    @foreach($deleted_products as $product)
                                        <tr rel="{{ $product->id }}">
                                            <td>{{ $product->name }}</td>
                                            <td><button type="button" class="btn btn-primary" id="info{{$product->id}}" data-toggle="modal" data-target="#deletedInfo{{$product->id}}">View</button></td>
                                            <td><button type="button" class="btn btn-default"  id="history{{$product->id}}" data-toggle="modal" data-target="#deletedHistory{{$product->id}}">View</button></td>
                                            <td><button type="button" class="btn btn-danger btn-mini" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#deleteProduct{{$product->id}}">Delete</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </div>
                    </table>
                    @foreach($deleted_products as $product)
                    <div class="modal fade" id="deleteProduct{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Remove Product Permanently</h4>
                                </div>
                                <div class="modal-body">
                                    Once you click Okay, you'll never be able to retrieve ANY data about this product again!!
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Never Mind</button>
                                    <button type="submit" class="btn btn-danger" id="remove-product-{{$product->id}}" onclick="permanentDelete()">Okay</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deletedInfo{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="titleInfo{{$product->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="titleInfo{{$product->id}}">Information from {{$product->name}}</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="mt-50">
                                        <div class="row">
                                            <div class="col-xs-6 col-lg-3">
                                                <img src="{{'/pictures/'.$product->name.".jpg"}}">
                                            </div>
                                            <div class="col col-lg-4">
                                                <h2>Description</h2>
                                                <h4>{{$product->name}}</h4>
                                                <p>{{$product->description}}</p>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px;">
                                            <div class="col col-lg-6">
                                                <h2 style="text-align: center">Product Information</h2>
                                                <div style="align-content: center; text-align: center">
                                                    <ul class="lineBreak uiList">
                                                        <li>Product ID:  {{$product->product_id}}</li>
                                                        <li>Date Created:  {{$product->created_at}}</li>
                                                        <li>Total Sold To Date:  {{$product->total_sold}}</li>
                                                        <li>Price Per Bottle: {{$product->price_per_bottle}}</li>
                                                        <li>Manufacturer Name: {{$product->manufacturer}}</li>
                                                        <li>Website: {{$product->site_link}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deletedHistory{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="historyinfo{{$product->id}}">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="historyinfo{{$product->id}}">{{$product->name}} Records</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered dataTable" style="text-align: center;" >
                                        <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Quantity</th>
                                            <th>Authorization</th>
                                            <th>Time Recorded</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $entry)
                                            @if($entry->product_id == $product->product_id)
                                                <tr>
                                                    <td>{{$entry->action}}</td>
                                                    <td>{{abs($entry->amount) }}</td>
                                                    <td>{{$entry->authorization}}</td>
                                                    <td>{{$entry->updated_at}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <script>
        function permanentDelete() {
            console.log('here');
            $this = $(this).attr('id');
            $.ajax({
                url: '/products/' + $this,
                method: "DELETE"
            }).always(function (response) {
                if (response == 'success') {
                    location.reload();
                }
                else {
                    alert('Product Failed To Delete');
                }
            });
        };

    </script>
   @stop