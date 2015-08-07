@extends('layouts.base')
@section('body')

<div class="jumbotron" style="background-color: darkslategrey;">
    <h1 style="color: white;">The Owners Page</h1>
</div>

<div class="container">
    <strong>
    <div class="row" style="font-size: 24px;">

        <div class="col-md-3 col-sm-4 col-xs-6" style="margin-left:-22px;">
            <div class="dummy"></div>
            <a href="#" class="metro-thumbnail thumbnail" style="background-color: #1ba1e2; text-decoration-color: #f5f5f5;" data-toggle="modal" data-target="#registerModal"><span class=" glyphicon glyphicon-registration-mark"></span><br><br>Register a User</a>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="dummy"></div>
            <a href="#" class="metro-thumbnail thumbnail" style="background-color:#8cbf26 " data-toggle="modal" data-target="#modifyModal"><span class=" glyphicon glyphicon-blackboard"></span><hr style="height:0pt; margin-top: 2px; visibility:hidden;"/>Modify User Information</a>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="dummy"></div>
            <a href="#x" class="metro-thumbnail thumbnail"  style="background-color:#e671b8"  data-toggle="modal" data-target="#deleteModal"><span class=" glyphicon glyphicon-remove-circle"></span><br><br>Delete a User</a>
        </div>

    </div>
        </strong>
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h1 class="modal-title" id="registerModalLabel"> Register a New User</h1>
                </div>
                <div class="modal-body"><div class="col-md-1"></div>
                    {{ Form::open(array('url' => 'users/create', 'method' => 'GET',  'style' => 'width:500px;', 'class' => 'form-horizontal')) }}
                    <fieldset class="well">
                        <div class="row">
                            <div class="form-group col-md-4">
                                    <label for="username" class="control-label">Username</label>
                                    <input placeholder="JonDoe123" type="text" required="" name="username" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="password" class="control-label">Password:</label>
                                <input placeholder="********" type="password" name="password" class="form-control" id="first_password1"><br>
                                <input placeholder="Repeat Password" type="password" class="form-control" id="match_password1">
                            </div>
                            <div class="row">
                                <p type="text" id="noMatch1" style="display:none;">Passwords Do Not Match</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="email" class="control-label">Email Address</label>
                                <input placeholder='jondoe123&#64greenbracket.com' type="text" required="" name="email" class="form-control">
                            </div>
                        </div>
                    </fieldset>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button>
                        <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancel</span></button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modifyModal" tabindex="-1" role="dialog" aria-labelledby="modiifyModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h1 class="modal-title" id="modifyModalLabel"> Modify a User's Information</h1>
                </div>
                <div class="modal-body"><div class="col-md-1"></div>
                    <fieldset class="well">
                        <div class="row">
                            <ul class="uiList lineBreak">
                            <li class="custom-li">
                                <label for="">Name</label>
                                <select class="selectpicker" id="user_selector">
                                    @foreach ($users as $user)
                                        <option class="user" value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li class="custom-li row">
                                <div class="password-slide"><label for="" class="col-xs-4 " style="padding-left: 0px;">Password</label><p class="col-xs-1">************</p><a href="" class="edit col-xs-offset-4 col-xs-1">Edit</a></div>
                                <div class="content hide" id="temp">
                                    <form id="change-password-form" method="POST" action="/users">
                                        <input type="hidden" id="user_id_for_password" name="id" value="">
                                        <div class="row">
                                            <div class="form-group col-md-5">
                                                <label for="current" class="control-label">Current Password:</label>
                                                <input placeholder="********" type="current" name="old" class="form-control"><br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="password" class="control-label">New Password:</label>
                                                <input placeholder="********" type="password" name="password" class="form-control" id="first_password">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="password" class="control-label">Repeat Password:</label>
                                                <input placeholder="Repeat Password" type="password" class="form-control" id="match_password">
                                            </div>
                                            <div class="row">
                                                <p type="text" id="noMatch" style="display:none;">Passwords Do Not Match</p>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary" type="submit" id="passwordSubmit">Submit</button>
                                            <button class="btn btn-default new-password-cancel" value="Cancel" type="close">Cancel</button>
                                    </form>

                                </div>
                             </li>
                            <li class="custom-li row">
                                <div class="email-slide">
                                <label for="email" class="col-xs-4" style="padding: 0px 0px 0px 0px;">Email Address</label>
                                <p class="col-xs-1" id="user_email"></p><a href="" class="edit2 col-xs-offset-4 col-xs-1">Edit</a>
                                </div>
                                <div class="content hide" id="temp2">
                                    <form id="change-email-form" method="PUT">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="email" class="control-label">New Email:</label>
                                                <input placeholder="" type="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit" id="emailSubmit">Submit</button>
                                        <button class="btn btn-default new-email-cancel" value="Cancel" type="close">Cancel</button>
                                    </form>

                                </div>
                            </li>
                            <li class="custom-li row">
                                <div class="permission-slide">
                                    <label for="permission" class="col-xs-4" style="padding: 0px 0px 0px 0px;">User Role</label>
                                    <p class="col-xs-1" id="user_role"></p><a href="" class="edit3 col-xs-offset-4 col-xs-1">Edit</a>
                                </div>
                                <div class="content hide" id="temp3">
                                    <form id="change-email-form" method="PUT">
                                        <div class="row">
                                            <label for="select">New User Permission: </label><select class="selectpicker"><option value="owner">Owner</option><option value="Administrator">Administrator</option></select>
                                        </div>
                                        <div class="row">
                                            <div class="mtm row"><label class="submit"><input value="Save Changes" disabled="1" type="submit"></label>
                                            <label class="cancel"><input value="Cancel" type="button" class="new-permission-cancel"></label></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                     </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h1 class="modal-title" id="deleteModalLabel"> Delete a User</h1>
                </div>
                <div class="modal-body"><div class="col-md-1"></div>
                    <div class="row">
                        <ul class="uiList lineBreak">
                                <label for="">Name</label>
                                    @foreach ($users as $user)
                                        <li class="form-group">{{$user->username}}
                                        <span class="glyphicon glyphicon-remove pull-right"></span></li>
                                    @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer row">
                        <button>Submit</button>
                        <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancel</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
</div>

<script>
    $('#user_selector').change(function() {
        var thenum = $(this).children(":selected").val();
        $('#user_id_for_password').attr('value', thenum)
        $("#change-email-form").attr("action", "/users/" + thenum);
        $.ajax({
            url: 'role',
            method: 'POST',
            data: {id: thenum}
        }).always(function (response) {
            $('#user_email').html(response['email']);
            $('#user_role').html(response['role']);
            console.log(response['password']);
        });
    });

    $('#match_password').keyup(function() {
        console.log('here');
        if ($('#first_password').val() != $('#match_password').val()) {
            $('#noMatch').show();
            $('#passwordSubmit').prop("disabled",true);
        }
        else  {
            $('#passwordSubmit').prop("disabled", false);
            $('#noMatch').hide();
        }
        });
    $('#match_password1').keyup(function() {
        console.log('here');
        if ($('#first_password1').val() != $('#match_password1').val()) {
            $('#noMatch1').show();
        }
        else  {
            $('#noMatch1').hide();
        }
        });

</script>
@stop




